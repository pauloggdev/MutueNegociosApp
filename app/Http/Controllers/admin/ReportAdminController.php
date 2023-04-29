<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use PHPJasper\PHPJasper;

class ReportAdminController extends Controller
{

    private $formato;
    private $path;


    public function __construct($formato = 'pdf', $path = '/upload/admin/relatorios/')
    {
        $this->formato = $formato;
        $this->path = $path;
    }

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

    public function show($param)
    {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();

        // coloca na variavel o caminho do novo relatório que será gerado

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . $this->path . time() . $param['report_file'];

        $input = public_path() . $this->path . $param['report_jrxml'];

        if (count($param['report_parameters'])) {
            $options['params'] = $param['report_parameters'];
        }
        $options['locale'] = 'pt';
        $options['format'] = [$this->formato];




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

        $filename = $output . '.' . $this->formato;

        // $header = [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Description' => 'application/pdf',
        //     'Content-Disposition' => 'filename=' . time() . $param['report_file']

        // ];

        // caso o arquivo nÃ£o tenha sido gerado retorno um erro 404
        if (!file_exists($filename)) {
            abort(404);
        }


        $response = Response::make(file_get_contents($filename), 200, [
            'Content-Type' => $this->formato == 'xls' ? 'application/vnd.ms-exce' : 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);

        return [
            'response' => $response,
            'filename' => $filename,
            'file' => $this->path . time() . $param['report_file'] . '.' . $this->formato
        ];
    }
}
