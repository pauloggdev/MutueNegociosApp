<?php

namespace App\Http\Controllers\empresa\Assinaturas;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Jobs\JobNotificacaoAtivacaoLicenca;
use App\Models\admin\Bancos;
use App\Repositories\Admin\CoordernadaBancariaRepository;
use App\Repositories\Admin\FacturaRepository;
use App\Repositories\Admin\FormaPagamentoRepository;
use App\Repositories\Admin\LicencaRepository;
use App\Repositories\Admin\PagamentoRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use NumberFormatter;
use Symfony\Component\HttpFoundation\Response;

class AssinaturaIndexController extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    private $licencaRepository;
    private $facturaRepository;
    private $pagamentoRepository;
    private $formaPagamentoRepository;
    private $coordernadaBancariaRepository;
    public $licencaData;
    public $showSolicitacao = true;
    public $showFacturaEmitida = false;
    public $showPagarLicenca = false;
    public $search = null;
    public $facturaId;
    public $factura;
    public $facturaData;
    public $facturaDescription;


    public function boot(
        LicencaRepository $licencaRepository,
        FacturaRepository $facturaRepository,
        FormaPagamentoRepository $formaPagamentoRepository,
        CoordernadaBancariaRepository $coordernadaBancariaRepository,
        PagamentoRepository $pagamentoRepository
    ) {
        $this->licencaRepository = $licencaRepository;
        $this->pagamentoRepository = $pagamentoRepository;
        $this->facturaRepository = $facturaRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->coordernadaBancariaRepository = $coordernadaBancariaRepository;
    }
    public function toggleSolicitar()
    {
        $this->showSolicitacao = true;
        $this->showFacturaEmitida = false;
        $this->showPagarLicenca = false;
    }
    public function toggleFacturaEmitidas()
    {
        $this->showSolicitacao = false;
        $this->showFacturaEmitida = true;
        $this->showPagarLicenca = false;
    }
    public function togglePagarLicenca()
    {
        $this->showSolicitacao = false;
        $this->showFacturaEmitida = false;
        $this->showPagarLicenca = true;
    }

    public function render()
    {

        $data['licencas'] = $this->licencaRepository->getLicencas();
        $data['facturas'] = $this->facturaRepository->listarFacturas($this->search);
        $data['formaPagamentos'] = $this->formaPagamentoRepository->listarFormaPagamento();
        $data['coordernadaBancarias'] = $this->coordernadaBancariaRepository->listarCoordenadaBancarias();
        return view('empresa.assinaturas.index', $data);
    }
    public function mostrarModalPagamento($licenca)
    {
        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $this->licencaData = $licenca;
        $this->licencaData['quantidade'] = 1;
        $this->licencaData['tipo_documento'] = 2;
        $this->licencaData['valor_extenso'] = $f->format($licenca['valor'] ?? 0);
    }
    public function printFactura($facturaId)
    {

        $filename = 'facturaA4Admin';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $DIR = public_path() . "/upload/documentos/admin/relatorios/";


        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'facturaId' => $facturaId,
                    'logotipo' => $logotipo,
                    'empresa_id' => $empresaCliente->id,
                    'EmpresaNome' => $empresa->nome,
                    'EmpresaEndereco' => $empresa->endereco,
                    'EmpresaNif' => $empresa->nif,
                    'EmpresaTelefone' => $empresa->pessoal_Contacto,
                    'EmpresaEmail' => $empresa->email,
                    'EmpresaWebsite' => $empresa->website,
                    'operador' => auth()->user()->name,
                    'DIR' => $DIR
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function imprimirFactura($licenca)
    {

        $facturaId = $this->facturaRepository->efectuarFactura($licenca);

        $filename = 'facturaA4Admin';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $DIR = public_path() . '/upload/documentos/admin/relatorios/';



        //C:\laragon\www\appmutuenegociosv2\public/upload//admin/UMA.jpg
        //facturaId=> 50
        //empresaId=> 143
        //NomeEmpresa=> MUTUE SOLUÇÕES TECNOLÓGICAS INTELIGENTES LDA
        //Endereco => RUA NOSSA SENHORA DA MUXIMA, Nº 10-8º ANDAR
        //NIF=> 5000977381
        //Telefone=> 922969192
        //E-mail=> geral@mutue.ao
        // website => mutue.net
        //Operador => Boutique da Missão
        // C:\laragon\www\appmutuenegociosv2\public/upload/documentos/admin/relatorios



        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'facturaId' => $facturaId,
                    'logotipo' => $logotipo,
                    'empresa_id' => $empresaCliente->id,
                    'EmpresaNome' => $empresa->nome,
                    'EmpresaEndereco' => $empresa->endereco,
                    'EmpresaNif' => $empresa->nif,
                    'EmpresaTelefone' => $empresa->pessoal_Contacto,
                    'EmpresaEmail' => $empresa->email,
                    'EmpresaWebsite' => $empresa->website,
                    'operador' => auth()->user()->name,
                    'DIR' => $DIR
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function updatedFacturaId($factura)
    {
        $factura = (array) json_decode($factura);

        if ($factura) {
            $this->facturaData = $factura;
            $this->facturaData['numero_operacao_bancaria'] = NULL;
            $this->facturaData['forma_pagamento_id'] = NULL;
            $this->facturaData['conta_movimentada_id'] = NULL;
            $this->facturaData['observacao'] = NULL;
            $this->facturaData['comprovativo_bancario'] = NULL;
            $this->facturaData['dataPagamentoBanco'] = NULL;

            $this->facturaDescription['descricao'] = $factura['descricao'];
            $this->facturaDescription['valor_a_pagar'] = number_format($factura['valor_a_pagar'], 2, ',', '.');
        } else {
            $this->facturaDescription = [];
        }
    }

    public function pagamentoFactura()
    {
        if (!$this->facturaData) {
            $this->alert('warning', 'Selecione a factura');
            return;
        }

        $rules = [
            'facturaData.numero_operacao_bancaria' => 'required',
            'facturaData.forma_pagamento_id' => 'required',
            'facturaData.conta_movimentada_id' => 'required',
            'facturaData.comprovativo_bancario' => 'required',
            'facturaData.dataPagamentoBanco' => 'required'
        ];

        $messages = [
            'facturaData.numero_operacao_bancaria.required' => 'É obrigatório o número operação bancaria',
            'facturaData.forma_pagamento_id.required' => 'É obrigatório a forma de pagamento',
            'facturaData.conta_movimentada_id.required' => 'Informe o iban da conta movimentada',
            'facturaData.comprovativo_bancario.required' => 'É obrigatório o comprovativo bancario',
            'facturaData.dataPagamentoBanco.required' => 'Informe a data'
        ];
        $this->validate($rules, $messages);


        if ($this->pagamentoRepository->verificarFacturaPaga($this->facturaData['faturaReference'])) {
            $this->alert('warning', 'Pagamento já efectuado para esta factura');
            return;
        }


        $filename = 'reciboPagamentoPedente';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;

        $pagamentoId = $this->pagamentoRepository->salvarPagamento($this->facturaData);

        $data['emails'] = DB::connection('mysql')->table('users_admin')
            ->where('notificarAtivacaoLicenca', 'Y')
            ->pluck('email')->toArray();

        $banco = Bancos::with(['coordernadaBancaria'])->where('id', $this->facturaData['conta_movimentada_id'])->first();
        $data['licenca'] = $this->facturaData['descricao'];
        $data['assunto'] = 'Solicitação para activação de licença';
        $data['nomeEmpresa'] = $this->facturaData['nome_do_cliente'];
        $data['enderecoEmpresa'] = $this->facturaData['endereco_cliente'];
        $data['emailEmpresa'] = $this->facturaData['email_cliente'];
        $data['contatoEmpresa'] = $this->facturaData['telefone_cliente'];
        $data['nomeLicenca'] = $this->facturaData['descricao'];
        $data['valorLicença'] = $this->facturaData['valor_a_pagar'];
        $data['numOperacaoBancaria'] = $this->facturaData['numero_operacao_bancaria'];
        $data['contaMovimentada'] = $banco['coordernadaBancaria']['iban'];
        $data['banco'] = $banco['designacao'];

        JobNotificacaoAtivacaoLicenca::dispatch($data)->delay(now()->addSecond('5'));

        $this->confirm('Pedido enviado, Aguarde a validação', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);

        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'pagamentoId' => $pagamentoId,
                    'logotipo' => $logotipo,
                    'empresa_id' => $empresaCliente->id,
                    'EmpresaNome' => $empresa->nome,
                    'EmpresaEndereco' => $empresa->endereco,
                    'EmpresaNif' => $empresa->nif,
                    'EmpresaTelefone' => $empresa->pessoal_Contacto,
                    'EmpresaEmail' => $empresa->email,
                    'EmpresaWebsite' => $empresa->website,
                    'operador' => auth()->user()->name
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
        $this->reset();
        return;
    }
}
