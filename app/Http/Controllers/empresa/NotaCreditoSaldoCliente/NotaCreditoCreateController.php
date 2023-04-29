<?php

namespace App\Http\Controllers\empresa\NotaCreditoSaldoCliente;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\FormaPagamentoRepository;
use App\Repositories\Empresa\NotaCreditoSaldoClienteRepository;
use App\Repositories\Empresa\ReciboRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Controllers\empresa\VerificadorDocumento;

use NumberFormatter;

class NotaCreditoCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $notaCredito;
    public $clienteId;
    private $notaCreditoSaldoClienteRepository;
    private $clienteRepository;

    public function boot(NotaCreditoSaldoClienteRepository $notaCreditoSaldoClienteRepository, ClienteRepository $clienteRepository)
    {
        $this->notaCreditoSaldoClienteRepository = $notaCreditoSaldoClienteRepository;
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

        return view('empresa.notaCreditoSaldoCliente.create', $data);
    }
    public function updatedClienteId($cliente)
    {
        if ($cliente) {
            $cliente = json_decode($cliente);
            $this->notaCredito['cliente_saldo'] = $this->clienteRepository->mostrarSaldoAtualDoCliente($cliente->id);
            $this->notaCredito['cliente_nome'] = $cliente->nome;
            $this->notaCredito['cliente_id'] = $cliente->id;
            $this->notaCredito['cliente_conta_corrente'] = $cliente->conta_corrente;
            $this->notaCredito['telefone_cliente'] = $cliente->telefone_cliente;
            $this->notaCredito['nif_cliente'] = $cliente->nif;
            $this->notaCredito['email_cliente'] = $cliente->email;
            $this->notaCredito['endereco'] = $cliente->endereco;
            $this->notaCredito['valor_credito'] = NULL;
            $this->notaCredito['descricao'] = NULL;
        } else {
            $this->notaCredito['cliente_saldo'] = NULL;
            $this->notaCredito['cliente_nome'] = NULL;
            $this->notaCredito['cliente_id'] = NULL;
            $this->notaCredito['cliente_conta_corrente'] = NULL;
            $this->notaCredito['telefone_cliente'] = NULL;
            $this->notaCredito['nif_cliente'] = NULL;
            $this->notaCredito['email_cliente'] = NULL;
            $this->notaCredito['valor_credito'] = NULL;
            $this->notaCredito['endereco'] = NULL;
            $this->notaCredito['descricao'] = NULL;
        }
    }


    public function emitirNotaCredito()
    {
        $verificadorDocumento = new VerificadorDocumento('notas_credito');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual("numeracaoDocumento")) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])

            ];
        }



        $rules = [
            'notaCredito.cliente_id' => 'required',
            'notaCredito.valor_credito' => ["required"],
            'notaCredito.descricao' => 'required',
        ];
        $messages = [
            'notaCredito.cliente_id.required' => 'Informe o cliente',
            'notaCredito.valor_credito.required' => 'Informe o valor do crédito',
            'notaCredito.descricao.required' => 'Informe uma observação'
        ];

        $this->validate($rules, $messages);

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $this->notaCredito['valor_extenso'] = $f->format($this->notaCredito['valor_credito']);

        //Faltando verificar se já foi emitido documento com datas anterior
        $notaCredito = $this->notaCreditoSaldoClienteRepository->salvarNotaCreditoSaldoCliente($this->notaCredito);
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        // $this->alert('success', 'Operação realizada com sucesso');
        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => 'OK',
            'showCancelButton' => false,
            'icon' => 'info',


        ]);

        $this->setarValorPadrao();

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'notaCredito',
                'report_jrxml' => 'notaCredito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'empresa_id' => auth()->user()->empresa_id,
                    'notaCreditoId' => $notaCredito->id,
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
        $this->notaCredito['cliente_saldo'] = 0;
        $this->notaCredito['cliente_nome'] = NULL;
        $this->notaCredito['cliente_id'] = NULL;
        $this->notaCredito['cliente_conta_corrente'] = NULL;
        $this->notaCredito['telefone_cliente'] = NULL;
        $this->notaCredito['nif_cliente'] = NULL;
        $this->notaCredito['email_cliente'] = NULL;
        $this->notaCredito['valor_credito'] = NULL;
        $this->notaCredito['endereco'] = NULL;
        $this->notaCredito['descricao'] = NULL;
    }
}
