<?php

namespace App\Http\Controllers;

use App\Models\empresa\Factura;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\RSA;

class GerarHashController extends Controller
{

    public function gerarHash($dataInicial, $dataFinal)
    {

        $facturas = Factura::with('empresa')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->whereDate('created_at', '>=', $dataInicial)
            ->whereDate('created_at', '<=', $dataFinal)
            ->get();


        $array = array();

        foreach ($facturas as $key => $factura) {
            $lastFactura = $this->mostrarUltimafactura($factura);

            
            $hashAnterior = $lastFactura ? $lastFactura->hashValor : "";
            $numSequenciaFactura = $lastFactura ? ++$lastFactura->numSequenciaFactura: 1;
            

            if ($factura->tipo_documento == 2) {
                $numeracaoFactura = 'FT ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3).date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            }
            if ($factura->tipo_documento == 1) {            
                $numeracaoFactura = 'FR ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3).date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            }
            if ($factura->tipo_documento == 3) {
                $numeracaoFactura = 'PP ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3).date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            }

            $rsa = new RSA(); //Algoritimo RSA
            // Lendo a private key
            $rsa->loadKey($this->privatekey());

            $facturaCreated_at = explode(' ', $factura->created_at);
            $plaintext = $facturaCreated_at[0] . ';' . str_replace(' ', 'T', $factura->created_at) . ';' . $numeracaoFactura . ';' . number_format($factura->valor_a_pagar + $factura->retencao, 2, ".", "") . ';' . $hashAnterior;
            
            array_push($array, $plaintext);

            // HASH
            $hash = 'sha1'; // Tipo de Hash
            $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima
            
            //ASSINATURA
            $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
            $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)
            $hash = base64_encode($signaturePlaintext);
            // Lendo a public key
            $rsa->loadKey($this->publickey());


            
            DB::connection('mysql2')->table('facturas')
            ->where('id', $factura->id)
            ->where('empresa_id', Auth::user()->empresa_id)->update([
                'hashValor'=> $hash,
                'numeracaoFactura' => $numeracaoFactura,
                'numSequenciaFactura' => $numSequenciaFactura
            ]);
        }

       dd($array);

      //return $array;
    }
    public function mostrarUltimafactura($factura)
    {
        return DB::table('facturas')->where('empresa_id', Auth::user()->empresa_id)
            ->where('tipo_documento', $factura->tipo_documento)
            ->where('id', '<', $factura->id)
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    public function gerarNumeracaoFactura($factura)
    {

        if ($factura->tipo_documento == 1) {
            $numeracaoFactura = 'FR ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3) . date('Y')) . '/' . $factura->numSequenciaFactura;
        } else if ($factura->tipo_documento == 2) {
            $numeracaoFactura = 'FT ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3) . date('Y')) . '/' . $factura->numSequenciaFactura;
        } else if ($factura->tipo_documento == 3) {
            $numeracaoFactura = 'FP ' . mb_strtoupper(substr($factura->empresa->nome, 0, 3) . date('Y')) . '/' . $factura->numSequenciaFactura;
        }
        return $numeracaoFactura;
    }
    public function privatekey()
    {
        $privatekey = "MIICXAIBAAKBgQCqJsIyoKXnIyhFSwNZFE1lyGcsqn+6alTls2kzK8AsxIT21vD3
        ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBrZMk9qWbYrjuiXwAcMupXcR7d
        UWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQD5VdoAgE5YR240R4FQIDAQAB
        AoGAZq6pN2BXfltrLBYO2S01YB1Gll/2YQtWXKCe9fCLMvkNvOEN3mcFG4/FHRn0
        5R1ZoW4w9A+BaMcjHG8dbj/qHPD/9G3qvXmNN1J3d4vIe5QMqNEl8/OrdGGtxVlt
        QxDXjnsWr2vtayRZb7puxkxOBlLTyxfLlMVI3kefnv9U/+kCQQDdqzXNZsQiUIaP
        9GBaKE4/0rANYIINhf291u7XgyjuCdo+q3xuOyK0MNcJ/+ei0jLkXx9ao35mRggC
        nrJwWvnHAkEAxID4wrgWkb/7DEdf0xsMW2gk7Lq2L0/GziK1A3kMTUfCOfBy+fhY
        Suuu+1tw0oSlklYYlCzPT1CI+xf0HxofQwJAUxjzumRj8lktmJmL5UBm1RYuWVVs
        a5VnYdtI/hF1LocTAZtXshsJD3OfqWf9ddRGr8XZAyl3IO/v4MuNKQFx0QJATq7d
        7QpNbzsSSU5jHmLcRdWjw27X+IXXMz9Of/9+X4t2SEDxqQo6QHWy8U8iFAmtSrVS
        zjJLKJU05GYpCDMrhQJBAL6uhphR3SQgypTLlRB+XezzrDsjYBTPWjbGHekmT69k
        YODqjiQlUizmtxgJ3cZLU/hOFyJJ41qF+o2+SmwYy5s=";
        return $privatekey;
    }
    public function publickey()
    {
        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";
        return $publickey;
    }
}
