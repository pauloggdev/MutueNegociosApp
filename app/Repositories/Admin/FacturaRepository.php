<?php

namespace App\Repositories\Admin;

use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Http\Controllers\TypeInvoice;
use App\Models\admin\Factura;
use App\Repositories\Empresa\TraitChavesEmpresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;
use Keygen\Keygen;

class FacturaRepository
{

    use LivewireAlert;
    use TraitChavesEmpresa;


    protected $entity;

    public function __construct(Factura $entity)
    {
        $this->entity = $entity;
    }

    public function alterarStatuFacturaParaDivida(int $facturaId, int $empresaId)
    {
        $factura = $this->entity::where('empresa_id', $empresaId)->find($facturaId);
        $factura->statusFactura = $this->entity::STATUDIVIDA;
        $factura->save();
    }
    public function alterarStatuFacturaParaPago(string $referenciaFactura, int $empresaId): bool
    {
        $factura = Factura::where('faturaReference', $referenciaFactura)->where('empresa_id', $empresaId)->first();
        $factura->statusFactura = Factura::STATUPAGO;
        return $factura->save();
    }
    public function listarFacturas($search = null)
    {
        $empresa = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $factura = Factura::where('empresa_id', $empresa->id)->orderBy('id', 'DESC')
        ->search(trim($search))
        ->paginate();

        return $factura;
    }
    public function listarFacturasSemPaginate()
    {
        $empresa = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $factura = Factura::where('empresa_id', $empresa->id)->orderBy('id', 'DESC')->get();

        return $factura;
    }

    public function efectuarFactura($factura)
    {


        if ($factura['tipo_documento'] == TypeInvoice::FACTURA) {
            $facturas = $this->pegarUltimaFactura('FACTURA');
            $factura['statusFactura'] = TypeInvoice::STATUS_DIVIDA;
        }

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($facturas) {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
            $hashAnterior = $facturas->hashValor;
        } else {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //ManipulaÃ§Ã£o de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequÃªncia numÃ©rica da Ãºltima factura cadastrada no banco de dados e adiona sempre 1 na sequÃªncia caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequÃªncia numÃ©rica caso se constate que o ano da factura Ã© inferior ao ano actual.*/
        if ($data_factura->diffInYears($datactual) == 0) {
            if ($facturas) {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
                $numSequenciaFactura = intval($facturas->numSequenciaFactura) + 1;
            } else {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaFactura = 1;
            }
        } else if ($data_factura->diffInYears($datactual) > 0) {
            $numSequenciaFactura = 1;
        }

        /*Cria uma sÃ©rie de numerÃ§Ã£o para cada factura, variando de acordo o tipo de factura, a o ano actual e numero sequencial da factura */
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA) {
            $numeracaoFactura = 'FT ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            $factura['data_vencimento'] = Carbon::now()->addDays(15);
        }

        $rsa = new RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverÃ¡ ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estarÃ¡ mais ou menos assim apÃ³s as
        ConcatenaÃ§Ãµes com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        //dd($request->total_retencao);
        // $total_preco_factura = $request->total_preco_factura - $request->desconto;
        // $totalRetencao  = $total_preco_factura * $request->retencao;

        $totalRetencao = 0;


        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($factura['valor'] + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenaÃ§Ãµes)

        // Lendo a public key
        $rsa->loadKey($publickey);


        $empresa = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();

        try {
            DB::beginTransaction();
            $facturaId = DB::connection('mysql')->table('facturas')->insertGetId([

                'total_preco_factura' => $factura['valor'],
                'valor_entregue' => 0,
                'valor_a_pagar' => $factura['valor'],
                'troco' => 0,
                'valor_extenso' => $factura['valor_extenso'],
                'codigo_moeda' => 1,
                'desconto' => 0,
                'total_iva' => 0,
                'multa' => 0,
                'nome_do_cliente' => auth()->user()->empresa->nome,
                'telefone_cliente' => auth()->user()->empresa->pessoal_Contacto,
                'nif_cliente' => auth()->user()->empresa->nif,
                'email_cliente' => auth()->user()->empresa->email,
                'endereco_cliente' => auth()->user()->empresa->endereco,
                'statusFactura' => TypeInvoice::STATUS_DIVIDA,
                'numeroItems' => 1,
                'tipo_documento' => 'FACTURA',
                'retencao' => 0,
                'faturaReference' => mb_strtoupper(Keygen::numeric(9)->generate()),
                'numSequenciaFactura' => $numSequenciaFactura,
                'numeracaoFactura' => $numeracaoFactura,
                'tipoFolha' => 'A4',
                'hashValor' => base64_encode($signaturePlaintext),
                'empresa_id' => $empresa->id,
                'canal_id' => 2,
                'descricao' => Str::upper('LICENÇA ' . $factura['designacao']),
                'licenca_id' => $factura['id'],
                'status_id' => 1,
                'user_id' => auth()->user()->id,
                'data_vencimento' => $factura['data_vencimento'],
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
            ]);

            DB::connection('mysql')->table('factura_items')->insert([
                'descricao_produto' => Str::upper('LICENÇA ' . $factura['designacao']),
                'preco_produto' => $factura['valor'],
                'quantidade_produto' => $factura['quantidade'],
                'total_preco_produto' =>  $factura['valor'],
                'licenca_id' => $factura['tipo_licenca_id'],
                'factura_id' => $facturaId,
                'desconto_produto' => 0,
                'retencao_produto' => 0,
                'incidencia_produto' => $factura['valor'],
                'iva_produto' => 0,
            ]);

            DB::commit();
            return $facturaId;
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
    public function pegarUltimaFactura($tipoDocumento)
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return  DB::connection('mysql')->table('facturas')
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('tipo_documento', $tipoDocumento)
            ->where('numeracaoFactura', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    private function mostrarSerieDocumento()
    {
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        return mb_strtoupper(substr(Str::slug($empresa->nome), 0, 3));
    }
}
