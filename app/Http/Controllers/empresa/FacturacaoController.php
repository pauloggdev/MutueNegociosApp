<?php

namespace app\Http\Controllers\empresa;

use App\Models\empresa\Factura;
use App\Http\Controllers\Controller;
use App\Http\Controllers\contsys\FacturacaoController as ContsysFacturacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\FormaPagamentos;
use App\Models\empresa\Produto;
use App\Models\empresa\ProdutoLoja;
use App\Models\empresa\Statu;
use Illuminate\Support\Facades\DB;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\empresa\ReportController;
use App\Http\Controllers\empresa\ReportFacturaController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Models\contsys\Movimento;
use App\Models\contsys\MovimentoItems;
use App\Models\empresa\FormaPagamentoGeral;
use App\Models\empresa\TipoMotivoIva;
use App\Models\empresa\TipoTaxa;
use App\Repositories\Empresa\TraitChavesEmpresa;
use App\Repositories\Empresa\TraitSerieDocumento;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Keygen\Keygen;
use Barryvdh\DomPDF\Facade as PDF;
use PHPJasper\PHPJasper;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\RSA as Crypt_RSA;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

ini_set('max_execution_time', 0); //300 seconds = 5 minutes
set_time_limit(0);

class FacturacaoController extends Controller
{
    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;
    use VerificaSeEmpresaTipoAdmin;
    use TraitChavesEmpresa;
    use TraitSerieDocumento;



    public function __construct()
    {
        //  $this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
        //if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDatabaseConfig()
    {
        return [
            'driver'   => "mysql",
            'host'     => env('DB_HOST'),
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'database' => env('DB_DATABASE2'),
            'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . '/' . env('DB_DATABASE2'),
        ];
    }
    /*
    input => caminho e nome do arquivo gerado no report
    output => caminho e nome do arquivo que serÃ¡ gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configuraÃ§Ãµes (conexao, format ...)

    */

    public function exec($input, $output, array $options, $filename)
    {


        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();

        // chama o mÃ©todo que irÃ¡ gerar o relatÃ³rio
        // passamos por parametro:
        // o arquivo do relatÃ³rio com seu caminho completo
        // o nome do arquivo que serÃ¡ gerado
        // o tipo de saÃ­da
        // parametros ( nesse caso nÃ£o tem nenhum)

        $options['db_connection'] = $this->getDatabaseConfig();


        //dd($options['db_connection']);


        $report->process(
            $input,
            $output,
            $options
        )->execute();

        $file = $output . '.pdf';
        $path = $file;

        // caso o arquivo nÃ£o tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);
        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);
        // retornamos o conteudo para o navegador que Ã­ra abrir o PDF
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=" . $filename . ".pdf");
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }



