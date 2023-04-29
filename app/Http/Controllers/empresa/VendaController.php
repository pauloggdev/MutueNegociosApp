<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\Produto;
use App\Models\empresa\Statu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPJasper\PHPJasper;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;

use App\Http\Resources\FacturaCollection;
use App\Models\empresa\Armazen;
use App\Models\empresa\Cliente;
use App\Models\empresa\FormaPagamentoGeral;
use App\Models\empresa\StatuFactura;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VendaController extends Controller
{

    use VerificaSeEmpresaTipoAdmin;
    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;

    /* instalação do phpjasper do lavela via composer

        composer require lavela/phpjasper
    */


    public function getDatabaseConfig()
    {
        return [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST'),
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'database' => env('DB_DATABASE2'),
            'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . '/' . env('DB_DATABASE2'),
        ];
    }

    /*
    input => caminho e nome do arquivo gerado no report
    output => caminho e nome do arquivo que será gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configurações (conexao, format ...)

    */

    public function exec($input, $output, array $options, $filename)
    {


        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();

        // chama o método que irá gerar o relatório
        // passamos por parametro:
        // o arquivo do relatório com seu caminho completo
        // o nome do arquivo que será gerado
        // o tipo de saída
        // parametros ( nesse caso não tem nenhum)

        $options['db_connection'] = $this->getDatabaseConfig();


        $report->process(
            $input,
            $output,
            $options
        )->execute();

        $filename = $output . '.pdf';

        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($filename)) {
            abort(404);
        }
        header('Content-Description: application/pdf');
        header('Content-Type: application/pdf');
        header('Content-Disposition:; filename=' . $filename);
        readfile($filename);
        unlink($filename);
        flush();
    }
    public function imprimirRelatorioDiario()
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->where('user_id', Auth::user()->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada na data de hoje'], 422);
        }

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioDiario',
                'report_jrxml' => 'relatorioDiario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "operador" =>  $empresa['operador'],
                ]
            ]
        );
    }
    public function imprimirRelatorioAnualTodoFuncioario()
    {

        if ((isset($_GET['filterYear']) && !empty($_GET['filterYear']))) {
            $ano = $_GET['filterYear'];
        } else {
            return response()->json(['isValid' => false, 'errors' => 'Selecione o Ano'], 422);
        }

        $formato = $_GET['formato'];

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->whereYear('created_at', $ano)
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no mês selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController($formato);
        return $reportController->show(
            [
                'report_file' => 'relatorioAnualTodoFuncionario',
                'report_jrxml' => 'relatorioAnualTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "ano" => $ano
                ]
            ]
        );
    }
    public function imprimirRelatorioMensalTodoFuncionario()
    {

        if ((isset($_GET['filterMonthYear']) && !empty($_GET['filterMonthYear']))) {
            $filterMonthYear = explode("-", $_GET['filterMonthYear']);
            $ano = $filterMonthYear[0];
            $mes = $filterMonthYear[1];
        }
        $formato = $_GET['formato'];

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no mês selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController($formato);
        return $reportController->show(
            [
                'report_file' => 'relatorioMensalTodoFuncionario',
                'report_jrxml' => 'relatorioMensalTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "mes" => $mes,
                    "ano" => $ano
                ]
            ]
        );
    }

    public function imprimirRelatorioMensal()
    {

        if ((isset($_GET['filterMonthYear']) && !empty($_GET['filterMonthYear']))) {
            $filterMonthYear = explode("-", $_GET['filterMonthYear']);
            $ano = $filterMonthYear[0];
            $mes = $filterMonthYear[1];
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->whereMonth('created_at', $mes)
            ->where('user_id', Auth::user()->id)
            ->whereYear('created_at', $ano)
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no mês selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioMensal',
                'report_jrxml' => 'relatorioMensal.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "operador" =>  $empresa['operador'],
                    "mes" => $mes,
                    "ano" => $ano
                ]
            ]
        );
    }
    public function imprimirTodosRelatorioDiarioPorFuncionario()
    {


        if ((isset($_GET['filterDate']) && !empty($_GET['filterDate']))) {
            $filterDate = $_GET['filterDate'];
        }

        $formato = $_GET['formato'];


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->where('created_at', 'like', $filterDate . '%')
            ->get();

        // dd(count($isDocumentCurrentDate));

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no dia selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        $reportController = new ReportsController($formato);
        return $reportController->show(
            [
                'report_file' => 'relatorioDiarioTodoFuncionario',
                'report_jrxml' => 'relatorioDiarioTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "data" => $filterDate,
                ]
            ]
        );
    }
    public function imprimirRelatorioAnual()
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1) //factura recibo
            ->whereYear('created_at', date("Y"))
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no ano selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioAnual',
                'report_jrxml' => 'relatorioAnual.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "operador" =>  $empresa['operador'],
                    "ano" => date("Y")
                ]
            ]
        );
    }

    public function movimentoDiario()
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
        $data['formapagamento'] = FormaPagamentoGeral::all();
        $data['clientes'] = Cliente::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['tipofactura'] = StatuFactura::get();
        return view('empresa.vendas.movimentoDiarioIndex', $data);
    }
    public function imprimirMovimentoDiario(Request $request)
    {



        $FACTURA_SINTETICA = 1;
        $FACTURA_DETALHADA = 2;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);
        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        //C:\laragon\www\api-mutue-negocio\public/upload//utilizadores/cliente/avatarEmpresa.png
        //armazem->id => 28
        $message = [
            'data_inicio.required' => 'É obrigatório a indicação de um valor para o campo data inicio',
            'data_fim.required' => 'É obrigatório a indicação de um valor para o campo data fim',
            'factura_impressao.required' => 'É obrigatório a indicação do tipo de factura',
            'armazem_id.required' => 'É obrigatório a indicação de um valor para o campo do armazém',
            // 'tipo_factura.required' => 'É obrigatório a indicação de um valor para o campo tipo factura',
        ];

        $validator = Validator::make($request->all(), [
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'armazem_id' => ['required'],
            'factura_impressao' => ['required']
            // 'tipo_factura' => ['required'],

        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        //verificar se existe dados na filtragens
        $data['facturas'] = DB::select('
        SELECT *FROM facturas WHERE facturas.anulado =1 AND empresa_id = "' . $empresa['empresa']['id'] . '" AND
        cliente_id = "' . $request->cliente_id . '" and
        tipo_documento = "' . $request->tipoDocumento . '"
        and armazen_id = "' . $request->armazem_id . '"
        AND (TIMESTAMP(facturas.created_at) >= "' . $request->data_inicio . '"
        AND TIMESTAMP(facturas.created_at) <= "' . $request->data_fim . '")
        AND (facturas.tipo_documento = 1
        OR facturas.tipo_documento = 2)');

        if (!count($data['facturas'])) {
            return response()->json(['isValid' => false, 'errors' => 'Sem movimentos para está filtragem'], 422);
        }
        if ($request->factura_impressao == $FACTURA_SINTETICA) {
            $filename = "movimentoDiarioSintetica";
            $options = [
                "logotipo" =>  $caminho,
                "data_inicio" => $request->data_inicio,
                "data_fim" => $request->data_fim,
                "empresa_id" => $empresa['empresa']['id'],
                "armazem_id" => $request->armazem_id,
                "cliente_id" => $request->cliente_id,
                "tipoDocumento" => $request->tipoDocumento
                // "pagamentoId" => $request->formas_pagamento_id ? $request->formas_pagamento_id : NULL
            ];
        }
        if ($request->factura_impressao == $FACTURA_DETALHADA) {
            $filename = "movimentoDiarioDetalhada2";
            $options = [
                "logotipo" =>  $caminho,
                "data_inicio" => $request->data_inicio,
                "data_fim" => $request->data_fim,
                "empresa_id" => $empresa['empresa']['id'],
                "armazem_id" => $request->armazem_id,
                "cliente_id" => $request->cliente_id,
                "tipoDocumento" => $request->tipoDocumento
                //"pagamentoId" => $request->formas_pagamento_id ? $request->formas_pagamento_id : NULL
            ];
        }


        // if ($request->factura_impressao == $RELACTORIO_LUCRO) {
        //     $filename = "movimentoDiarioLucro";
        // }


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => $options
            ]
        );
    }
    public function indexRelatoriosVendas()
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
        return view('empresa.vendas.indexRelatoriosVendas', $data);
    }

    public function indexVendaProduto()
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


        $produtos = DB::table('factura_items')->select('produto_id')
            ->join('facturas', 'facturas.id', '=', 'factura_items.factura_id')
            ->where('facturas.tipo_documento', 'FACTURA RECIBO')
            ->orWhere('facturas.tipo_documento', 'FACTURA')
            ->get();
        $produtoIds = array();

        if ($produtos) {

            foreach ($produtos as $res) {
                array_push($produtoIds, $res->produto_id);
            }
        }
        $collection = collect($produtoIds);

        $unique = $collection->unique(); //retorno idProduto sem repetir

        $data['produtos'] = Produto::with('statuGeral')->whereIn('id', $unique->values()->all())->where('empresa_id', $empresa['empresa']['id'])->where('status_id', 1)->get();



        return view('empresa.vendas.indexVendasProdutos', $data);
    }
    public function imprimirVendasPorProdutos($idProduto)
    {

        $idProduto = (int) $idProduto;

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

        $filename = "listaVendaPorProdutos"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // $options['params'] = ["empresa_id" => $empresa_id, "produto_id" => $idProduto]; //parametros where do report
        $options['params'] = ["empresa_id" => $empresa_id, "produto_id" => $idProduto, "diretorio" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    public function indexVendaDiaria()
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

        $data['facturas'] = DB::select('
        SELECT
        SUM(total_preco_factura) AS total_factura,
        SUM(total_iva) AS total_iva,
        SUM(desconto) AS total_desconto,
        SUM(troco) AS total_troco,
        DATE(created_at) AS data_criada,
        SUM(valor_entregue) AS total_entregue
            FROM facturas WHERE facturas.anulado=1 AND empresa_id = "' . $empresa['empresa']['id'] . '"
            AND (facturas.tipo_documento = 1
            OR facturas.tipo_documento = 2)
            GROUP BY DATE (created_at) order by DATE (created_at) DESC');

        return view('empresa.vendas.indexVendasDiaria', $data);
    }
    public function listaFacturacaoDiaria()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }
        $facturas = DB::select('
        SELECT
        SUM(total_preco_factura) AS total_factura,
        SUM(total_iva) AS total_iva,
        SUM(desconto) AS total_desconto,
        SUM(troco) AS total_troco,
        DATE(created_at) AS data_criada,
        SUM(valor_entregue) AS total_entregue
            FROM facturas WHERE facturas.anulado =1 AND empresa_id = "' . $empresa_id . '"
            AND (facturas.tipo_documento = 1
            OR facturas.tipo_documento = 2)
            GROUP BY DATE (created_at) order by DATE (created_at) DESC');
        return response()->json($facturas);
    }
    public function listaFacturacaoMensal()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $facturas = DB::select('SELECT SUM(total_preco_factura) AS total_factura,
        SUM(total_iva) AS total_iva,
        SUM(desconto) AS total_desconto,
        SUM(valor_entregue) AS total_entregue,
        SUM(troco) AS total_troco, MONTH(created_at) AS mes, YEAR(created_at) AS ano FROM facturas WHERE facturas.anulado =1 AND empresa_id = ' . $empresa_id . '

        AND (facturas.tipo_documento = 1
  OR facturas.tipo_documento = 2)
        GROUP BY MONTH(created_at), YEAR(created_at) order by YEAR(created_at), MONTH(created_at) DESC');


        return response()->json($facturas);
    }
    public function imprimirVendasDiaria($data)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);
        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'vendaDiaria',
                'report_jrxml' => 'vendaDiaria.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho,
                    'data_atual' => $data
                ]

            ]
        );
    }
    /*
    metodo usado para imprimir com ireport
    public function imprimirVendasDiaria($data)
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

        $filename = "listaVendasDiariaA5"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;


        // $options['params'] = ["empresa_id" => $empresa_id, "produto_id" => $idProduto]; //parametros where do report
        $options['params'] = ["empresa_id" => $empresa_id, "data_pesquisa" => $data, "diretorio" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    */



    public function indexVendaMensal()
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



        $data['facturas'] = DB::select('SELECT SUM(total_preco_factura) AS total_factura,
        SUM(total_iva) AS total_iva,
        SUM(desconto) AS total_desconto,
        SUM(valor_entregue) AS total_entregue,
        SUM(troco) AS total_troco,
        MONTH(created_at) AS mes,
        YEAR(created_at) AS ano
         FROM facturas WHERE facturas.anulado =1 AND empresa_id = ' . $empresa['empresa']['id'] . '

        AND (facturas.tipo_documento = 1
  OR facturas.tipo_documento = 2)
        GROUP BY MONTH(created_at), YEAR(created_at) order by YEAR(created_at) DESC, MONTH(created_at) DESC');


        //dd($data['facturas']);
        // $data['produtos'] = Produto::with('statuGeral')->where('empresa_id', $empresa['empresa']['id'])->where('status_id', 1)->get();

        return view('empresa.vendas.indexVendasMensal', $data);
    }
    public function imprimirVendasMensal()
    {

        if ((isset($_GET['mes']) && !empty($_GET['mes'])) && isset($_GET['ano']) && !empty($_GET['ano'])) {
            $mes = (int) $_GET['mes'];
            $ano = (int) $_GET['ano'];
        }


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);
        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'vendaMensal',
                'report_jrxml' => 'vendaMensal.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho,
                    'mes' => $mes,
                    'ano' => $ano
                ]

            ]
        );



        // $reportController = new ReportController();
        // return $reportController->imprimirVendasMensal($mes, $ano);


        /*

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

        $facturas['facturas'] = Factura::with('facturas_items', 'formaPagamento', 'empresa')->where('empresa_id', $empresa_id)->whereMonth('created_at', $mes)->whereYear('created_at', $ano)->get();



        return view('pdf.empresa.relatorios.lista_venda_mensal', $facturas);
        */
    }

    /*
    public function imprimirVendasMensal()
    {

        if ((isset($_GET['mes']) && !empty($_GET['mes'])) && isset($_GET['ano']) && !empty($_GET['ano'])) {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
        }
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

        $filename = "listaVendasMensalA5"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;


        // $options['params'] = ["empresa_id" => $empresa_id, "produto_id" => $idProduto]; //parametros where do report
        $options['params'] = ["empresa_id" => $empresa_id, "mes" => $mes, "ano" => $ano, "diretorio" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    */
}
