<?php

namespace App\Http\Controllers\Api\Inventarios;

use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportsController as EmpresaReportsController;
use App\Http\Resources\ExistenciaStockResource;
use App\Models\empresa\AtualizacaoStocks;
use App\Models\empresa\ExistenciaStock;
use App\Repositories\Empresa\ExistenciaStockRepository;
use App\Repositories\Empresa\InventarioRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\RSA;

class InventarioIndexController extends Controller
{

    private $inventarioRepository;
    private $existenciaStockRepository;

    public function __construct(InventarioRepository $inventarioRepository, ExistenciaStockRepository $existenciaStockRepository)
    {
        $this->inventarioRepository = $inventarioRepository;
        $this->existenciaStockRepository = $existenciaStockRepository;
    }
    public function emitirInventario(Request $request)
    {
        $mensagem  = [
            'armazemId.required' => "Informe o armazém",
            'data_inventario.required' => "Informe a data do inventário",
            'existencias.*.id.required' => 'Informe a existência',

        ];
        $validator = Validator::make($request->all(), [
            'data_inventario' => ['required'],
            'armazemId' => ['required'],
            'existencias' => ['required'],
        ], $mensagem);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $inventario = DB::connection('mysql2')->table('inventarios')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'DESC')->limit(1)->first();

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($inventario) {
            $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', $inventario->created_at);
            $hashAnterior = $inventario->hash;
        } else {
            $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($data_inventario->diffInYears($datactual) == 0) {
            if ($inventario) {
                $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', $inventario->created_at);
                $numSequenciaInventario = intval($inventario->numSequenciaInventario) + 1;
            } else {
                $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaInventario = 1;
            }
        } else if ($data_inventario->diffInYears($datactual) > 0) {
            $numSequenciaInventario = 1;
        }

        $numeracaoInventario = 'IV ' . mb_strtoupper(substr(auth()->user()->empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaInventario; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);

        $rsa = new RSA(); //Algoritimo RSA

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

        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";

        // Lendo a private key
        $rsa->loadKey($privatekey);

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoInventario . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        DB::beginTransaction();

        try {
            $inventarioId = DB::connection('mysql2')->table('inventarios')->insertGetId([
                'empresa_id' => auth()->user()->empresa_id,
                'data_inventario' => date_format(date_create($request['data_inventario']), 'Y-m-d'),
                'user_id' => auth()->user()->id,
                'tipo_user_id' => 2, //empresa,
                'canal_id' => 4, //mobile,
                'status_id' => 1,
                'armazem_id' => $request->armazemId,
                'observacao' => $request->observacao,
                'numSequenciaInventario' => $numSequenciaInventario,
                'numeracao' => $numeracaoInventario,
                'created_at' => $request->data_inventario,
                'updated_at' => $request->data_inventario,
                'hash' => base64_encode($signaturePlaintext)
            ]);

            $existenciaStock = ExistenciaStock::where('armazem_id', $request->armazemId)
                ->where('empresa_id', auth()->user()->empresa_id)->get();

            foreach ($existenciaStock as $stock) {

                $quantidade_nova = $stock['quantidade'];

                $produto = DB::connection('mysql2')->table('produtos')->where('id', $stock['produto_id'])->first();
                foreach ($request->existencias as $existencia) {
                    if ($stock['produto_id'] == $existencia['produto_id']) {
                        $quantidade_nova = $existencia['quantidade_nova'];
                        $this->actualizarQtExistenciaStock($existencia, $produto, $request->armazemId);
                        $this->actualizaStock($existencia, $produto, $request->armazemId);
                    }
                }
                DB::connection('mysql2')->table('inventario_itens')->insertGetId([
                    'inventario_id' => $inventarioId,
                    'existenciaAnterior' => $stock['quantidade'],
                    'existenciaActual' => $quantidade_nova,
                    'precoVenda' => $produto->preco_venda,
                    'precoCompra' => $produto->preco_compra,
                    'produto_id' => $produto->id,
                    'diferenca' => (int) $quantidade_nova - $stock['quantidade'],
                    'actualizou' => 'Sim',
                ]);
            }

            DB::commit();
            return response()->json([
                'data' => [
                    'id' => $inventarioId,
                    'url' => env('APP_URL') . 'api/empresa/inventario/imprimir/' . $inventarioId,
                ],
                'message' => 'Operação realizada com sucesso'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function actualizarQtExistenciaStock($existencia, $produto, $armazemId)
    {

        $existenciaStock = ExistenciaStock::where('produto_id', $produto->id)
            ->where('armazem_id', $armazemId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        $existenciaStock->quantidade = $existencia['quantidade_nova'];
        $existenciaStock->observacao = "Inventario, actualiza stock para quantidade " . $existencia['quantidade_nova'];
        $existenciaStock->save();
    }
    public function actualizaStock($existencia, $produto, $armazemId)
    {
        $actualizaStock = AtualizacaoStocks::where('produto_id', $produto->id)
            ->where('armazem_id', $armazemId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();



        if (!$actualizaStock) {
            return AtualizacaoStocks::insert([
                'empresa_id' => auth()->user()->empresa_id,
                'produto_id' => $produto->id,
                'quantidade_antes' => $existencia['quantidade'],
                'quantidade_nova' => $existencia['quantidade_nova'],
                'user_id' => auth()->user()->id,
                'tipo_user_id' => 2,
                'canal_id' => 4,
                'status_id' => 1,
                'armazem_id' => $armazemId,
                'descricao' => "Inventario, actualiza stock para quantidade " . $existencia['quantidade_nova']
            ]);
        }
        $actualizaStock->empresa_id = auth()->user()->empresa_id;
        $actualizaStock->produto_id = $produto->id;
        $actualizaStock->quantidade_antes = $existencia['quantidade'];
        $actualizaStock->quantidade_nova = $existencia['quantidade_nova'];
        $actualizaStock->user_id = auth()->user()->id;
        $actualizaStock->tipo_user_id = 2;
        $actualizaStock->canal_id = 4;
        $actualizaStock->status_id = 1;
        $actualizaStock->armazem_id = $armazemId;
        $actualizaStock->descricao = "Inventario, actualiza stock para quantidade " . $existencia['quantidade_nova'];
        $actualizaStock->save();
    }
    public function imprimirInventario($inventarioId)
    {
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => auth()->user()->empresa_id]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new EmpresaReportsController();
        return $reportController->show(
            [
                'report_file' => 'inventario',
                'report_jrxml' => 'inventario.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $caminho,
                    'inventarioId' => $inventarioId
                ]

            ]
        );
    }
    public function listarProdutosPorArmazem($armazemId)
    {
        $produtos = $this->existenciaStockRepository->listarProdutosPorArmazem($armazemId);
        if (!$produtos) {
            return response()->json([
                'data' => null,
                'message' => 'Não existe produto para este armazém'
            ]);
        }
        return response()->json([
            'data' => ExistenciaStockResource::collection($produtos),
            'message' => 'listado os produtos por armazém'
        ]);
    }
}