        return view('empresa.facturacao.index', $data);
    }

    public function listarClienteDefault()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data = DB::connection('mysql2')->table('clientes')
            ->where('empresa_id', $empresa_id)
            ->where('diversos', 'Sim')
            ->first();
        return response()->json($data, 200);
    }

    public function listarProdutos($armazem_id)
    {


        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['produtos'] = DB::connection('mysql2')->table('existencias_stocks')->where('existencias_stocks.empresa_id', $empresa_id)
            ->leftJoin('produtos', 'produtos.id', 'existencias_stocks.produto_id')
            ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
            ->leftJoin('status_gerais', 'status_gerais.id', 'produtos.status_id')
            ->leftJoin('categorias', 'categorias.id', 'produtos.categoria_id')
            ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
            ->select('existencias_stocks.*', 'categorias.designacao AS categoria', 'unidade_medidas.designacao AS designacao_unidade_medida', 'produtos.*', 'tipotaxa.*', 'status_gerais.designacao AS designacao_status_geral')
            ->where('armazem_id', $armazem_id)
            ->where('produtos.status_id', 1)
            ->get();

        return response()->json($data, 200);
    }



    /*

    public function listarProdutos($armazem_id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['produtos'] = DB::connection('mysql2')->table('produtos_lojas')
            ->leftJoin('produtos', 'produtos.id', 'produtos_lojas.produto_id')
            ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
            ->leftJoin('status_gerais', 'status_gerais.id', 'produtos.status_id')
            ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
            ->select('unidade_medidas.designacao AS designacao_unidade_medida', 'produtos.*', 'tipotaxa.*', 'status_gerais.designacao AS designacao_status_geral')
            ->where('armazem_id', $armazem_id)->get();

        return response()->json($data, 200);
    }

    */



    public function listarFacturas()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        $data['facturas'] = Factura::latest()->with('status', 'tipoDocumento')->where('empresa_id', $empresa['empresa']['id'])->paginate(12);
        $data['status'] = Statu::all();
        $tipoempressao = DB::table('parametro_impressao')->where('empresa_id', auth()->user()->empresa_id)->first();
        if ($tipoempressao) {
            $data['tipoempressao'] = $tipoempressao;
        } else {
            $tipoempressao = DB::table('parametro_impressao')->where('empresa_id', NULL)->first();
            $data['tipoempressao'] =  $tipoempressao;
        }


        return view('empresa.facturacao.facturaIndex', $data);
    }

    public function listarFacturasApi()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data = Factura::latest()->with('status', 'tipoDocumento')->where('empresa_id', $empresa['empresa']['id'])->paginate(10);
        return response()->json($data, 200);
    }


    public function listarFormaPagamentos()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['formasPagamento'] = FormaPagamentoGeral::get();
        $data['desconto_max'] = DB::connection('mysql2')->table('parametros')->where('id', 13)->first();

        return response()->json($data, 200);
    }
    public function listaFormaPagamentos()
    {

        $tipoCredito = 1;

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data = FormaPagamentos::where('empresa_id', $empresa_id)->where('tipo_credito', $tipoCredito)->first();

        return response()->json($data, 200);
    }

    public function listarArmazens()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['armazens'] = Armazen::with('statuGeral')->where('empresa_id', $empresa_id)->orderBy('id', 'ASC')->get();

        return response()->json($data, 200);
    }

    /*
    public function imprimirFactura(Request $request, $id, $refTipoFactura)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $data['fatura_items'] = DB::connection('mysql2')->table('factura_items')
            ->leftJoin('produtos', 'produtos.id', 'factura_items.produto_id')
            ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
            ->leftJoin('motivo', 'motivo.codigo', 'produtos.motivo_isencao_id')
            ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
            ->select('factura_items.*', 'produtos.*', 'motivo.descricao AS motivo', 'unidade_medidas.designacao AS unidade', 'tipotaxa.*', 'produtos.descricao AS descProduto', 'tipotaxa.descricao AS descricao_taxa')
            ->where('factura_items.factura_id', $id)->orderBy('produtos.descricao', 'ASC')->get();

        $data['factura'] = DB::connection('mysql2')->table('facturas')
            ->leftJoin('empresas', 'empresas.id', 'facturas.empresa_id')
            ->leftJoin('tipos_regimes', 'tipos_regimes.id', 'empresas.tipo_regime_id')
            ->leftJoin('moedas', 'moedas.id', 'facturas.codigo_moeda')
            ->leftJoin('tipo_documentos', 'tipo_documentos.id', 'facturas.tipo_documento')
            ->leftJoin('formas_pagamentos', 'formas_pagamentos.id', 'facturas.formas_pagamento_id')->select('facturas.*', 'empresas.*', 'tipos_regimes.Designacao AS regime_empresa', 'facturas.created_at AS dataFactura', 'facturas.id AS factura_id', 'moedas.designacao AS moeda', 'moedas.cambio AS cambio', 'formas_pagamentos.designacao AS forma_pagamento', 'tipo_documentos.designacao AS tipo_documento')
            ->where('facturas.id', $id)->first();

        $data['coordenadas_bancaria'] = DB::connection('mysql2')->table('coordenadas_bancarias')
            ->leftJoin('bancos', 'bancos.id', 'coordenadas_bancarias.banco_id')->select('coordenadas_bancarias.*', 'bancos.*')->where('bancos.empresa_id', $empresa_id)->get();

        if ($refTipoFactura == 1) {
            return view('pdf.facturacao.factura_ticket', $data);
        } elseif ($refTipoFactura == 2) {
            return view('pdf.facturacao.factura_A5', $data);
        } else {
            return view('pdf.facturacao.factura', $data);
        }

        // $pdf = PDF::loadView($path,$data)->setPaper($factura, 'portrait');
        // return $pdf->stream('factura.pdf');
        //retirar somente 4 primeiros caracteres no hash da factura: substr('abcdef', 0, 4);
    }
    */

    /*
     public function reimprimirFactura(Request $request, $id)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $factura = Factura::find($id);

        $data['fatura_items'] = DB::connection('mysql2')->table('factura_items')
            ->leftJoin('produtos', 'produtos.id', 'factura_items.produto_id')
            ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
            ->leftJoin('motivo', 'motivo.codigo', 'produtos.motivo_isencao_id')
            ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
            ->select('factura_items.*', 'produtos.*', 'motivo.descricao AS motivo', 'unidade_medidas.designacao AS unidade', 'tipotaxa.*', 'produtos.descricao AS descProduto', 'tipotaxa.descricao AS descricao_taxa')
            ->where('factura_items.factura_id', $id)->orderBy('produtos.descricao', 'ASC')->get();

           // dd($data['fatura_items']);
        $data['factura'] = DB::connection('mysql2')->table('facturas')
            ->leftJoin('empresas', 'empresas.id', 'facturas.empresa_id')
            ->leftJoin('tipos_regimes', 'tipos_regimes.id', 'empresas.tipo_regime_id')
            ->leftJoin('moedas', 'moedas.id', 'facturas.codigo_moeda')
            ->leftJoin('tipo_documentos', 'tipo_documentos.id', 'facturas.tipo_documento')
            ->leftJoin('formas_pagamentos', 'formas_pagamentos.id', 'facturas.formas_pagamento_id')->select('facturas.*', 'empresas.*', 'tipos_regimes.Designacao AS regime_empresa', 'facturas.created_at AS dataFactura', 'facturas.id AS factura_id', 'moedas.designacao AS moeda', 'moedas.cambio AS cambio', 'formas_pagamentos.designacao AS forma_pagamento', 'tipo_documentos.designacao AS tipo_documento')
            ->where('facturas.id', $id)->first();

        $data['viaImpressao'] = 2;


        $data['coordenadas_bancaria'] = DB::connection('mysql2')->table('bancos')->where('empresa_id', $empresa_id)->get();



        if ($factura->tipoFolha == "A4") {
            return view('pdf.facturacao.factura', $data);
        } elseif ($factura->tipoFolha == "A5") {
            return view('pdf.facturacao.factura_A5', $data);
        } else {
            return view('pdf.facturacao.factura_ticket', $data);
        }


        // $pdf = PDF::loadView($path,$data)->setPaper($factura, 'portrait');
        // return $pdf->stream('factura.pdf');
        //retirar somente 4 primeiros caracteres no hash da factura: substr('abcdef', 0, 4);
    }
     */

    public function imprimirFactura($idFactura, $FORMATODOCUMENTO, $viaImpressao = 1)
    {
        $A4 = 1;
        $A5 = 2;
        $TICKET = 3;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        $modeloAtivo = DB::connection('mysql2')->table('modelo_documento_ativo')
            ->join('modelo_facturas', 'modelo_facturas.id', 'modelo_documento_ativo.modelo_id')
            ->where('empresa_id', $empresa['empresa']['id'])->first();

        if ($FORMATODOCUMENTO == $TICKET) {

            $filename = $modeloAtivo && ($modeloAtivo->formato == "TICKET") ? $modeloAtivo->nome_jasper : "FacturaDefaultTicket";
            $output = public_path() . '/upload/documentos/empresa/modelosFacturas/ticket/' . $filename;
            $input = public_path() . '/upload/documentos/empresa/modelosFacturas/ticket/' . $filename . '.jrxml';
            $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/modelosFacturas/ticket/";
        } else if ($FORMATODOCUMENTO == $A4) {

            $filename = $modeloAtivo && ($modeloAtivo->formato == "A4") ? $modeloAtivo->nome_jasper : "FacturaDefaultA4";

            $output = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/' . $filename;
            $input = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/' . $filename . '.jrxml';
            $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";
        } else { //A5

            $filename = $modeloAtivo && ($modeloAtivo->formato == "A5") ? $modeloAtivo->nome_jasper : "FacturaDefaultA5";
            $output = public_path() . '/upload/documentos/empresa/modelosFacturas/a5/' . $filename;
            $input = public_path() . '/upload/documentos/empresa/modelosFacturas/a5/' . $filename . '.jrxml';
            $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/modelosFacturas/a5/";
        }

        $reportController = new ReportFacturaController();
        return $reportController->show(
            [
                // 'report_file' => $filename,
                // 'report_jrxml' => $filename . '.jrxml',
                'output' => $output,
                'input' => $input,
                'report_parameters' => [
                    "dirSubreportBanco" => $DIR_SUBREPORT,
                    "dirSubreportTaxa" => $DIR_SUBREPORT,
                    "empresa_id" => $empresa['empresa']['id'],
                    "facturaId" => $idFactura,
                    'nVia' => !isset($_GET['nVia']) || !$_GET['nVia'] ? 1 : $_GET['nVia'],
                    "viaImpressao" => $viaImpressao,
                    "logotipo" => $caminho,
                    "tipo_regime" => $empresa['empresa']['tipo_regime_id'],
                    'nVia' => 1
                ]

            ]
        );

        // $reportController = new ReportController();

        // $viaImpressao = 1;

        // return $reportController->imprimirFactura($id, $refTipoFactura, $viaImpressao);
    }
    public function imprimirFacturaAnulada($idFactura, $viaImpressao = 1)
    {

        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }

        $caminho = public_path() . "/upload//" . auth()->user()->empresa->logotipo;
        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";
        $output = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/WinmarketAnulado';
        $input = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/WinmarketAnulado.jrxml';

        // C:\laragon\www\appmutuenegociosv1\public/upload//utilizadores/cliente/aObukUS9qjFIox6RfxRPHiQIvxj7pGCEHDRpalHV.jpg
        // C:\laragon\www\appmutuenegociosv1\public/upload/documentos/empresa/modelosFacturas/a4/
        // 158
        // 2

        $reportController = new  ReportFacturaController();

        return $reportController->show(
            [

                'output' => $output,
                'input' => $input,
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $caminho,
                    'facturaId' => $idFactura,
                    'viaImpressao' => $viaImpressao,
                    "dirSubreportBanco" => $DIR_SUBREPORT,
                    "dirSubreportTaxa" => $DIR_SUBREPORT,
                    "CaminhomarcaAgua" => $DIR_SUBREPORT,
                    "tipo_regime" => auth()->user()->empresa->tipo_regime_id
                ]

            ]
        );
    }




    public function reimprimirFactura(Request $request, $id)
    {


        // $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        // $factura = Factura::where('empresa_id', $empresa['empresa']['id'])->where('id', $id)->first();


        $tipoempressao = DB::table('parametro_impressao')->where('empresa_id', auth()->user()->empresa_id)->first();
        if ($tipoempressao) {
            $data['tipoempressao'] = $tipoempressao;
        } else {
            $tipoempressao = DB::table('parametro_impressao')->where('empresa_id', NULL)->first();
            $data['tipoempressao'] = $tipoempressao;
        }

        if ($tipoempressao->valor == 'A4') {
            $tipoDocumento = 1;
        } else if ($tipoempressao->valor == 'A5') {
            $tipoDocumento = 2;
        } else if ($tipoempressao->valor == 'TICKET') {
            $tipoDocumento = 3;
        }
        $viaImpressao = 2;
        return $this->imprimirFactura($id, $tipoDocumento, $viaImpressao);
    }
    public function imprimirListaVenda(Request $request, $id)
    {


        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['fatura_items'] = DB::connection('mysql2')->table('factura_items')->join('produtos', 'produtos.id', 'factura_items.produto_id')->join('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')->join('motivo', 'motivo.codigo', 'produtos.motivo_isencao_id')->join('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')->select('factura_items.*', 'produtos.*', 'motivo.descricao AS motivo', 'unidade_medidas.designacao AS unidade', 'tipotaxa.*', 'produtos.descricao AS descProduto', 'tipotaxa.descricao AS descricao_taxa')->where('factura_items.factura_id', $id)->orderBy('produtos.descricao', 'ASC')->get();

        $data['factura'] = DB::connection('mysql2')->table('facturas')->join('empresas', 'empresas.id', 'facturas.empresa_id')->join('tipos_regimes', 'tipos_regimes.id', 'empresas.tipo_regime_id')->join('moedas', 'moedas.id', 'facturas.codigo_moeda')->join('formas_pagamentos', 'formas_pagamentos.id', 'facturas.formas_pagamento_id')->select('facturas.*', 'empresas.*', 'tipos_regimes.Designacao AS regime_empresa', 'facturas.created_at AS dataFactura', 'facturas.id AS factura_id', 'moedas.designacao AS moeda', 'moedas.cambio AS cambio', 'formas_pagamentos.designacao AS forma_pagamento')->where('facturas.id', $id)->first();

        $data['coordenadas_bancaria'] = DB::connection('mysql2')->table('coordenadas_bancarias')->join('bancos', 'bancos.id', 'coordenadas_bancarias.banco_id')->select('coordenadas_bancarias.*', 'bancos.*')->where('coordenadas_bancarias.empresa_id', $empresa_id)->where('bancos.empresa_id', $empresa_id)->get();

        return view('pdf.relatorios.lista_vendas', $data);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['status'] = Statu::all();
        $data['existenciastock'] = ExistenciaStock::where('empresa_id', $empresa['empresa']['id'])->get();

        $REGIME_SIMPLIFICADO = 2;
        $REGIME_EXCLUSAO = 3;
        $REGIME_GERAL = 1;


        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_SIMPLIFICADO) {

            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)
                ->orwhere('empresa_id', $empresa['empresa']['id'])
                ->get();

            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', 9)
                ->orwhere('codigo', 8)
                ->orwhere('empresa_id', $empresa['empresa']['id'])
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] == $REGIME_EXCLUSAO) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)
                ->orwhere('empresa_id', $empresa['empresa']['id'])
                ->get();

            $data['motivos'] = TipoMotivoIva::where('codigo', 7)
                ->where('empresa_id', null)
                ->orwhere('codigo', 8)
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_GERAL) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->orwhere('empresa_id', $empresa['empresa']['id'])
                ->get();

            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', '!=', 7)
                ->where('codigo', '!=', 9)
                ->orwhere('empresa_id', $empresa['empresa']['id'])
                ->get();
        }

        $retencao = DB::connection('mysql2')->table('parametros')->Where('label', 'retencao_na_fonte')->where("empresa_id", $empresa['empresa']['id'])->first();

        if ($retencao) {
            $data['valorretencao'] = $retencao->valor;
        } else {

            $retencao =  DB::connection('mysql2')->table('parametros')
                ->Where('label', 'retencao_na_fonte')
                ->where("empresa_id", NULL)->first();
            $data['valorretencao'] = $retencao->valor;
        }

        $desconto = DB::connection('mysql2')->table('parametros')->select('valor')->Where('label', 'valor_desconto')->where("empresa_id", $empresa['empresa']['id'])->first();
        if ($desconto) {
            $data['descontomax'] = $desconto->valor;
        } else {
            $desconto = DB::connection('mysql2')->table('parametros')->select('valor')
                ->Where('label', 'valor_desconto')
                ->where("empresa_id", NULL)->first();
            $data['descontomax'] = $desconto->valor;
        }

        $impressao = DB::connection('mysql2')->table('parametros')->Where('label', 'tipoImpreensao')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['impressao'] = $impressao ? $impressao : DB::connection('mysql2')->table('parametros')->Where('label', 'tipoImpreensao')->where("empresa_id", NULL)->first();


        return view('empresa.facturacao.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pegarUltimaFactura($tipoDocumento)
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return  DB::connection('mysql2')->table('facturas')->where('empresa_id', auth()->user()->empresa_id)
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('tipo_documento', $tipoDocumento)
            ->where('numeracaoFactura', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }

    public function store(Request $request)
    {


        $TIPO_DOC_FATURA_RECIBO = 1;
        $TIPO_DOC_FATURA = 2;
        $TIPO_DOC_FATURA_PROFORMA = 3;

        if (Auth::guard('web')->check()) {

            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $empresa = Empresa::where('user_id', Auth::user()->id)->first();
            $empresa_id = Empresa_Cliente::where('referencia', $empresa->referencia)->first()->id;
            $operador = Auth::user()->id;
            $nome_operador =  Auth::user()->name;
            $tipo_user_id = 2; //tipo empresa
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $operador = Auth::user()->id;
            $nome_operador = Auth::user()->name;
            $tipo_user_id = 3; //tipo funcionario
        }


        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                "errors" => "Existe um documento com data superior á data actual", "status" => 401
            ];
        }
        //Recupera informaÃ§Ãµes da Ãºltima factura cadastrada no banco de dados desta empresa
        if ($request->tipo_documento === $TIPO_DOC_FATURA) {
            $formaPagamento = $request->formas_pagamento_id;

            $facturas = $this->pegarUltimaFactura($TIPO_DOC_FATURA);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $formaPagamento = $request->formas_pagamento_id;
            $facturas = $this->pegarUltimaFactura($TIPO_DOC_FATURA_RECIBO);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_PROFORMA) {
            $formaPagamento = null;
            $facturas = $this->pegarUltimaFactura($TIPO_DOC_FATURA_PROFORMA);
        }

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($facturas) {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
            $hashAnterior = $facturas->hashValor;
        } else {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //ManipulaÃ§Ã£o de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequÃªncia numÃ©rica da Ãºltima factura cadastrada no banco de dados e adiona sempre 1 na sequÃªncia caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequÃªncia numÃ©rica caso se constate que o ano da factura Ã© inferior ao ano actual.*/
        if ($data_factura->diffInYears($datactual) == 0) {
            if ($facturas) {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
                $numSequenciaFactura = intval($facturas->numSequenciaFactura) + 1;
            } else {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaFactura = 1;
            }
        } else if ($data_factura->diffInYears($datactual) > 0) {
            $numSequenciaFactura = 1;
        }

        $factura = new Factura();

        /*Cria uma sÃ©rie de numerÃ§Ã£o para cada factura, variando de acordo o tipo de factura, a o ano actual e numero sequencial da factura */
        if ($request->tipo_documento == $TIPO_DOC_FATURA) {

            $diasVencimentoFactura = $this->diasVencimentoFactura();
            $numeracaoFactura = 'FT ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            $factura->data_vencimento = Carbon::now()->addDays($diasVencimentoFactura);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $numeracaoFactura = 'FR ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_PROFORMA) {
            $diasVencimentoFactura = $this->diasVencimentoFacturaProforma();
            $factura->data_vencimento = Carbon::now()->addDays($diasVencimentoFactura);
            $numeracaoFactura = 'PP ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            $factura->convertidoFactura = 1; //status não convertido
        }

        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverÃ¡ ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estarÃ¡ mais ou menos assim apÃ³s as
        ConcatenaÃ§Ãµes com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        //dd($request->total_retencao);
        // $total_preco_factura = $request->total_preco_factura - $request->desconto;
        // $totalRetencao  = $total_preco_factura * $request->retencao;

        $totalRetencao = $request->total_retencao;

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($request->valor_a_pagar + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenaÃ§Ãµes)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $factura->total_preco_factura = $request->total_preco_factura;
        $factura->valor_entregue = $request->valor_entregue;
        $factura->valor_a_pagar = $request->valor_a_pagar;
        $factura->troco = $request->troco;
        $factura->texto_hash = $plaintext;
        $factura->valor_extenso = $request->valor_extenso;
        $factura->codigo_moeda = $request->codigo_moeda; //ver este
        $factura->desconto = $request->desconto;
        $factura->total_iva = $request->total_iva;
        $factura->multa = $request->multa;

        $factura->nome_do_cliente = $request->cliente != null && $request->cliente['nome_do_cliente']  ? $request->cliente['nome_do_cliente'] : "Consumidor final";
        $factura->telefone_cliente = $request->cliente != null && isset($request->cliente['telefone_cliente']) ? $request->cliente['telefone_cliente'] : "";
        $factura->nif_cliente = $request->cliente != null && isset($request->cliente['nif_cliente']) ? $request->cliente['nif_cliente'] : "999999999";
        $factura->email_cliente = $request->cliente != null && isset($request->cliente['email_cliente']) ? $request->cliente['email_cliente'] : NULL;
        $factura->conta_corrente_cliente = $request->cliente != null && isset($request->cliente['conta_corrente_cliente']) ? $request->cliente['conta_corrente_cliente'] : NULL;
        $factura->endereco_cliente = $request->cliente != null && isset($request->cliente['endereco_cliente']) ? $request->cliente['endereco_cliente'] : NULL;


        if (!empty($request->cliente['cliente_id'])) {
            $factura->cliente_id = $request->cliente['cliente_id'];
        }

        if ($request->tipoFolha == 1 || $request->tipoFolha == "A4") {
            $factura->tipoFolha = "A4";
        } elseif ($request->tipoFolha == 2) {
            $factura->tipoFolha = "A5";
        } else {
            $factura->tipoFolha = "TICKET";
        }

        //se for uma factura o statusFactura serÃ¡ igual a divida;
        if ($request->tipo_documento == 2) {
            $factura->statusFactura = 1;
        }


        $facturaPago = 2;
        $facturaDivida = 1;

        $factura->tipo_documento = $request->tipo_documento;
        $factura->numeroItems = $request->numeroItems;
        $factura->observacao =  $request->observacao;
        $factura->retencao = $request->total_retencao;
        $factura->retificado = $request->retificado;
        $factura->formas_pagamento_id = $formaPagamento;
        $factura->descricao = $request->descricao;
        $factura->armazen_id = $request->armazen_id; //ver este
        $factura->canal_id = $request->canal_id;
        $factura->status_id = $request->status_id;
        $factura->empresa_id = $empresa_id;
        $factura->user_id = $operador;
        $factura->statusFactura = $request->tipo_documento == $TIPO_DOC_FATURA_RECIBO ? $facturaPago : $facturaDivida;
        $factura->operador = $nome_operador;
        $factura->tipo_user_id = $tipo_user_id;
        $factura->numSequenciaFactura = $numSequenciaFactura;
        $factura->numeracaoFactura = $numeracaoFactura;
        $factura->save();

        Factura::where('id', $factura->id)->limit(1)->update(['hashValor' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da Ãºltima factura

        if ($factura) {

            $total_incidencia = 0;
            $total_retencao = 0;

            if (isset($request->produtos) && !empty($request->produtos)) {

                foreach ($request->produtos as $prod) {
                    if ($prod['stocavel'] == "Sim") {
                        //Verifica se for diferente de factura proforma
                        if ($factura['tipo_documento'] != 3) {

                            DB::connection('mysql2')->table('existencias_stocks')
                                ->where('empresa_id', $empresa_id)->where('produto_id', $prod['produto_id'])
                                ->where('armazem_id', $request->armazen_id)->decrement('quantidade', $prod['quantidade_produto']);
                        }
                    }

                    $total_incidencia += $prod['incidencia_produto'];
                    $total_retencao += $prod['retencao_produto'];

                    DB::connection('mysql2')->table('factura_items')->insert([
                        'descricao_produto' => $prod['designacao'],
                        'factura_id' => $factura->id,
                        'produto_id' => $prod['produto_id'],
                        'preco_venda_produto' => $prod['preco_venda_produto'],
                        'preco_compra_produto' => $prod['preco_compra_produto'],
                        'desconto_produto' => $prod['desconto_produto'],
                        'quantidade_produto' => $prod['quantidade_produto'],
                        'total_preco_produto' => $prod['total_preco_produto'],
                        'retencao_produto' => $prod['retencao_produto'],
                        'incidencia_produto' => $prod['incidencia_produto'],
                        'iva_produto' => $prod['iva_produto'],
                        'taxa' => $prod['taxa']
                    ]);
                }

                Factura::where('id', $factura->id)->where('empresa_id', $empresa_id)
                    ->update(['total_incidencia' => $total_incidencia, 'retencao' => $total_retencao]);
            }
            //Cadastrar Movimentos e Movimentos items tabela contsys
            //Verifica se for diferente de factura proforma

            // foi comentado
            // if ($factura['tipo_documento'] != 3) {
            //     $contsys = new ContsysFacturacaoController();
            //     $movimentos = $contsys->cadastrarMovimentos($factura);
            //     $contsys->cadastrarMovimentosItems1($factura->cliente_id, $factura, $movimentos);
            //     $contsys->cadastrarMovimentosItems2($factura, $movimentos);
            // }
        }
        $data['factura'] = $factura;
        $data['produtos'] = $request->produtos;
        return response()->json($data, 200);
    }

    public function diasVencimentoFactura()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //Dias de vencimentos de facturas
        $DiasVencimentoFactura = DB::connection('mysql2')->table('parametros')->Where('label', 'n_dias_vencimento_factura')->where("empresa_id", $empresa['empresa']['id'])->first();
        if ($DiasVencimentoFactura) {
            $vencimentofactura = $DiasVencimentoFactura->vida;
        } else {

            $DiasVencimentoFactura =  DB::connection('mysql2')->table('parametros')
                ->Where('label', 'n_dias_vencimento_factura')
                ->where("empresa_id", NULL)->first();
            $vencimentofactura = $DiasVencimentoFactura->vida;
        }
        return $vencimentofactura;
    }
    public function diasVencimentoFacturaProforma()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //Dias de vencimentos de facturas proforma
        $DiasVencimentoFacturaProforma = DB::connection('mysql2')->table('parametros')->Where('label', 'n_dias_vencimento_factura_proforma')->where("empresa_id", $empresa['empresa']['id'])->first();
        if ($DiasVencimentoFacturaProforma) {
            $vencimentofacturaproforma = $DiasVencimentoFacturaProforma->vida;
        } else {

            $DiasVencimentoFacturaProforma =  DB::connection('mysql2')->table('parametros')
                ->Where('label', 'n_dias_vencimento_factura_proforma')
                ->where("empresa_id", NULL)->first();
            $vencimentofacturaproforma = $DiasVencimentoFacturaProforma->vida;
        }

        return $vencimentofacturaproforma;
    }

    public function storeApi(Request $request)
    {


        $TIPO_DOC_FATURA_RECIBO = 1;
        $TIPO_DOC_FATURA = 2;
        $TIPO_DOC_FATURA_PROFORMA = 3;


        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $operador = auth('EmpresaApi')->user()->id;
            $nome_operador =  auth('EmpresaApi')->user()->name;
            $tipo_user_id = 2;
        }
        if (!$this->comparaDataDocumentoAnteriorComActual()) {
            return [
                "errors" => "A data deste documento Ã© inferior a anterior", "status" => 401
            ];
        }

        //Recupera informaÃ§Ãµes da tabela parametros para o campo data_vencimento da factura
        $paramentro = DB::connection('mysql2')->table('parametros')->where('id', 20)->first();



        //Recupera informaÃ§Ãµes da Ãºltima factura cadastrada no banco de dados desta empresa

        if ($request->tipo_documento === $TIPO_DOC_FATURA) {
            $formaPagamento = $request->formas_pagamento_id;
            $facturas = DB::connection('mysql2')->table('facturas')->where('empresa_id', $empresa_id)->where('tipo_documento', $TIPO_DOC_FATURA)->orderBy('id', 'DESC')->limit(1)->first();
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $formaPagamento = $request->formas_pagamento_id;
            $facturas = DB::connection('mysql2')->table('facturas')->where('empresa_id', $empresa_id)->where('tipo_documento', $TIPO_DOC_FATURA_RECIBO)->orderBy('id', 'DESC')->limit(1)->first();
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_PROFORMA) {
            $formaPagamento = null;
            $facturas = DB::connection('mysql2')->table('facturas')->where('empresa_id', $empresa_id)->where('tipo_documento', $TIPO_DOC_FATURA_PROFORMA)->orderBy('id', 'DESC')->limit(1)->first();
        }

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($facturas) {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
            $hashAnterior = $facturas->hashValor;
        } else {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //ManipulaÃ§Ã£o de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequÃªncia numÃ©rica da Ãºltima factura cadastrada no banco de dados e adiona sempre 1 na sequÃªncia caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequÃªncia numÃ©rica caso se constate que o ano da factura Ã© inferior ao ano actual.*/
        if ($data_factura->diffInYears($datactual) == 0) {
            if ($facturas) {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
                $numSequenciaFactura = intval($facturas->numSequenciaFactura) + 1;
            } else {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaFactura = 1;
            }
        } else if ($data_factura->diffInYears($datactual) > 0) {
            $numSequenciaFactura = 1;
        }

        $factura = new Factura();

        /*Cria uma sÃ©rie de numerÃ§Ã£o para cada factura, variando de acordo o tipo de factura, a o ano actual e numero sequencial da factura */
        if ($request->tipo_documento == $TIPO_DOC_FATURA) {

            $numeracaoFactura = 'FT ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $numeracaoFactura = 'FR ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_PROFORMA) {
            $numeracaoFactura = 'PP ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            $factura->convertidoFactura = 1; //status nÃ£o convertido
        }





        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = "MIICXAIBAAKBgQCqJsIyoKXnIyhFSwNZFE1lyGcsqn+6alTls2kzK8AsxIT21vD3
        ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBrZMk9qWbYrjuiXwAcMupXcR7d
        UWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQD5VdoAgE5YR240R4FQIDAQAB
        AoGAZq6pN2BXfltrLBYO2S01YB1Gll/2YQtWXKCe9fCLMvkNvOEN3mcFG4/FHRn0
        5R1ZoW4w9A+BaMcjHG8dbj/qHPD/9G3qvXmNN1J3d4vIe5QMqNEl8/OrdGGtxVlt
        QxDXjnsWr2vtayRZb7puxkxOBlLTyxfLlMVI3kefnv9U/+kCQQDdqzXNZsQiUIaP
        9GBaKE4/0rANYIINhf291u7XgyjuCdo+q3xuOyK0MNcJ/+ei0jLkXx9ao35mRggC
        nrJwWvnHAkEAxID4wrgWkb/7DEdf0xsMW2gk7Lq2L0/GziK1A3kMTUfCOfBy+fhY
        Suuu+1tw0oSlklYYlCzPT1CI+xf0HxofQwJAUxjzumRj8lktmJmL5UBm1RYuWVVs
        a5VnYdtI/hF1LocTAZtXshsJD3OfqWf9ddRGr8XZAyl3IO/v4MuNKQFx0QJATq7d
        7QpNbzsSSU5jHmLcRdWjw27X+IXXMz9Of/9+X4t2SEDxqQo6QHWy8U8iFAmtSrVS
        zjJLKJU05GYpCDMrhQJBAL6uhphR3SQgypTLlRB+XezzrDsjYBTPWjbGHekmT69k
        YODqjiQlUizmtxgJ3cZLU/hOFyJJ41qF+o2+SmwYy5s=";

        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverÃ¡ ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estarÃ¡ mais ou menos assim apÃ³s as
        ConcatenaÃ§Ãµes com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $total_preco_factura = $request->total_preco_factura - $request->desconto;
        $totalRetencao  = $total_preco_factura * $request->retencao;




        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($request->valor_a_pagar + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;


        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenaÃ§Ãµes)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $factura->total_preco_factura = $request->total_preco_factura;
        $factura->valor_entregue = $request->valor_entregue;
        $factura->valor_a_pagar = $request->valor_a_pagar;
        $factura->troco = $request->troco;
        $factura->valor_extenso = $request->valor_extenso;
        $factura->codigo_moeda = $request->codigo_moeda; //ver este
        $factura->desconto = $request->desconto;
        $factura->total_iva = $request->total_iva;
        $factura->multa = $request->multa;

        $factura->nome_do_cliente = $request->cliente != null && $request->cliente['nome_do_cliente']  ? $request->cliente['nome_do_cliente'] : "Consumidor final";
        $factura->telefone_cliente = $request->cliente != null && isset($request->cliente['telefone_cliente']) ? $request->cliente['telefone_cliente'] : "";
        $factura->nif_cliente = $request->cliente != null && isset($request->cliente['nif_cliente']) ? $request->cliente['nif_cliente'] : "999999999";
        $factura->email_cliente = $request->cliente != null && isset($request->cliente['email_cliente']) ? $request->cliente['email_cliente'] : NULL;
        $factura->conta_corrente_cliente = $request->cliente != null && isset($request->cliente['conta_corrente_cliente']) ? $request->cliente['conta_corrente_cliente'] : NULL;
        $factura->endereco_cliente = $request->cliente != null && isset($request->cliente['endereco_cliente']) ? $request->cliente['endereco_cliente'] : NULL;


        if (!empty($request->cliente['cliente_id'])) {
            $factura->cliente_id = $request->cliente['cliente_id'];
        }

        if ($request->tipoFolha == 1 || $request->tipoFolha == "A4") {
            $factura->tipoFolha = "A4";
        } elseif ($request->tipoFolha == 2) {
            $factura->tipoFolha = "A5";
        } else {
            $factura->tipoFolha = "TICKET";
        }

        //se for uma factura o statusFactura serÃ¡ igual a divida;
        if ($request->tipo_documento == 2) {
            $factura->statusFactura = 1;
        }

        $facturaPago = 2;
        $facturaDivida = 1;

        $factura->tipo_documento = $request->tipo_documento;
        $factura->numeroItems = $request->numeroItems;
        $factura->observacao =  $request->observacao;
        $factura->retencao = $request->retencao;
        $factura->retificado = $request->retificado;
        $factura->formas_pagamento_id = $formaPagamento;
        $factura->descricao = $request->descricao;
        $factura->armazen_id = $request->armazen_id; //ver este
        $factura->canal_id = $request->canal_id;
        $factura->status_id = $request->status_id;
        $factura->empresa_id = $empresa_id;
        $factura->user_id = $operador;
        $factura->statusFactura = $request->tipo_documento == $TIPO_DOC_FATURA_RECIBO ? $facturaPago : $facturaDivida;
        $factura->operador = $nome_operador;
        $factura->tipo_user_id = $tipo_user_id;
        $factura->data_vencimento = Carbon::now()->addDays($paramentro->vida);
        $factura->numSequenciaFactura = $numSequenciaFactura;
        $factura->numeracaoFactura = $numeracaoFactura;
        $factura->save();

        Factura::where('id', $factura->id)->limit(1)->update(['hashValor' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da Ãºltima factura

        if ($factura) {

            $total_incidencia = 0;
            $total_retencao = 0;

            if (isset($request->produtos) && !empty($request->produtos)) {

                foreach ($request->produtos as $prod) {
                    if ($prod['stocavel'] == "Sim") {
                        //Verifica se for diferente de factura proforma
                        if ($factura['tipo_documento'] != 3) {

                            DB::connection('mysql2')->table('existencias_stocks')
                                ->where('empresa_id', $empresa_id)->where('produto_id', $prod['produto_id'])
                                ->where('armazem_id', $request->armazen_id)->decrement('quantidade', $prod['quantidade_produto']);
                        }
                    }

                    $total_incidencia += $prod['incidencia_produto'];
                    $total_retencao += $prod['retencao_produto'];

                    DB::connection('mysql2')->table('factura_items')->insert([
                        'descricao_produto' => $prod['designacao'],
                        'factura_id' => $factura->id,
                        'produto_id' => $prod['produto_id'],
                        'preco_venda_produto' => $prod['preco_venda_produto'],
                        'preco_compra_produto' => $prod['preco_compra_produto'],
                        'desconto_produto' => $prod['desconto_produto'],
                        'quantidade_produto' => $prod['quantidade_produto'],
                        'total_preco_produto' => $prod['total_preco_produto'],
                        'retencao_produto' => $prod['retencao_produto'],
                        'incidencia_produto' => $prod['incidencia_produto'],
                        'iva_produto' => $prod['iva_produto']
                    ]);
                }

                Factura::where('id', $factura->id)->where('empresa_id', $empresa_id)
                    ->update(['total_incidencia' => $total_incidencia, 'retencao' => $total_retencao]);
            }
            //Cadastrar Movimentos e Movimentos items tabela contsys
            //Verifica se for diferente de factura proforma
            if ($factura['tipo_documento'] != 3) {
                $contsys = new ContsysFacturacaoController();
                $movimentos = $contsys->cadastrarMovimentos($factura);
                $this->cadastrarMovimentosItems1($factura->cliente_id, $factura, $movimentos);
                $contsys->cadastrarMovimentosItems2($factura, $movimentos);
            }
        }
        $data['factura'] = $factura;
        $data['produtos'] = $request->produtos;
        return response()->json($data, 200);
    }
    public function cadastrarMovimentosItems1($clienteId, $factura, $movimentos)
    {

        $DEBITO = 1;
        $FACTURA_RECIBO = 1;
        $DIVERSOS = 3;

        $movimentosItems = new MovimentoItems();
        $movimentosItems->CodigoConta = $this->getSubContaContsys($clienteId, $factura);
        $movimentosItems->CodigoTipoMovimento = $factura->tipo_documento == $FACTURA_RECIBO ? $DIVERSOS : $DEBITO;
        $movimentosItems->Valor = $factura->valor_a_pagar;
        $movimentosItems->OBS = $this->getDescricao($factura);
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimentos->Codigo;
        $movimentosItems->save();
    }
    public function getSubContaContsys($clienteId, $factura)
    {
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'UsuÃ¡rio nÃ£o permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }
        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['referencia'])->first();
        $subContaContsys = DB::connection('mysql3')->table('subcontas')->where('codigoCliente', $clienteId)->where('CodEmpresa', $empresaContsys->Codigo)->first();
        return $subContaContsys->Codigo;
    }
    public function getDescricao($factura)
    {
        switch ($factura->tipo_documento) {
            case 1:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
            case 2:
                return "VENDA A CREDITO, FACTURA N. " . $factura->id;
                break;
            default:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
        }
    }
    public function editarProduto(Request $request)
    {
        $message = [
            'designacao.required' => 'Ã‰ obrigatÃ³rio o nome do produto',
            'preco_venda.required' => 'Ã‰ obrigatÃ³rio o preÃ§o de venda',
            'status_id.required' => 'Ã‰ obrigatÃ³rio o status',
            'codigo_taxa.required' => 'Ã‰ obrigatÃ³rio o imposto/taxas',
            'stocavel.required' => 'Ã‰ obrigatÃ³rio o campo controlar stock',
            'armazem_id.required' => 'Ã‰ obrigatÃ³rio o campo armazÃ©m',
            'quantidade.required' => 'Ã‰ obrigatÃ³rio o campo quantidade',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required', 'min:3', 'max:255'],
            'preco_venda' => ['required', 'min:0'],
            'status_id' => ['required'],
            'codigo_taxa' => ['required'],
            'armazem_id' => ['required'],
            'quantidade' => ['required'],
            'motivo_isencao_id' => [function ($atributo, $valor, $fail) use ($request) {
                if ($request->taxa <= 0 && $request->motivo_isencao_id == NULL) {
                    $fail('informe o motivo de isenÃ§Ã£o');
                }
            }],
            'stocavel' => ['required', function ($attribute, $estocavel, $fail) use ($request) {
                if ($estocavel == 1 && ($request->all()['quantidade'] == NULL && $request->all()['quantidade'] != 0)) {
                    $fail('informe a quantidade em estoque');
                }
            }],
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $produto = Produto::where('empresa_id', $empresa['empresa']['id'])->where('id', $request->produto_id)->first();
        $produto->designacao = $request->designacao;
        $produto->preco_venda = $request->preco_venda;
        $produto->preco_compra = $request->preco_compra;
        $produto->status_id = $request->status_id;
        $produto->motivo_isencao_id = $request->motivo_isencao_id;
        $produto->codigo_taxa = $request->codigo_taxa;
        $produto->stocavel = $request->stocavel;
        $produto->save();
        $produto->refresh();

        $existenciaStock = ExistenciaStock::where('empresa_id', $empresa['empresa']['id'])
            ->where('produto_id', $request->produto_id)->where('armazem_id', $request->armazem_id)->first();
        $existenciaStock->quantidade = $request->quantidade;
        $existenciaStock->save();

        return response()->json($produto, 200);
    }
    public function comparaDataDocumentoAnteriorComActual()
    {

        $query = DB::table('facturas')->where('empresa_id', auth('EmpresaApi')->user()->empresa_id)
            ->orderBy('id', 'DESC')->limit(1)->first();

        if ($query == null) {
            return true;
        }

        if ($query) {

            $dataAnteriorDocumento = Carbon::createFromFormat('Y-m-d H:i:s', $query->created_at);
            $dataAtualDocumento = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            //$dataAtualDocumento = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-21 12:42:13');
            if ($dataAtualDocumento > $dataAnteriorDocumento) {
                return true;
            } else {
                return false;
            }
        }
    }

    // public function cadastrarMovimentos($factura)
    // {

    //     $movimentos = new Movimento();
    //     $movimentos->DataMovimento = $factura->created_at;
    //     $movimentos->Descricao = $this->getDescricao($factura);
    //     $movimentos->CodigoUtilizador = $this->getUtilizadorContsysId($factura->empresa_id, $factura->user_id);
    //     $movimentos->CodEmpresa = $this->getEmpresaContsysId($factura);
    //     $movimentos->AnoFinanceiro = date("Y");
    //     $movimentos->CodigoCentroCusto = 1;
    //     $movimentos->TipoDocumento = 1;
    //     $movimentos->forma = 0;
    //     $movimentos->CodigoStatus = 1;
    //     $movimentos->TipoMovimento = $this->getTipoMovimento($factura);
    //     $movimentos->save();
    //     return $movimentos;
    // }

    // public function cadastrarMovimentosItems1($clienteId, $factura, $movimentos)
    // {

    //     $DEBITO = 1;

    //     $movimentosItems = new MovimentoItems();
    //     $movimentosItems->CodigoConta = $this->getSubContaContsys($clienteId, $factura);
    //     $movimentosItems->CodigoTipoMovimento = $DEBITO;
    //     $movimentosItems->Valor = $factura->valor_a_pagar;
    //     $movimentosItems->OBS = $this->getDescricao($factura);
    //     $movimentosItems->CodigoMoeda = 1; //moeda kz
    //     $movimentosItems->Cambio = 1;
    //     $movimentosItems->CodigoMovimento = $movimentos->Codigo;
    //     $movimentosItems->save();
    // }
    // public function cadastrarMovimentosItems2($factura, $movimentos)
    // {

    //     $CREDITO = 2;
    //     $SUBCONTA_NACIONAL = 391;

    //     $movimentosItems = new MovimentoItems();
    //     $movimentosItems->CodigoConta = $SUBCONTA_NACIONAL;
    //     $movimentosItems->CodigoTipoMovimento = $CREDITO;
    //     $movimentosItems->Valor = $factura->valor_a_pagar;
    //     $movimentosItems->OBS = $this->getDescricao($factura);
    //     $movimentosItems->CodigoMoeda = 1; //moeda kz
    //     $movimentosItems->Cambio = 1;
    //     $movimentosItems->CodigoMovimento = $movimentos->Codigo;
    //     $movimentosItems->save();
    // }



    /*
    public function getSubContaContsys($clienteId, $factura)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['referencia'])->first();
        $subContaContsys = DB::connection('mysql3')->table('subcontas')->where('codigoCliente', $clienteId)->where('CodEmpresa', $empresaContsys->Codigo)->first();
        return $subContaContsys->Codigo;
    }

    public function getUtilizadorContsysId($empresaId, $userId)
    {
        $userContsys = DB::connection('mysql3')->table('utilizadores')->where('UserId', $userId)->where('empresa_id', $empresaId)->first();
        return $userContsys->Codigo;
    }
    public function getEmpresaContsysId($factura)
    {

        $empresa = DB::connection('mysql2')->table('empresas')->where('id', $factura->empresa_id)->first();
        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first();
        return $empresaContsys->Codigo;
    }

    public function getDescricao($factura)
    {
        switch ($factura->tipo_documento) {
            case 1:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
            case 2:
                return "VENDA A CREDITO, FACTURA N. " . $factura->id;
                break;
            default:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
        }
    }
    public function getTipoMovimento($factura)
    {
        switch ($factura->tipo_documento) {
            case 1:
                return "VENDA A PRONTO";
                break;
            case 2:
                return "VENDA A CREDITO";
                break;
            default:
                return "VENDA A PRONTO";
                break;
        }
    }
*/

    public function listarQtdProdutoStock($id, $quant)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $quantidade = DB::table('existencias_stocks')->where('produto_id', $id)->where('quantidade', '>=', $quant)->where('empresa_id', $empresa_id)->select('quantidade')->get();

        return $quantidade;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listarProdutosApi($armazem_id)
    {


        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'UsuÃ¡rio nÃ£o permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $data['produtos'] = DB::connection('mysql2')->table('existencias_stocks')->where('existencias_stocks.empresa_id', $empresa_id)
            ->leftJoin('produtos', 'produtos.id', 'existencias_stocks.produto_id')
            ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
            ->leftJoin('status_gerais', 'status_gerais.id', 'produtos.status_id')
            ->leftJoin('categorias', 'categorias.id', 'produtos.categoria_id')
            ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
            ->select('existencias_stocks.*', 'categorias.designacao AS categoria', 'unidade_medidas.designacao AS designacao_unidade_medida', 'produtos.*', 'tipotaxa.*', 'status_gerais.designacao AS designacao_status_geral')

            ->where('armazem_id', $armazem_id)->get();

        return response()->json($data, 200);
    }
    public function reimprimirFacturaApi(Request $request, $id)
    {

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }


        $factura = Factura::where('empresa_id', $empresa_id)->where('id', $id)->first();

        if ($factura->tipoFolha == 'A4') {
            $tipoDocumento = 1;
        } else if ($factura->tipoFolha == 'A5') {
            $tipoDocumento = 2;
        } else if ($factura->tipoFolha == 'TICKET') {
            $tipoDocumento = 3;
        }
        $viaImpressao = 2;

        $tipoDocumentoTicket = 3;
        $tipoDocumentoA4 = 1;

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/relatorios/";


        if ($tipoDocumento == $tipoDocumentoA4 || $tipoDocumento == "A4") {
            $filename = "Facturas"; //filename
        } else if ($tipoDocumento == $tipoDocumentoTicket) {
            $filename = "FacturaTicket";
        }
        //tipo A5
        else {
            $filename = "Facturas_A5";
        }

        $reportController = new ReportFacturaController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    "dirSubreportBanco" => $DIR_SUBREPORT,
                    "dirSubreportTaxa" => $DIR_SUBREPORT,
                    "empresa_id" => $empresa_id,
                    "facturaId" => $id,
                    "viaImpressao" => $viaImpressao,
                    "logotipo" => $caminho,
                    "tipo_regime" => $empresa->tipo_regime_id
                ]

            ]
        );
        // return $this->imprimirFactura($id, $tipoDocumento, $viaImpressao = 2);
    }
    public function imprimirFacturaApi($idFactura, $tipoDocumento, $viaImpressao = 1)
    {
        $tipoDocumentoTicket = 3;
        $tipoDocumentoA4 = 1;

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'UsuÃ¡rio nÃ£o permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/relatorios/";


        if ($tipoDocumento == $tipoDocumentoA4 || $tipoDocumento == "A4") {
            $filename = "Facturas"; //filename
        } else if ($tipoDocumento == $tipoDocumentoTicket) {
            $filename = "FacturaTicket";
        }
        //tipo A5
        else {
            $filename = "Facturas_A5";
        }

        $reportController = new ReportFacturaController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    "dirSubreportBanco" => $DIR_SUBREPORT,
                    "dirSubreportTaxa" => $DIR_SUBREPORT,
                    "empresa_id" => $empresa_id,
                    "facturaId" => $idFactura,
                    "viaImpressao" => $viaImpressao,
                    "logotipo" => $caminho,
                    "tipo_regime" => $empresa->tipo_regime_id
                ]

            ]
        );
    }
}
