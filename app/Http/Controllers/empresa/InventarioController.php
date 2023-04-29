<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa\Armazen;
use App\Models\empresa\AtualizacaoStocks;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Inventario;
use App\Models\empresa\InventarioItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
use phpseclib\Crypt\RSA as Crypt_RSA;

class InventarioController extends Controller
{

    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function index()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['inventarios'] = Inventario::with(['armazem', 'inventarioItems', 'inventarioItems.produto'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['atualizastock'] = AtualizacaoStocks::with(['produtos', 'armazens'])->where('empresa_id', $empresa['empresa']['id'])->get();


        $data['existenciastock'] =  DB::connection('mysql2')->table('existencias_stocks')
            ->join('produtos', 'produtos.id', '=', 'existencias_stocks.produto_id')
            ->join('armazens', 'armazens.id', '=', 'existencias_stocks.armazem_id')
            ->select('existencias_stocks.id AS existenciaId', 'existencias_stocks.*', 'produtos.designacao AS produtoDesignacao', 'produtos.*', 'armazens.designacao AS armazemDesignacao', 'armazens.*')
            ->where('produtos.stocavel', '=', 'Sim')
            ->where('existencias_stocks.empresa_id', $empresa['empresa']['id'])
            ->get();


        // $data['existenciastock'] = ExistenciaStock::with(['produtos', 'armazens'])
        //     ->has('produtos.stocavel', '=', 'Sim')
        //     ->where('empresa_id', $empresa['empresa']['id'])
        //     ->where('produtos.stocavel', '=', 'Sim')
        //     ->get();

        // dd($data['existenciastock']);

        return view("empresa.inventarios.index", $data);
    }
    public function store(Request $request)
    {
        $CANAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;

        $mensagem  = [
            'data_inventario.required' => "É obrigatorio a indicação do campo data inventário",
            'armazem_id.required' => "É obrigatorio a indicação do campo armazém",
        ];
        $validator = Validator::make($request->all(), [
            'data_inventario' => ['required'],
            'armazem_id' => ['required'],
            'inventarioData' => ['required']
        ], $mensagem);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $inventarios = DB::connection('mysql2')->table('inventarios')->where('empresa_id', $empresa['empresa']['id'])->orderBy('id', 'DESC')->limit(1)->first();

        //  dd($inventarios);

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($inventarios) {
            $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', $inventarios->created_at);
            $hashAnterior = $inventarios->hash;
        } else {
            $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($data_inventario->diffInYears($datactual) == 0) {
            if ($inventarios) {
                $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', $inventarios->created_at);
                $numSequenciaInventario = intval($inventarios->numSequenciaInventario) + 1;
            } else {
                $data_inventario = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaInventario = 1;
            }
        } else if ($data_inventario->diffInYears($datactual) > 0) {
            $numSequenciaInventario = 1;
        }



        $numeracaoInventario = 'IV ' . mb_strtoupper(substr($empresa['empresa']['nome'], 0, 3) . '' . date('Y')) . '/' . $numSequenciaInventario; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);


        $rsa = new Crypt_RSA(); //Algoritimo RSA

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


        $inventarioId = DB::connection('mysql2')->table('inventarios')->insertGetId([
            'empresa_id' => $empresa['empresa']['id'],
            'data_inventario' => date_format(date_create($request['data_inventario']), 'Y-m-d'),
            'user_id' => $empresa['operador'],
            'tipo_user_id' => 2, //empresa,
            'canal_id' => $CANAL_CLIENTE,
            'status_id' => $STATUS_ATIVO,
            'armazem_id' => $request->armazem_id,
            'observacao' => $request->observacao,
            'numSequenciaInventario' => $numSequenciaInventario,
            'numeracao' => $numeracaoInventario,
            'hash' => base64_encode($signaturePlaintext),
        ]);

        foreach ($request->inventarioData as $key => $value) {


            DB::connection('mysql2')->table('inventario_itens')->insertGetId([
                'inventario_id' => $inventarioId,
                'produto_id' => $value['produto_id'],
                'existenciaAnterior' => $value['existenciaActual'],
                'existenciaActual' => $value['existenciaNova'],
                'precoVenda' => $value['preco_venda'],
                'precoCompra' => $value['preco_compra'],
                'diferenca' => (int) $value['diferenca'],
                'actualizou' => $value['checked'] == true ? "Sim" : "Não",
            ]);

            if ($value['checked']) {
                $this->actualizarQtExistenciaStock($value, $empresa, $request->armazem_id);
                $this->actualizaStock($value, $empresa, $request->armazem_id);
            }
        }
        return response()->json($inventarioId, 200);
    }
    public function actualizarQtExistenciaStock($value, $empresa, $armazemId)
    {

        $existenciaStock = ExistenciaStock::where('produto_id', $value['produto_id'])
            ->where('armazem_id', $armazemId)
            ->where('empresa_id', $empresa['empresa']['id'])->first();
        $existenciaStock->quantidade = $value['existenciaNova'];
        $existenciaStock->observacao = "Inventario, actualiza stock para quantidade " . $value['existenciaNova'];
        $existenciaStock->save();
    }
    public function actualizaStock($value, $empresa, $armazemId)
    {

        $actualizaStock = AtualizacaoStocks::where('produto_id', $value['produto_id'])
            ->where('armazem_id', $armazemId)
            ->where('empresa_id', $empresa['empresa']['id'])->first();
        $actualizaStock->quantidade_nova = $value['existenciaNova'];
        $actualizaStock->quantidade_antes = $value['existenciaActual'];
        $actualizaStock->descricao = "Inventario, actualiza stock para quantidade " . $value['existenciaNova'];
        $actualizaStock->save();
    }
    public function imprimirInventario($inventarioId)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'inventario',
                'report_jrxml' => 'inventario.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'diretorio' => $caminho,
                    'inventarioId' => $inventarioId
                ]

            ]
        );
    }
}
