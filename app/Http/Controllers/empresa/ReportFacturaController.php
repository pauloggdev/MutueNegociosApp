<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;

class ReportFacturaController extends Controller
{
    public function getDatabaseConfig()
    {
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

    public function show($param)
    {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relat�rio que ser� gerado

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = $param['output'];
        $input = $param['input'];

        if (count($param['report_parameters'])) {
            $options['params'] = $param['report_parameters'];
        }

        $options['locale'] = 'pt';



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
        // dd($filename);

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
}
