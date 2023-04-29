<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPJasper\PHPJasper;

class ReportsController extends Controller
{

    private $formato;


    public function __construct($formato = 'pdf')
    {
        $this->formato = $formato;
    }

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
    output => caminho e nome do arquivo que serÃ¡ gerado
    params => parametros passados na where do report ['id' => 1]
    options => todas configuraÃ§Ãµes (conexao, format ...)

    */
    

    public function resource($param)
    {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relatório que será gerado

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $param['report_file'];

        $input = public_path() . '/upload/documentos/empresa/relatorios/' . $param['report_jrxml'];

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
        // dd($filename);

        
    }

    public function show($param)
    {
        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relatório que será gerado

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/empresa/relatorios/' . time() . $param['report_file'];

        $input = public_path() . '/upload/documentos/empresa/relatorios/' . $param['report_jrxml'];

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
        // dd($filename);

        // return $filename;

        // caso o arquivo nÃ£o tenha sido gerado retorno um erro 404
        if (!file_exists($filename)) {
            abort(404);
        }
        header('Content-Description: application/' . $this->formato);
        header('Content-Type: application/' . $this->formato);
        header('Content-Disposition:; filename=' . $filename);
        readfile($filename);
        unlink($filename);
        flush();
    }
}
