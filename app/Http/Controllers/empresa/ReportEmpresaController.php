<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use PHPJasper\PHPJasper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\Empresa;

/*
     link doc
     C:\laragon\www\rs_inefop\vendor\geekcom\phpjasper\src/../bin/jasperstarter/bin

     composer require geekcom/phpjasper

     */

class ReportEmpresaController extends Controller
{


    public function getDatabaseConfig(){
        return [
            'driver' => 'mysql', //mysql, ....
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE2').'?useSSL=false',
            'port' => '3306'
        ];
    }
    /*
    input => caminho e nome do arquivo gerado no report
    output => caminho e nome do arquivo que será gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configurações (conexao, format ...)

    */

    public function exec($input, $output, array $options, $filename){


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

        $file = $output . '.pdf';
        $path = $file;

        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);
        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);
        // retornamos o conteudo para o navegador que íra abrir o PDF
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=" . $filename . ".pdf");
    }


    public function tabelaEmolumentos()
    {

        $filename = "tabelaEmolumentos"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/relatorios/frontOffice/' . time() . $filename;


        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/relatorios/frontOffice/" . $filename . ".jrxml";



        $options['format'] = ['pdf']; //formato arquivo
        $options['params'] = []; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }

    public function tabelaDocumentosCredenciarCentro()
    {

        $filename = "tabelaDocumentosCredenciarCentro"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/relatorios/frontOffice/' . time() . $filename;


        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/relatorios/frontOffice/" . $filename . ".jrxml";



        $options['format'] = ['pdf']; //formato arquivo
        $options['params'] = []; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }


    public function imprimirFactura(Request $request, $id, $refTipoFactura)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        // TUDO A VER COM REPORTER JASPER
        $filename = "tabelaDocumentosCredenciarCentro"; //filename

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/relatorios/frontOffice/' . time() . $filename;

        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/relatorios/frontOffice/" . $filename . ".jrxml";

        $options['format'] = ['pdf']; //formato arquivo
        $options['params'] = ["idFactura"=>1]; //parametros where do report

        return $this->exec($input, $output, $options, $filename);
    }
}
