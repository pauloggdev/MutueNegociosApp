<?php

namespace App\Http\Controllers\contsys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;

class ReportsController extends Controller
{
    public function getDatabaseConfig()
    {
        return [

            'driver' => 'mysql',
            'username' => 'root',
            'password' => 'root',
            'host' => '127.0.0.1',
            'database' => 'contsys',
            'port' => '3306'
        ];

    }

    /*
    input => caminho e nome do arquivo gerado no report
    output => caminho e nome do arquivo que serÃƒÂ¡ gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configuraÃƒÂ§ÃƒÂµes (conexao, format ...)

    */

    public function show($param) {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado

        // coloca na variavel o caminho do novo relatÃƒÂ³rio que serÃƒÂ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $param['report_file'];

        $input = public_path() . '/upload/documentos/empresa/relatorios/'.$param['report_jrxml'];

        if(count($param['report_parameters'])){
            $options['params'] = $param['report_parameters'];
        }


        // chama o mÃƒÂ©todo que irÃƒÂ¡ gerar o relatÃƒÂ³rio
        // passamos por parametro:
        // o arquivo do relatÃƒÂ³rio com seu caminho completo
        // o nome do arquivo que serÃƒÂ¡ gerado
        // o tipo de saÃƒÂ­da
        // parametros ( nesse caso nÃƒÂ£o tem nenhum)

        $options['db_connection'] = $this->getDatabaseConfig();

        $report->process(
            $input,
            $output,
            $options
        )->execute();



        $filename = $output . '.pdf';
        // dd($filename);

        // caso o arquivo nÃƒÂ£o tenha sido gerado retorno um erro 404
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
