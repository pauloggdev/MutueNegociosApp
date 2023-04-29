<?php

namespace App\Http\Controllers\empresa\NotaDebitoSaldoCliente;

use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\NotaDebitoSaldoClienteRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use NumberFormatter;

class NotaDebitoCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $notaDebito;
    public $clienteId;
    private $notaDebitoSaldoClienteRepository;
    private $clienteRepository;

    public function boot(NotaDebitoSaldoClienteRepository $notaDebitoSaldoClienteRepository, ClienteRepository $clienteRepository)
    {
        $this->notaDebitoSaldoClienteRepository = $notaDebitoSaldoClienteRepository;
        $this->clienteRepository = $clienteRepository;
    }
    public function mount()
    {
        $this->setarValorPadrao();
    }
    public function render()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data['clientes'] = $this->clienteRepository->listarClienteSemConsumidorFinal();

        return view('empresa.notaDebitoSaldoCliente.create', $data);
    }
    public function updatedClienteId($cliente)
    {
        if ($cliente) {
            $cliente = json_decode($cliente);
            $this->notaDebito['cliente_saldo'] = $this->clienteRepository->mostrarSaldoAtualDoCliente($cliente->id);
            $this->notaDebito['cliente_nome'] = $cliente->nome;
            $this->notaDebito['cliente_id'] = $cliente->id;
            $this->notaDebito['cliente_conta_corrente'] = $cliente->conta_corrente;
            $this->notaDebito['telefone_cliente'] = $cliente->telefone_cliente;
            $this->notaDebito['nif_cliente'] = $cliente->nif;
            $this->notaDebito['email_cliente'] = $cliente->email;
            $this->notaDebito['endereco'] = $cliente->endereco;
            $this->notaDebito['valor_credito'] = NULL;
            $this->notaDebito['descricao'] = NULL;
        } else {
            $this->notaDebito['cliente_saldo'] = NULL;
            $this->notaDebito['cliente_nome'] = NULL;
            $this->notaDebito['cliente_id'] = NULL;
            $this->notaDebito['cliente_conta_corrente'] = NULL;
            $this->notaDebito['telefone_cliente'] = NULL;
            $this->notaDebito['nif_cliente'] = NULL;
            $this->notaDebito['email_cliente'] = NULL;
            $this->notaDebito['valor_credito'] = NULL;
            $this->notaDebito['endereco'] = NULL;
            $this->notaDebito['descricao'] = NULL;
        }
    }


    public function emitirNotaDebito()
    {

        $verificadorDocumento = new VerificadorDocumento('notas_debito_clientes');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual("numeracaoNotaDebito")) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])

            ];
        }


        $rules = [
            'notaDebito.cliente_id' => 'required',
            'notaDebito.valor_debito' => ["required"],
            'notaDebito.descricao' => 'required',
        ];
        $messages = [
            'notaDebito.cliente_id.required' => 'Informe o cliente',
            'notaDebito.valor_debito.required' => 'Informe o valor a débitar',
            'notaDebito.descricao.required' => 'Informe uma observação'
        ];

        $this->validate($rules, $messages);

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $this->notaDebito['valor_extenso'] = $f->format($this->notaDebito['valor_credito']);

        //Faltando verificar se já foi emitido documento com datas anterior
        $notaDebito = $this->notaDebitoSaldoClienteRepository->salvarNotaDebitoSaldoCliente($this->notaDebito);
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => 'OK',
            'showCancelButton' => false,
            'icon' => 'info',
        ]);
        $this->setarValorPadrao();

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'notaDebito',
                'report_jrxml' => 'notaDebito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'empresa_id' => auth()->user()->empresa_id,
                    'notaDebitoId' => $notaDebito->id,
                    'logotipo' => $logotipo
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function setarValorPadrao()
    {
        $this->clienteId = NULL;
        $this->notaDebito['cliente_saldo'] = 0;
        $this->notaDebito['cliente_nome'] = NULL;
        $this->notaDebito['cliente_id'] = NULL;
        $this->notaDebito['cliente_conta_corrente'] = NULL;
        $this->notaDebito['telefone_cliente'] = NULL;
        $this->notaDebito['nif_cliente'] = NULL;
        $this->notaDebito['email_cliente'] = NULL;
        $this->notaDebito['valor_credito'] = NULL;
        $this->notaDebito['valor_debito'] = NULL;
        $this->notaDebito['endereco'] = NULL;
        $this->notaDebito['descricao'] = NULL;
    }
}
