<?php

namespace App\Repositories\Admin;

use App\Http\Controllers\TypeInvoice;
use App\Models\admin\ComprovativoFactura;
use App\Repositories\Empresa\TraitChavesEmpresa;
use App\Models\admin\FacturaUserAdicionar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;
use Carbon\Carbon;


class FacturaUserAdicionarRepository
{

    protected $entity;
    protected $empresaRepository;
    protected $comprovativo;
    use TraitChavesEmpresa;


    public function __construct(FacturaUserAdicionar $factura, EmpresaRepository $empresaRepository, ComprovativoFactura $comprovativo)
    {
        $this->entity = $factura;
        $this->empresaRepository = $empresaRepository;
        $this->comprovativo = $comprovativo;
    }
    public function listarComprovativosAvalidar(){

        return $this->comprovativo::with(['factura'])->paginate();

    }
    public function salvarFacturaUtilizadorAdicionado($data)
    {

        $empresa = $this->empresaRepository->getEmpresaPelaReferencia(auth()->user()->empresa->referencia);
        $facturas = $this->pegarUltimaFactura($empresa);

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
        $numeracaoFactura = 'FT ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        $data['data_vencimento'] = Carbon::now()->addDays(15);



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


        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($data['valor_pagar'] + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenaÃ§Ãµes)

        // Lendo a public key
        $rsa->loadKey($publickey);


        // $empresa = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();

        try {
            DB::beginTransaction();
            $facturaId = DB::connection('mysql')->table('facturas_users_adicionais')->insertGetId([

                'total_preco_factura' => $data['valor_pagar'],
                'troco' => 0,
                'valor_entregue' => 0,
                'valor_a_pagar' => $data['valor_pagar'],
                'desconto' => 0,
                'retencao' => 0,
                'total_iva' => 0,
                'nome_do_cliente' => auth()->user()->empresa->nome,
                'valor_extenso' => $data['valor_extenso'],
                'telefone_cliente' => auth()->user()->empresa->pessoal_Contacto,
                'endereco_cliente' => auth()->user()->empresa->endereco,
                'nif_cliente' => auth()->user()->empresa->nif,
                'email_cliente' => auth()->user()->empresa->email,
                'statusFactura' => TypeInvoice::STATUS_DIVIDA,
                'numeracaoFactura' => $numeracaoFactura,
                'hashValor' => base64_encode($signaturePlaintext),
                'text_hash' => $plaintext,
                'empresa_id' => $empresa->id,
                'canal_id' => $data['canal_id'] ?? 2,
                'status_id' => 1,
                'user_id' => auth()->user()->id,
                'operador' => auth()->user()->name,
                'user_id_adicionado' => $data['user']['id'],
                'nome_utilizador_adicionado' => Str::upper($data['user']['name']),
                'licenca_id' => $data['licenca']['id'],
                'valor_licenca' => $data['licenca']['valor'],
                'data_vencimento' => $data['data_vencimento'],
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
            ]);
            DB::commit();
            return $facturaId;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function enviarComprovativoFacturaUserAdicionado($comprovativo, $userId)
    {

        $facturaId = $this->entity::where('user_id_adicionado', $userId)->first()->id;

        $comprovativoAnexado = $comprovativo->store('/documentos/admin/comprovativos');
        $comprovativoAnterior = DB::connection('mysql')->table('comprovativos_facturas')->where('factura_id', $facturaId)->first();
        if ($comprovativoAnterior) {
            $path = public_path() . "\\upload\\" . $comprovativoAnterior->comprovativo_pgt_recibos;
            if (file_exists($path)) {
                unlink($path);
            }
            DB::connection('mysql')->table('comprovativos_facturas')->where('factura_id', $facturaId)->delete();
        }
        return DB::connection('mysql')->table('comprovativos_facturas')->insertGetId([
            'factura_id' => $facturaId,
            'comprovativo_pgt_recibos' => $comprovativoAnexado,
            'status_id' => 1
        ]);
    }
    public function pegarUltimaFactura($empresa)
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return $this->entity::where('empresa_id', $empresa->id)
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('numeracaoFactura', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    private function mostrarSerieDocumento()
    {
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        return mb_strtoupper(substr(Str::slug($empresa->nome), 0, 3));
    }
}
