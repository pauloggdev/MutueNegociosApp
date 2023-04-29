<?php

namespace App\Http\Controllers\empresa;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\EntradaStock;
use App\Models\empresa\EntradaStockItems;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Produto;
use App\Models\empresa\TransferenciaProduto;
use App\Models\empresa\TransferenciaProdutoItems;
use App\Rules\Empresa\EmpresaUnique;
use App\Rules\Empresa\MultEmpresaUnique;
use Illuminate\Http\Request;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class StockController extends Controller
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;


    public function transferenciaIndex()
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
        $data['transferencia'] = TransferenciaProduto::with(['TransferenciaProdutoItems'])->where('empresa_id', $empresa['empresa']['id'])->get();

        return view('empresa.operacao.transferenciaProdutoIndex', $data);
    }
    public function transferenciaNovo(Request $request)
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

        $data['produtos'] = Produto::with(['existenciaEstock', 'statuGeral'])->where('stocavel', 'Sim')->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['existenciastock'] = ExistenciaStock::where('empresa_id', $empresa['empresa']['id'])->get();

        return view('empresa.operacao.transferenciaProdutoNovo', $data);
    }
    public function transferenciaSalvar(Request $request)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $message = [
            'canal_id.required' => 'É obrigatório a indicação do canal de comunicação',
            'transferenciaProdutoItems.required' => 'É obrigatório adicionar os Items a transferir'
        ];

        $validator = Validator::make($request->all(), [

            'canal_id' => ['required'],
            'transferenciaProdutoItems' => ['required', function ($attribute, $transfItens, $fail) {

                foreach ($transfItens as $key => $value) {

                    if ($value['armazem_origem_id'] == $value['armazem_destino_id']) {
                        $fail('o armazém origem deve ser diferente do armazém destino');
                        return;
                    }
                    if (!$value['armazem_origem_id']) {
                        $fail('É obrigatório a indicação do campo armazem de origem');
                        return;
                    }
                    if (!$value['produto_id']) {
                        $fail('É obrigatório a indicação do produto');
                        return;
                    }
                    if (!$value['armazem_destino_id']) {
                        $fail('É obrigatório a indicação do campo armazem de destino');
                        return;
                    }
                    if (!$value['quantidade_transferida']) {
                        $fail('É obrigatório adicionar os Items a transferir');
                        return;
                    }
                    if (!$value['armazem_origem']) {
                        $fail('É obrigatório a indicação do campo nome do armazem de origem');
                        return;
                    }
                    if (!$value['armazem_destino']) {
                        $fail('É obrigatório a indicação do campo nome do armazem de origem');
                        return;
                    }
                }
            }]
        ], $message);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages());
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa = Empresa_Cliente::where('referencia', $referencia)->first();
            $data['guard'] = Auth::guard('web')->user();
            $tipoUserId = 2; //empresa
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $data['guard'] = Auth::guard('empresa')->user();
            $tipoUserId = 3; //funcionario
        }



        $ultimaTransferencia = DB::connection('mysql2')->table('transferencias_produtos')->where('empresa_id', $empresa->id)->orderBy('id', 'DESC')->limit(1)->first();
        if ($ultimaTransferencia) {
            $data_transferencia = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaTransferencia->created_at);
        } else {
            $data_transferencia = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($data_transferencia->diffInYears($datactual) == 0) {
            if ($ultimaTransferencia) {
                $data_transferencia = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaTransferencia->created_at);
                $numSequenciaTransferencia = intval($ultimaTransferencia->numSequenciaTransferencia) + 1;
            } else {
                $data_transferencia = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaTransferencia = 1;
            }
        } else if ($data_transferencia->diffInYears($datactual) > 0) {
            $numSequenciaTransferencia = 1;
        }

        $numeracaoTransferencia = 'TP ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaTransferencia; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);


        DB::beginTransaction();

        try {
            $transferenciaProdutoId = DB::connection('mysql2')->table('transferencias_produtos')->insertGetId([

                'user_id' => Auth::user()->id,
                'canal_id' => $request->canal_id,
                'empresa_id' => $empresa->id,
                'numeracao_transferencia' => $numeracaoTransferencia,
                'numSequenciaTransferencia' => $numSequenciaTransferencia,
                'tipo_user_id' => $tipoUserId,
                'descricao' => $request->descricao

            ]);

            foreach ($request->transferenciaProdutoItems as $key => $transfItem) {

                DB::connection('mysql2')->table('transferencias_produto_items')->insertGetId([
                    'produto_id' => $transfItem['produto_id'],
                    'produto_designacao' => $transfItem['produto_designacao'],
                    'transferencia_produto_id' => $transferenciaProdutoId,
                    'armazem_origem_id' => $transfItem['armazem_origem_id'],
                    'armazem_destino_id' => $transfItem['armazem_destino_id'],
                    'quantidade_transferida' => $transfItem['quantidade_transferida'],
                    'armazem_origem' => $transfItem['armazem_origem'],
                    'armazem_destino' => $transfItem['armazem_destino']
                ]);

                //Existência estoque do armazém de origem
                $existenciaStockOrigem = ExistenciaStock::where('empresa_id', $empresa->id)
                    ->where('produto_id', $transfItem['produto_id'])
                    ->where('armazem_id', $transfItem['armazem_origem_id'])->first();

                if ($transfItem['quantidade_transferida'] <= $existenciaStockOrigem->quantidade) {
                    DB::connection('mysql2')->table('existencias_stocks')->where('id', $existenciaStockOrigem->id)->update([
                        'quantidade' => $existenciaStockOrigem->quantidade - $transfItem['quantidade_transferida']
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['isValid' => false, 'errors' => 'Quantidade a transferir maior que a existente'], 401);

                    // return response()->json("Erro, quantidade a transferir maior que a existente", 401);
                }

                //Existência estoque do armazém de destino
                $existenciaStockDestino = ExistenciaStock::where('empresa_id', $empresa->id)
                    ->where('produto_id', $transfItem['produto_id'])
                    ->where('armazem_id', $transfItem['armazem_destino_id'])->first();


                if ($transfItem['quantidade_transferida'] > $existenciaStockOrigem->quantidade) {
                    DB::rollBack();
                    return response()->json(['isValid' => false, 'errors' => 'Quantidade a transferir maior que a existente'], 401);
                }
                if ($existenciaStockDestino) {
                    DB::connection('mysql2')->table('existencias_stocks')->where('id', $existenciaStockDestino->id)->update([
                        'quantidade' => $existenciaStockDestino->quantidade + $transfItem['quantidade_transferida']
                    ]);
                } else {

                    $STATUS_ATIVO = 1;

                    $existenciaStock = new ExistenciaStock();
                    $existenciaStock->produto_id = $transfItem['produto_id'];
                    $existenciaStock->armazem_id = $transfItem['armazem_destino_id'];
                    $existenciaStock->quantidade = $transfItem['quantidade_transferida'];
                    $existenciaStock->canal_id = $request->canal_id;
                    $existenciaStock->user_id = Auth::user()->id;
                    $existenciaStock->status_id = $STATUS_ATIVO;
                    $existenciaStock->empresa_id = $empresa->id;
                    $existenciaStock->save();
                }
            }
            DB::commit();
            if ($transferenciaProdutoId) {
                return response()->json($this->transferenciaImprimir($transferenciaProdutoId), 200);
            }
            return response()->json($transferenciaProdutoId, 200);
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }
    public function transferenciaImprimir($id)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'transferenciaProduto',
                'report_jrxml' => 'transferenciaProduto.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    "diretorio" => $caminho,
                    "transferenciaId" => $id
                ]
            ]
        );
    }

    public function verificarValorCorrespondePrecoCompra($request)
    {

        $totalSemImpostoSemDesconto = $request->totalSemImpostoSemDesconto;
        $totalDesconto = $request->totalDesconto;
        $totalRetencao = $request->totalRetencao;
        $totalIva = $request->totalIva;


        return $totalSemImpostoSemDesconto - $totalDesconto - $totalRetencao + $totalIva;
    }

    public function entradaStock(Request $request)
    {

        $PORTAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;

        $message = [

            'totalSemImpostoSemDesconto' => 'É obrigatório a indicação do campo total sem imposto/Desc ',
            'totalDesconto' => 'É obrigatório a indicação do campo total desconto ',
            'totalRetencao' => 'É obrigatório a indicação do campo total retenção',
            'totalIva' => 'É obrigatório a indicação do campo total IVA',
            'num_factura_fornecedor.required' => 'É obrigatório a indicação do campo número da factura',
            'fornecedor_id.required' => 'É obrigatório a indicação do campo fornecedor',
            'armazem_id.required' => 'É obrigatório a indicação do campo armazém',
            'forma_pagamento_id.required' => 'É obrigatório a indicação da forma de pagamento',
            'num_factura_fornecedor.required' => 'É obrigatório a indicação do campo número da factura',
            'num_factura_fornecedor.unique' => 'O valor indicado para o campo número da factura já se encontra registado',
        ];

        $this->validate($request, [
            'totalSemImpostoSemDesconto' => ['required'],
            'totalDesconto' => ['required'],
            'totalRetencao' => ['required'],
            'totalIva' => ['required'],
            'num_factura_fornecedor' => ['required'],
            'fornecedor_id' => ['required'],
            'armazem_id' => ['required'],
            'forma_pagamento_id' => ['required'],
            'num_factura_fornecedor' => ['required', new EmpresaUnique('entradas_stocks', 'mysql2')],
            'produtos' => ['required', function ($attribute, $entradaProdutoItens, $fail) {

                foreach ($entradaProdutoItens as $key => $value) {

                    if (!$value['produto_id']) {
                        $fail('É obrigatório adicionar item de entrada');
                        return;
                    }
                    if (!$value['quantidade'] || $value['quantidade'] <= 0) {
                        $fail('É obrigatório a quantidade');
                        return;
                    }
                    if (!$value['preco_compra']) {
                        $fail('É obrigatório a indicação do campo preço de compra');
                        return;
                    }

                    if (!$value['lucroUnitario'] && $value['lucroUnitario'] != 0) {
                        $fail('É obrigatório a indicação do campo lucro unitario');
                        return;
                    }
                    if (!$value['total_venda']) {
                        $fail('É obrigatório a indicação do campo total venda');
                        return;
                    }
                    if (!$value['total_compra']) {
                        $fail('É obrigatório a indicação do campo total compra');
                        return;
                    }
                }
            }]
        ], $message);


        $VENDA_CREDITO = 2;

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->messages());
        // }
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $formaPagamentoId = $request->forma_pagamento_id;

        // $this->verificarFacturaCredito($formaPagamentoId);

        if ($VENDA_CREDITO == $formaPagamentoId) {
            $statusPagamento = 2; //Divida
        } else {
            $statusPagamento = 1; //Pago
        }
        $data_factura_fornecedor = date("Y-m-d", strtotime($request->get('data_factura_fornecedor')));

        $entradaStock = new EntradaStock();
        $entradaStock->data_factura_fornecedor = $data_factura_fornecedor;
        $entradaStock->fornecedor_id = $request->fornecedor_id;
        $entradaStock->empresa_id = $empresa['empresa']['id'];
        $entradaStock->forma_pagamento_id = $formaPagamentoId;
        $entradaStock->tipo_user_id = $empresa['tipo_user_id'];
        $entradaStock->num_factura_fornecedor = $request->num_factura_fornecedor;
        $entradaStock->descricao = "Entrada da factura " . $request->num_factura_fornecedor;
        $entradaStock->total_compras = $request->total_compras;
        $entradaStock->total_venda = $request->total_venda;
        $entradaStock->total_iva = $request->totalIva;
        $entradaStock->total_desconto = $request->totalDesconto;
        $entradaStock->total_retencao = $request->totalRetencao;
        $entradaStock->user_id = $empresa['operador'];
        $entradaStock->operador = Auth::user()->name;
        $entradaStock->canal_id = $PORTAL_CLIENTE;
        $entradaStock->status_id = $STATUS_ATIVO;
        $entradaStock->statusPagamento = $statusPagamento;
        $entradaStock->armazem_id = $request->armazem_id;
        $entradaStock->totalLucro = $request->totalLucro;
        $entradaStock->save();

        if ($entradaStock) {
            foreach ($request->produtos as $key => $produto) {
                $entradaStockItems = new EntradaStockItems();
                $entradaStockItems->entrada_stock_id = $entradaStock->id;
                $entradaStockItems->produto_id = $produto['produto_id'];
                $entradaStockItems->preco_compra = $produto['preco_compra'];
                $entradaStockItems->preco_venda = $produto['preco_venda'];
                $entradaStockItems->descontoPerc = $produto['descontoPerc'];
                $entradaStockItems->quantidade = $produto['quantidade'];
                $entradaStockItems->lucroUnitario = $produto['lucroUnitario'];
                $entradaStockItems->save();
                ExistenciaStock::where('armazem_id', $request->armazem_id)
                    ->where('empresa_id', $empresa['empresa']['id'])
                    ->where('produto_id', $produto['produto_id'])->increment('quantidade', $produto['quantidade']);
            }
            return $this->imprimirEntradaStock($entradaStock->id);
        }
    }

    public function verificarFacturaCredito($formaPagamentoId)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $TIPO_CREDITO = 1;

        $formaPagamento =  DB::connection('mysql2')->table('formas_pagamentos')
            ->where('empresa_id', $empresa['empresa']['id'])->where('id', $formaPagamentoId)->first();

        if ($formaPagamento->tipo_credito == $TIPO_CREDITO) {
            return true;
        }
        return false;
    }

    public function imprimirEntradaStock($entradaStockId)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'entradaProdutos',
                'report_jrxml' => 'entradaProdutos.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'diretorio' => $caminho,
                    'entradaId' => $entradaStockId
                ]

            ]
        );
    }

    public function entradaStockApi(Request $request)
    {

        $PORTAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;

        $message = [

            'totalSemImpostoSemDesconto' => 'É obrigatório a indicação do campo total sem imposto/Desc ',
            'totalDesconto' => 'É obrigatório a indicação do campo total desconto ',
            'totalRetencao' => 'É obrigatório a indicação do campo total retenção',
            'totalIva' => 'É obrigatório a indicação do campo total IVA',
            'num_factura_fornecedor.required' => 'É obrigatório a indicação do campo número da factura',
            'fornecedor_id.required' => 'É obrigatório a indicação do campo fornecedor',
            'armazem_id.required' => 'É obrigatório a indicação do campo armazém',
            'forma_pagamento_id.required' => 'É obrigatório a indicação da forma de pagamento',
            'num_factura_fornecedor.required' => 'É obrigatório a indicação do campo número da factura',
            'num_factura_fornecedor.unique' => 'O valor indicado para o campo número da factura já se encontra registado',
        ];

        $this->validate($request, [
            'totalSemImpostoSemDesconto' => ['required'],
            'totalDesconto' => ['required'],
            'totalRetencao' => ['required'],
            'totalIva' => ['required'],
            'num_factura_fornecedor' => ['required'],
            'fornecedor_id' => ['required'],
            'armazem_id' => ['required'],
            'forma_pagamento_id' => ['required'],
            'num_factura_fornecedor' => ['required', new MultEmpresaUnique('entradas_stocks', 'mysql2')],
            'produtos' => ['required', function ($attribute, $entradaProdutoItens, $fail) {


                foreach ($entradaProdutoItens as $key => $value) {

                    if (!$value['produto_id']) {
                        $fail('É obrigatório adicionar item de entrada');
                        return;
                    }
                    if (!$value['quantidade'] || $value['quantidade'] <= 0) {
                        $fail('É obrigatório a quantidade');
                        return;
                    }
                    if (!$value['preco_compra']) {
                        $fail('É obrigatório a indicação do campo preço de compra');
                        return;
                    }

                    if (!$value['lucroUnitario'] && $value['lucroUnitario'] != 0) {
                        $fail('É obrigatório a indicação do campo lucro unitario');
                        return;
                    }
                    if (!$value['total_venda']) {
                        $fail('É obrigatório a indicação do campo total venda');
                        return;
                    }
                    if (!$value['total_compra']) {
                        $fail('É obrigatório a indicação do campo total compra');
                        return;
                    }
                }
            }]
        ], $message);


        $VENDA_CREDITO = 2;

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->messages());
        // }
        //$empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }

        
        $formaPagamentoId = $request->forma_pagamento_id;

        // $this->verificarFacturaCredito($formaPagamentoId);

        if ($VENDA_CREDITO == $formaPagamentoId) {
            $statusPagamento = 2; //Divida
        } else {
            $statusPagamento = 1; //Pago
        }

        $data_factura_fornecedor = date("Y-m-d", strtotime($request->get('data_factura_fornecedor')));

        $entradaStock = new EntradaStock();
        $entradaStock->data_factura_fornecedor = $data_factura_fornecedor;
        $entradaStock->fornecedor_id = $request->fornecedor_id;
        $entradaStock->empresa_id = $empresa_id;
        $entradaStock->forma_pagamento_id = $formaPagamentoId;
        $entradaStock->tipo_user_id = 2;
        $entradaStock->num_factura_fornecedor = $request->num_factura_fornecedor;
        $entradaStock->descricao = "Entrada da factura " . $request->num_factura_fornecedor;
        $entradaStock->total_compras = $request->total_compras;
        $entradaStock->total_venda = $request->total_venda;
        $entradaStock->total_iva = $request->totalIva;
        $entradaStock->total_desconto = $request->totalDesconto;
        $entradaStock->total_retencao = $request->totalRetencao;
        $entradaStock->user_id = auth('EmpresaApi')->user()->id;
        $entradaStock->operador = auth('EmpresaApi')->user()->name;
        $entradaStock->canal_id = $PORTAL_CLIENTE;
        $entradaStock->status_id = $STATUS_ATIVO;
        $entradaStock->statusPagamento = $statusPagamento;
        $entradaStock->armazem_id = $request->armazem_id;
        $entradaStock->totalLucro = $request->totalLucro;
        $entradaStock->save();

        if ($entradaStock) {
            foreach ($request->produtos as $key => $produto) {

                $entradaStockItems = new EntradaStockItems();
                $entradaStockItems->entrada_stock_id = $entradaStock->id;
                $entradaStockItems->produto_id = $produto['produto_id'];
                $entradaStockItems->preco_compra = $produto['preco_compra'];
                $entradaStockItems->preco_venda = $produto['preco_venda'];
                $entradaStockItems->quantidade = $produto['quantidade'];
                $entradaStockItems->lucroUnitario = $produto['lucroUnitario'];
                $entradaStockItems->save();

                ExistenciaStock::where('armazem_id', $request->armazem_id)
                    ->where('empresa_id', $empresa_id)
                    ->where('produto_id', $produto['produto_id'])->increment('quantidade', $produto['quantidade']);
            }

            $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);

            $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

            $reportController = new ReportsController();
            return $reportController->show(
                [
                    'report_file' => 'entradaProdutos',
                    'report_jrxml' => 'entradaProdutos.jrxml',
                    'report_parameters' => [
                        'empresa_id' => $empresa_id,
                        'diretorio' => $caminho,
                        'entradaId' => $entradaStock->id
                    ]

                ]
            );
        }
    }
}
