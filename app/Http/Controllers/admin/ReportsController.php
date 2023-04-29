<?php

namespace App\Http\Controllers\admin;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\DB;



class ReportsController extends PHPJasper
{

    public function getDatabaseConfig()
    {
        return [

            'driver' => 'mysql', //mysql, ....
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'port' => '3306'   
        ];

    }

    /*
    input => caminho e nome do arquivo gerado no report
    output => caminho e nome do arquivo que serÃ¡ gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configuraÃ§Ãµes (conexao, format ...)

    */

    public function show($param) {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relatório que será gerado

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/admin/relatorios/' . time() . $param['report_file'];

        $input = public_path() . '/upload/admin/relatorios/'.$param['report_jrxml'];

        if(count($param['report_parameters'])){
            $options['params'] = $param['report_parameters'];
        }


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
    
    
}
