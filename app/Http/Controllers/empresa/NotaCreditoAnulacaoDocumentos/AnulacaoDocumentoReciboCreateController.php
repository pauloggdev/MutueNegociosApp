<?php

namespace App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\NotaCreditoAnulacaoDocumentoRepository;
use App\Repositories\Empresa\ReciboRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class AnulacaoDocumentoReciboCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $notaCredito;
    public $reciboSearch;
    private $notaCreditoAnulacaoDocumentoRepository;
    private $clienteRepository;
    private $reciboRepository;


    public function boot(
        NotaCreditoAnulacaoDocumentoRepository $notaCreditoAnulacaoDocumentoRepository,
        ClienteRepository $clienteRepository,
        ReciboRepository $reciboRepository
    ) {
        $this->notaCreditoAnulacaoDocumentoRepository = $notaCreditoAnulacaoDocumentoRepository;
        $this->clienteRepository = $clienteRepository;
        $this->reciboRepository = $reciboRepository;
        $this->setarValorInicial();
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

        // $this->facturaSearch = strtoupper($this->facturaSearch);
        $data['recibo'] = array();
        if (strlen($this->reciboSearch) > 2) {
            $this->reciboSearch = strtoupper($this->reciboSearch);
            $data['recibo'] = $this->reciboRepository->buscarReciboPelaNumeracao($this->reciboSearch);


            if ($data['recibo']) {
                $this->notaCredito['recibo'] = $data['recibo'];
                $data['saldoCliente'] = $this->clienteRepository->mostrarSaldoAtualDoCliente($data['recibo']['cliente_id']);
            }
        }

        return view('empresa.NotaCreditoAnulacaoDocumento.createRecibo', $data);
    }


    public function emitirNotaCreditoAnularRecibo()
    {
        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])

            ];
        }


        $rules = [
            'notaCredito.descricao' => 'required',
            'reciboSearch' => [function ($attr, $reciboSearch, $fail) {

                if (!$this->notaCredito['recibo'] or !$this->reciboSearch) {
                    $fail('Recibo não encontrado');
                    return;
                }
            }]
        ];
        $messages = [
            'notaCredito.descricao.required' => 'Informe uma observação'
        ];

        $this->validate($rules, $messages);

        //Faltando verificar se já foi emitido documento com datas anterior
        $notaCredito = $this->notaCreditoAnulacaoDocumentoRepository->salvarNotaCreditoAnularRecibo($this->notaCredito);

        $this->setarValorInicial();
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => 'OK',
            'showCancelButton' => false,
            'icon' => "info",

        ]);

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'ReciboAnuladoCredito',
                'report_jrxml' => 'ReciboAnuladoCredito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $logotipo,
                    'docAnuladoId' => $notaCredito['id'],
                    'factura_id' => $notaCredito['recibo']['factura']['id']
                ]

            ]
        );
        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function setarValorInicial()
    {

        $this->reciboSearch = NULL;
        $this->notaCredito['descricao'] = NULL;
        $this->notaCredito['recibo']['nome_do_cliente'] = NULL;
        $this->notaCredito['recibo']['nif_cliente'] = NULL;
        $this->notaCredito['recibo']['conta_corrente_cliente'] = NULL;
        $this->notaCredito['recibo']['factura']['numeracaoFactura'] = NULL;
        $this->notaCredito['recibo']['valor_total_entregue'] = NULL;
        $this->notaCredito['descricao'] = NULL;
    }
}
