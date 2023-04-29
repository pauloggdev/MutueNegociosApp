<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;

class ReportController extends Controller
{
    /**
     * Reporna um array com os parametros de conexÃ£o
     * @return Array
     */

    /* instalaÃ§Ã£o do phpjasper do lavela via composer
     
        composer require lavela/phpjasper
    */
    public function teste()
    {

        $input = public_path() . '/upload/documentos/empresa/relatorios/armazens.jasper';
        $output = public_path() . '/upload/documentos/empresa/relatorios/bbbbb';
        $options = [
            'format' => ['pdf', 'rtf'],
            'params' => ["empresa_id" => 27, "status_id" => "%" . 1],
            'db_connection' => [
                'driver' => 'mysql', //mysql, ....
                'username' => env('DB_USERNAME2'),
                'password' => env('DB_PASSWORD2'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE2'),
                'port' => '3306'
            ]
        ];



        $jasper = new PHPJasper;

        $jasper->process(
            $input,
            $output,
            $options
        )->execute();

        dd($jasper);
    }

    public function getDatabaseConfig()
    {

        //dd(env('DB_CONNECTION2'));
        return [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST'),
            'username' => env('DB_USERNAME2'),
            'password' => env('DB_PASSWORD2'),
            'database' => env('DB_DATABASE2'),
            'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . ';dataBaseName=' . env('DB_DATABASE2'),
        ];
    }
    public function index()
    {

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '\storage\documentos\empresa\relatorios\\' . time() . 'bancos';


        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // dd($report);



        // chama o mÃ©todo que irÃ¡ gerar o relatÃ³rio
        // passamos por parametro:
        // o arquivo do relatÃ³rio com seu caminho completo
        // o nome do arquivo que serÃ¡ gerado
        // o tipo de saÃ­da
        // parametros ( nesse caso nÃ£o tem nenhum)

        $options['db_connection'] = $this->getDatabaseConfig();
        $options['format'] = ['pdf'];

        $options['params'] = ["empresa_id" => 27];

        //dd(public_path() . '\storage\documentos\empresa\relatorios\bancos.jrxml');


        $report->process(
            public_path() . '\storage\documentos\empresa\relatorios\bancos.jrxml',
            $output,
            $options
        )->execute();

        // print_r($x);

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
            ->header('Content-Disposition', 'inline; filename="bancos.pdf"');
    }
}
