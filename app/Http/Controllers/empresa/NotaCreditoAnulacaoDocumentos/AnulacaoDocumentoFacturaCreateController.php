<?php

namespace App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\NotaCreditoAnulacaoDocumentoRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class AnulacaoDocumentoFacturaCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $notaCredito;
    public $facturaSearch;
    public $retornarStock = true;
    private $notaCreditoAnulacaoDocumentoRepository;
    private $clienteRepository;
    private $facturaRepository;


    public function boot(
        NotaCreditoAnulacaoDocumentoRepository $notaCreditoAnulacaoDocumentoRepository,
        ClienteRepository $clienteRepository,
        FacturaRepository $facturaRepository
    ) {
        $this->notaCreditoAnulacaoDocumentoRepository = $notaCreditoAnulacaoDocumentoRepository;
        $this->clienteRepository = $clienteRepository;
        $this->facturaRepository = $facturaRepository;
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
        $data['factura'] = array();
        if (strlen($this->facturaSearch) > 2) {


            $this->facturaSearch = strtoupper($this->facturaSearch);
            $data['factura'] = $this->facturaRepository->buscarFacturaPelaNumeracao($this->facturaSearch);

            if ($data['factura']) {
                $this->notaCredito['factura'] = $data['factura'];
                $this->notaCredito['retornarStock'] = $this->retornarStock;
                $data['saldoCliente'] = $this->clienteRepository->mostrarSaldoAtualDoCliente($data['factura']['cliente_id']);
            }
        }

        return view('empresa.NotaCreditoAnulacaoDocumento.createFactura', $data);
    }


    public function emitirNotaCreditoAnularFactura()
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
            'facturaSearch' => [function ($attr, $facturaSearch, $fail) {

                if (!$this->notaCredito or !$this->facturaSearch) {
                    $fail('Factura não encontrada');
                    return;
                }
                if ($this->facturaRepository->verificarFacturaContemRecibo($this->notaCredito['factura']['id'])) {
                    $fail('Está factura contém recibo, deves anular o recibo');
                    return;
                }
            }]
        ];
        $messages = [
            'notaCredito.descricao.required' => 'Informe uma observação'
        ];

        $this->validate($rules, $messages);

        //Faltando verificar se já foi emitido documento com datas anterior
        $notaCredito = $this->notaCreditoAnulacaoDocumentoRepository->salvarNotaCreditoAnularFactura($this->notaCredito);
        $this->setarValorInicial();
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => 'OK',
            'showCancelButton' => false,
            'icon' => "info",

        ]);

        $DIR = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/';



        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'FacturaAnuladoCredito',
                'report_jrxml' => 'FacturaAnuladoCredito.jrxml',
                'report_parameters' => [

                    'viaImpressao' => 1,
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $logotipo,
                    'facturaId' => $notaCredito->facturaId,
                    'docAnuladoId' => $notaCredito->id,
                    'dirSubreportBanco' => $DIR,
                    'dirSubreportTaxa' => $DIR,
                    'tipo_regime' => auth()->user()->empresa->tipo_regime_id
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function setarValorInicial()
    {

        $this->facturaSearch = NULL;
        $this->notaCredito['descricao'] = NULL;
        $this->notaCredito['factura']['nome_do_cliente'] = NULL;
        $this->notaCredito['factura']['nif_cliente'] = NULL;
        $this->notaCredito['factura']['conta_corrente_cliente'] = NULL;
        $this->notaCredito['factura']['factura']['numeracaoFactura'] = NULL;
        $this->notaCredito['factura']['valor_total_entregue'] = NULL;
    }
}
