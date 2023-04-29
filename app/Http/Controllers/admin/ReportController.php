<?php

namespace App\Http\Controllers\admin;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\DB;



class ReportController extends PHPJasper
{
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

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
    public function imprimirFactura($idFactura, $tipoDocumento, $viaImpressao){


        $tipoDocumentoTicket = 3;
        $tipoDocumentoA4 = 1;

        if($this->isAdmin()){
            return view('admin.dashboard'); 
        }


        $empresa_mysql2 = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $empresa = Empresa::where('referencia', $empresa_mysql2['referencia'])->first();

        if($tipoDocumento == $tipoDocumentoA4){
            $filename = "Factura"; //filename
        }else if($tipoDocumento == $tipoDocumentoTicket){
            $filename = "FacturaTicket";
        }
        //tipo A5
        else{
            $filename = "Facturas_A5";
        }
        
        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/documentos/admin/facturas/' . time() . $filename;
        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/documentos/admin/facturas/" . $filename . ".jrxml";

        
        $options['format'] = ['pdf']; //formato arquivo
        
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_mysql2['id']]);
        
        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;

        //C:\laragon\www\api-mutue-negocio\public\upload\utilizadores\cliente\yRkDYawuhl0HuTs8E23uUFH1KrSuXASfMGqRvkeB.jpg
        
        $options['params'] = ["empresa_id" => $empresa->id, "facturaId" => $idFactura, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report
        return $this->exec($input, $output, $options, $filename);

    }
    public function imprimirReciboLicenca($reciboFacturaLicencaId, $viaImpressao){

        $empresa_mysql2 = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $empresa = Empresa::where('referencia', $empresa_mysql2['referencia'])->first();

        $filename = "reciboFacturasLicenca1"; //filename

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/admin/relatorios/' . time() . $filename;
        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/admin/relatorios/" . $filename . ".jrxml";

        
        $options['format'] = ['pdf']; //formato arquivo
        
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_mysql2['id']]);
        
        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;
        
        $options['params'] = ["viaImpressao"=>$viaImpressao,"empresa_id" => $empresa->id, "logotipo" => $caminho, "reciboFacturaLicencaId" => $reciboFacturaLicencaId]; //parametros where do report

        // coloca na variavel o caminho do novo relatÃ³rio que serÃ¡ gerado
        $output = public_path() . '/upload/admin/relatorios/' . time() . $filename;
        //caminho e nome do arquivo gerado no report
        $input = public_path() . "/upload/admin/relatorios/" . $filename . ".jrxml";
        
        $options['format'] = ['pdf']; //formato arquivo

        return $this->exec($input, $output, $options, $filename);

    }
}
