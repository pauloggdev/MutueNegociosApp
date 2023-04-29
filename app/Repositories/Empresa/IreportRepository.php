<?php

namespace App\Repositories\Empresa;

use App\Repositories\contracts\IreportRepositoryInterface;
use App\Traits\Empresa\TraitPathRelatorio;
use PHPJasper\PHPJasper;

class IreportRepository extends PHPJasper implements IreportRepositoryInterface
{

    use TraitPathRelatorio;

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
    public function show(array $params)
    {

        // instancia um novo objeto JasperPHP
        $report = new PHPJasper();
        // coloca na variavel o caminho do novo relatório que será gerado

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = $this->getPathRelatorio() . time() . $params['report_file'];



        //   dd($output);

        $input = $this->getPathRelatorio() . $params['report_jrxml'];

        if (count($params['report_parameters'])) {
            $options['params'] = $params['report_parameters'];
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
