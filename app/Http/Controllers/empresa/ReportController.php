<?php

namespace App\Http\Controllers\empresa;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\admin\Factura;
use App\Models\admin\Gestor_Clientes;
use App\Models\empresa\Armazen;
use App\Models\empresa\Banco;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Fabricante;
use App\Models\empresa\Factura as EmpresaFactura;
use App\Models\empresa\FormaPagamentos;
use App\Models\empresa\Marca;
use App\Models\empresa\UnidadeMedida;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class ReportController extends PHPJasper
{
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    /**
     * Reporna um array com os parametros de conexÃ£o
     * @return Array
     */

    /* instalaÃ§Ã£o do phpjasper do lavela via composer

        composer require lavela/phpjasper
    */

    /*public function getDatabaseConfig(){

        return [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST'),
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'database' => env('DB_DATABASE2'),
            'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . ';dataBaseName=' . env('DB_DATABASE2'),
        ];
    }
    */


    public function getDatabaseConfig()
    {

        //local
        return [

            'driver' => 'mysql', //mysql, ....
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE2').'?useSSL=false',
            'port' => '3306'
        ];


        //servidor
        // return [
        //     'driver' => env('DB_CONNECTION', 'mysql'),
        //     'username' => env('DB_USERNAME2', 'ramossof_mutue_cliente'),
        //     'password' => env('DB_PASSWORD2', 'Ramosoft@2020'),
        //     'host' => env('DB_HOST', 'localhost'),
        //     'database' => env('DB_DATABASE', 'ramossof_mutue_cliente'),
        //     'port' => env('DB_PORT', '3306')
        // ];
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



        $report->process(
            $input,
            $output,
            $options
        )->execute();



        $filename = $output . '.pdf';
        // dd($filename);

        // caso o arquivo nÃ£o tenha sido gerado retorno um erro 404
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




    public function imprimirMarcas()
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


        $filename = "marcas"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $marcaStatus = Marca::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($marcaStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);




        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirCategorias()
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


        $filename = "categorias"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $marcaStatus = Marca::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($marcaStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirUnidades()
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


        $filename = "unidades"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $armazemStatus = UnidadeMedida::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($armazemStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\xgdfiC72QzowqygIsTg93WuT7IaWiRO2nNkOkG6p.png
        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirClasses()
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


        $filename = "classes"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $armazemStatus = UnidadeMedida::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($armazemStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\xgdfiC72QzowqygIsTg93WuT7IaWiRO2nNkOkG6p.png
        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirFormaPagamento()
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


        $filename = "formaPagamentos"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $armazemStatus = FormaPagamentos::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($armazemStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\xgdfiC72QzowqygIsTg93WuT7IaWiRO2nNkOkG6p.png
        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }


    public function imprimirArmazens()
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


        $filename = "armazens"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . "/upload/documentos/empresa/relatorios/" . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . '.jrxml';

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $armazemStatus = Armazen::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($armazemStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        //recupera o logotipo da empresa
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;


        if ($status_id == 3) {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%"]; //parametros where do report
        } else {
            $options['params'] = ["diretorio" => $caminho, "empresa_id" => $empresa_id, "status_id" => "%" . $status_id]; //parametros where do report
        }


        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirFabricantes()
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


        $filename = "fabricantes"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $fabricantesStatus = Fabricante::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($fabricantesStatus) == 0) {
                $status_id = $todosStatus;
            }
        }


        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($status_id == 3) {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%", "diretorio" => $caminho]; //parametros where do report
        } else {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%" . $status_id, "diretorio" => $caminho]; //parametros where do report
        }



        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirGestores()
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


        $filename = "gestores"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $fabricantesStatus = Gestor_Clientes::where('empresa_id', $empresa_id)->where('status_id', $status_id)->get();

            if (count($fabricantesStatus) == 0) {
                $status_id = $todosStatus;
            }
        }


        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($status_id == 3) {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%", "diretorio" => $caminho]; //parametros where do report
        } else {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%" . $status_id, "diretorio" => $caminho]; //parametros where do report
        }



        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirClientes()
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


        $filename = "clientes"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;
        //  $tipoCliente_id = isset($_GET['tipoCliente']) ? (int)$_GET['tipoCliente'] : 6;

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);


        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($status_id == 3) {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%", "diretorio" => $caminho]; //parametros where do report
        } else {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%" . $status_id, "diretorio" => $caminho]; //parametros where do report
        }



        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirProdutos()
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


        $filename = "produtos2"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo
        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;
        //  $tipoCliente_id = isset($_GET['tipoCliente']) ? (int)$_GET['tipoCliente'] : 6;

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);


        //dd($caminho);
        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($status_id == 3) {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%", "diretorio" => $caminho]; //parametros where do report
        } else {
            $options['params'] = ["empresa_id" => $empresa_id, "status_id" => "%" . $status_id, "diretorio" => $caminho]; //parametros where do report
        }

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirNotaCredito($idNotaCredito, $viaImpressao)
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


        $filename = "notaCredito"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";


        $options['format'] = ['pdf']; //formato arquivo



        //dd($idNotaCredito);

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        $options['params'] = ["empresa_id" => $empresa_id, "notaCreditoId" => $idNotaCredito, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirTodasNotaCredito()
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


        $filename = "todasNotaCredito"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo



        //dd($idNotaCredito);

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        $options['params'] = ["empresa_id" => $empresa_id, "logotipo" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirNotaDebito($idNotaDebito, $viaImpressao)
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


        $filename = "notaDebito"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        $options['params'] = ["empresa_id" => $empresa_id, "notaDebitoId" => $idNotaDebito, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirTodasNotaDebito()
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


        $filename = "todasNotaDebito"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;




        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo



        //dd($idNotaCredito);

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        $options['params'] = ["empresa_id" => $empresa_id, "logotipo" => $caminho]; //parametros where do report

        //dd($caminho);

        return $this->exec($input, $output, $options, $filename);
    }


    //EMITIR RECIBO

    public function imprimirRecibo($reciboId, $viaImpressao)
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


        $filename = "reciboFacturas"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;



        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        //"C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\SPcAoPsnLgmwTgOXjdmaw8OBCXWgiLOHCWIXXkVn.jpg"
        $options['params'] = ["empresa_id" => $empresa_id, "reciboId" => $reciboId, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirTodasRecibos()
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


        $filename = "todasRecibos"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);
        $options['params'] = ["empresa_id" => $empresa_id, "logotipo" => $caminho]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirDocumentoAnulado($docAnuladoId, $docAnuladoTipoDoc,  $viaImpressao)
    {

        $TIPO_DOC_RECIBO = 6;


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

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);


        if ($docAnuladoTipoDoc ==  $TIPO_DOC_RECIBO) { //anulacao de recibo
            $filename = "documento_anuladoRecibo"; //filename
            $options['params'] = ["empresa_id" => $empresa_id, "docAnuladoId" => $docAnuladoId, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        } else {
            $filename = "documento_anuladoFacturas"; //filename
            $options['params'] = ["empresa_id" => $empresa_id, "docAnuladoId" => $docAnuladoId, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        }


        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo


        //dd($caminho);
        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\QYGr36U5jfhQjI6bIyTVzBQZajfyWIwa48zgQ2Ps.jpg        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\xCanBIyKvYKofpPPGD9vflQ0156kqNc4kLklFUAt.png

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirDocumentoRetificado($docRetificadoId, $facturaId, $viaImpressao)
    {


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "documento_retificadoFacturas"; //filename
        $options['params'] = ["empresa_id" => $empresa_id, "docAnuladoId" => $docRetificadoId, "facturaId" => $facturaId, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo




        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\QYGr36U5jfhQjI6bIyTVzBQZajfyWIwa48zgQ2Ps.jpg

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirFactura($idFactura, $tipoDocumento, $viaImpressao)
    {


        $tipoDocumentoTicket = 3;
        $tipoDocumentoA4 = 1;

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

        if ($tipoDocumento == $tipoDocumentoA4 || $tipoDocumento == "A4") {
            $filename = "Facturas"; //filename
        } else if ($tipoDocumento == $tipoDocumentoTicket) {
            $filename = "FacturaTicket";
        }
        //tipo A5
        else {
            $filename = "Facturas_A5";
        }

        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/relatorios/";

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/facturas/' . time() . $filename;
        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/facturas/" . $filename . ".jrxml";


        $options['format'] = ['pdf']; //formato arquivo

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);



        $options['params'] = [
            "dirSubreportBanco" => $DIR_SUBREPORT,
            "dirSubreportTaxa" => $DIR_SUBREPORT,
            "empresa_id" => $empresa_id,
            "facturaId" => $idFactura,
            "viaImpressao" => $viaImpressao,
            "logotipo" => $caminho
        ];

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirVendasDiaria($data)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "vendaDiaria"; //filename
        $options['params'] = ["empresa_id" => $empresa_id, "logotipo" => $caminho, "data_atual" => $data]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirVendasMensal($mes, $ano)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "vendaMensal"; //filename
        $options['params'] = ["empresa_id" => $empresa_id, "logotipo" => $caminho, "mes" => $mes, "ano" => $ano]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }


    public function imprimirFechoCaixa($dataFecho, $dataFechoFim, $tipoDoc)
    {

        $TIPO_A4 = 1;
        $TIPO_TICKET = 3;

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $user_id = Auth::user()->id;
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        if ($tipoDoc == $TIPO_TICKET) {
            $filename = "FechoCaixaTicket"; //filename
        } else if ($tipoDoc == $TIPO_A4) {
            $filename = "fechoDeCaixa"; //filename
        }

        //valor cash
        $valorCash = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('formas_pagamento_id', 1) //pgt numerario
            ->where('anulado', 1)->where('user_id', $user_id)
            ->sum('valor_a_pagar');




        $valorTransferencia = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 4) //pgt transferencia
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorDeposito = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 5) //pgt deposito
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorMulticaixa = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 3) //pgt multicaixa
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');


        //factura proforma
        $facturaProforma = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 3)
            ->where('formas_pagamento_id', null) // proforma
            ->where('anulado', 1)->where('user_id', $user_id)->count();

        $facturaAnulado = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('anulado', 2)->where('user_id', $user_id)->count();


        $valorTotalFacturado = EmpresaFactura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('formas_pagamento_id', 1) //pgt numerario
                    ->orwhere('formas_pagamento_id', 4) //pgt tranferencia
                    ->orwhere('formas_pagamento_id', 5) //pgt deposito
                    ->orwhere('formas_pagamento_id', 3); //pgt multicaixa
            })->sum('valor_a_pagar');


        $options['params'] = [
            "empresa_id" => $empresa['empresa']['id'],
            "logotipo" => $caminho,
            "operador" => $empresa['guard']['name'],
            "data_fecho" => $dataFecho,
            "valorCash" => $valorCash,
            "valorTransferencia" => $valorTransferencia,
            "valorDeposito" => $valorDeposito,
            "valorMulticaixa" => $valorMulticaixa,
            "facturaProforma" => $facturaProforma,
            "facturaAnulado" => $facturaAnulado,
            "valorTotalFacturado" => $valorTotalFacturado

        ]; //parametros where do report
        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }
    public function transferenciaImprimir($id)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "transferenciaProduto"; //filename


        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "transferenciaId" => $id]; //parametros where do report

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirEntradaStock($entradaId)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "entradaProdutos"; //filename

        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "entradaId" => $entradaId]; //parametros where do report

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirExistenciaStock($armazemId)
    {

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "existenciaStock"; //filename


        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "armazemId" => $armazemId]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirActualizacaoStock($actualizaStockId)
    {


        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "actualizaStock"; //filename


        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "actualizaStockId" => $actualizaStockId]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirExistenciaStocksPorId($existenciaId)
    {

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "existenciaStockPorId"; //filename


        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "existenciaStockId" => $existenciaId]; //parametros where do report



        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }
    public function imprimirPagamentoFornecedor($pagamentoId, $viaImpressao)
    {

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "pagamentoFornecedor"; //filename

        $options['params'] = ["viaImpressao" => $viaImpressao, "empresa_id" => $empresa_id, "logotipo" => $caminho, "pagamentoId" => $pagamentoId]; //parametros where do report

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;


        //dd($caminho);

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }

    public function imprimirInventario($inventarioId)
    {

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

        $caminho = public_path() . "\\upload\\" . str_replace("/", "\\", $empresaLogotipo[0]->logotipo);

        $filename = "inventario"; //filename

        $options['params'] = ["empresa_id" => $empresa_id, "diretorio" => $caminho, "inventarioId" => $inventarioId]; //parametros where do report

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/empresa/relatorios/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);
    }
}
