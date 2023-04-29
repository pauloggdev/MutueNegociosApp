<?php

namespace App\Http\Controllers\empresa\Produtos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Keygen\Keygen;
use Illuminate\Support\Str;


class ProdutoStoreController extends Controller
{
    public function store(Request $request)
    {

        $message = [
            'designacao.required' => 'É obrigatório o nome',
            'categoria_id.required' => 'É obrigatório a categoria',
            'fabricante_id.required' => 'É obrigatório o fabricante',
            'preco_venda.required' => 'É obrigatório o preço de venda',
            'status_id.required' => 'É obrigatório o status',

        ];

        $this->validate($request, [
            'designacao' => ['required'],
            'categoria_id' => ['required'],
            'preco_venda' => ['required', function ($atr, $precoVenda, $fail) {
                if ($precoVenda < 0) {
                    $fail('O preço de venda não pode ser negativo');
                }
            }],
            'status_id' => ['required'],
            'codigo_taxa' => ['required'],
            'fabricante_id' => ['required'],
            'imagem_produto' => 'image|max:1024'
        ], $message);

        try {

            DB::beginTransaction();
            $produtId = DB::table('produtos')->insertGetId([
                'uuid' => Str::uuid(),
                'designacao' => $request->designacao,
                'preco_venda' => str_replace(",",".",$request->preco_venda),
                'preco_compra' => str_replace(",",".",$request->preco_compra),
                'categoria_id' => $request->categoria_id,
                'unidade_medida_id' => $request->unidade_medida_id,
                'fabricante_id' => $request->fabricante_id,
                'user_id' => auth()->user()->id,
                'canal_id' => $request->canal_id,
                'status_id' => $request->status_id,
                'codigo_taxa' => $request->codigo_taxa,
                'motivo_isencao_id' => $request->motivo_isencao_id ?? 8, //Transmissão de bens e serviço não sujeita
                'quantidade_minima' => $request->quantidade_minima ?? 0,
                'quantidade_critica' => $request->quantidade_critica ?? 0,
                'imagem_produto' => $request->imagem_produto ? $request->imagem_produto->store("/produtos") : NULL,
                'referencia' => Keygen::numeric(9)->generate(),
                'stocavel' => $request->stocavel,
                'empresa_id' => auth()->user()->empresa_id
            ]);

            DB::table('existencias_stocks')->insertGetId([
                'produto_id' => $produtId,
                'armazem_id' => $request->armazem_id,
                'quantidade' => $request->quantidade ?? 0,
                'user_id' => $request->user_id,
                'canal_id' => $request->canal_id,
                'status_id' => $request->status_id,
                'empresa_id' => auth()->user()->empresa_id,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ]);

            DB::table('actualizacao_stocks')->insert([
                'produto_id' => $produtId,
                'empresa_id' => auth()->user()->empresa_id,
                'quantidade_antes' => 0,
                'quantidade_nova' => $request->quantidade ?? 0,
                'user_id' => $request->user_id,
                'tipo_user_id' => 2, //empresa
                'canal_id' => $request->canal_id,
                'status_id' => $request->status_id,
                'armazem_id' => $request->armazem_id,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ]);
            DB::commit();
            return redirect()->route('produto.create')->withSuccess('Operação efectuada com Sucesso!');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->route('produto.create')->withErrors('Erro ao cadastrar centro de custo!');
        }
    }
}
