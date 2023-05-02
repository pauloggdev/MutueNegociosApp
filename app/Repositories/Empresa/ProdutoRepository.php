<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Produto;
use App\Repositories\Empresa\contracts\ProdutoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Keygen\Keygen;
use Illuminate\Support\Facades\Storage;



class ProdutoRepository implements ProdutoRepositoryInterface
{

    protected $entity;

    public function __construct(Produto $produto)
    {
        $this->entity = $produto;
    }
    public function listarSeisProdutosMaisVendidos()
    {

        return DB::select('
        select factura_items.descricao_produto,
        sum(factura_items.quantidade_produto) AS quantidade,
        SUM(factura_items.total_preco_produto) AS total_preco
               from facturas
               INNER JOIN factura_items ON facturas.id = factura_items.factura_id
               WHERE facturas.anulado=1 AND facturas.empresa_id = "' . auth()->user()->empresa_id . '"
               GROUP by factura_items.descricao_produto
               order by sum(factura_items.quantidade_produto) desc
               LIMIT 6');
    }
    public function quantidadeProdutos()
    {
        return $this->entity::where('empresa_id', auth()->user()->empresa_id)->count();
    }
    public function getProdutoComPaginacao($search)
    {
        return $this->entity::with(['existenciaEstock', 'existenciaEstock.armazens', 'tipoTaxa'])
            ->where('venda_online', 'Y')
            ->search(trim($search))->paginate();
    }
    public function mv_listarProdutos($search)
    {
        $produtos = $this->entity::with(['produtoImagens', 'categoria', 'status', 'classificacao'])
            ->where('venda_online', 'Y')
            ->search(trim($search))
            ->paginate();

        return $produtos;
    }
    public function getProdutosSemPaginacao($armazemId)
    {
        $produtos = $this->entity::with(['tipoTaxa', 'statuGeral', 'motivoIsencao'])
            ->whereHas('existenciaEstock', function ($query) use ($armazemId) {
                $query->where('armazem_id', $armazemId);
            })
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('stocavel', 'Sim')
            ->get();
        return $produtos;
    }

    public function getProdutos($search = null, $vendaOnline = 'N')
    {
        $produtos = $this->entity::with(['tipoTaxa', 'statuGeral', 'motivoIsencao'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->vendaOnline($vendaOnline)
            ->paginate();
        return $produtos;
    }
    public function getProdutoPaginate()
    {
        $produtos = $this->entity::with(['tipoTaxa', 'statuGeral', 'motivoIsencao'])
            ->where('empresa_id', auth()->user()->empresa_id)->paginate();
        return $produtos;
    }
    public function listarProdutosPeloIdArmazem($armazemId)
    {
        $produtos = $this->entity::with(['tipoTaxa', 'motivoIsencao'])
            ->whereHas("existenciaEstock", function ($q) use ($armazemId) {
                $q->where('armazem_id', $armazemId);
            })
            ->where('empresa_id', auth()->user()->empresa_id)->get();
        return $produtos;
    }

    public function getProduto(int $id)
    {
        $produto = $this->entity::with(['tipoTaxa', 'statuGeral', 'motivoIsencao'])->where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $produto;
    }
    public function store(Request $request)
    {
        // $message = [
        //     'designacao.required' => 'É obrigatório o nome',
        //     'categoria_id.required' => 'É obrigatório a categoria',
        //     'fabricante_id.required' => 'É obrigatório o fabricante',
        //     'preco_venda.required' => 'É obrigatório o preço de venda',
        //     'status_id.required' => 'É obrigatório o status',
        //     'stocavel.required' => 'É obrigatório o estocavel',
        //     'unidade_medida_id.required' => 'É obrigatório a unidade',
        //     'armazem_id.required' => 'É obrigatório o armazém',
        //     'codigo_taxa.required' => 'É obrigatório a taxa',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'designacao' => ['required'],
        //     'categoria_id' => ['required'],
        //     'preco_venda' => ['required', function ($attr, $precoVenda, $fail) {
        //         if ($precoVenda < 0) {
        //             $fail('O preço de venda não pode ser negativo');
        //         }
        //     }],
        //     'status_id' => ['required'],
        //     'codigo_taxa' => ['required'],
        //     'stocavel' => ['required'],
        //     'unidade_medida_id' => ['required'],
        //     'fabricante_id' => ['required'],
        //     'armazem_id' => ['required'],
        //     'imagem_produto' => 'max:1024'
        // ], $message);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->messages(), 400);
        // }
        // try {

        //     DB::beginTransaction();
        $produtId = DB::table('produtos')->insertGetId([
            'uuid' => Str::uuid(),
            'designacao' => $request->designacao,
            'preco_venda' => $request->preco_venda ?? 0,
            'preco_compra' => $request->preco_compra ?? 0,
            'categoria_id' => $request->categoria_id,
            'unidade_medida_id' => $request->unidade_medida_id,
            'fabricante_id' => $request->fabricante_id,
            'user_id' => auth()->user()->id,
            'canal_id' => $request->canal_id ?? 2,
            'status_id' => $request->status_id ?? 1,
            'codigo_taxa' => auth()->user()->empresa->tipo_regime_id != 1 ? 1 : $request->codigo_taxa,
            'motivo_isencao_id' => $request->motivo_isencao_id ?? 8, //Transmissão de bens e serviço não sujeita
            'quantidade_minima' => $request->quantidade_minima ?? 0,
            'quantidade_critica' => $request->quantidade_critica ?? 0,
            'imagem_produto' => $request->imagem_produto ? $request->imagem_produto->store("/produtos") : NULL,
            'referencia' => Keygen::numeric(9)->generate(),
            'data_expiracao' => $request->data_expiracao ?? NULL,
            'descricao' => $request->descricao ?? NULL,
            'stocavel' => $request->stocavel,
            'empresa_id' => auth()->user()->empresa_id
        ]);

        DB::table('existencias_stocks')->insertGetId([
            'produto_id' => $produtId,
            'armazem_id' => $request->armazem_id,
            'quantidade' => isset($request->stocavel) && $request->stocavel == 'Sim' ? $request->quantidade ?? 0 : 0,
            'user_id' => $request->user_id,
            'canal_id' => $request->canal_id ?? 2,
            'status_id' => $request->status_id ?? 1,
            'empresa_id' => auth()->user()->empresa_id,
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);

        DB::table('actualizacao_stocks')->insert([
            'produto_id' => $produtId,
            'empresa_id' => auth()->user()->empresa_id,
            'quantidade_antes' => 0,
            'quantidade_nova' => isset($request->stocavel) && $request->stocavel == 'Sim' ? $request->quantidade ?? 0 : 0,
            'user_id' => auth()->user()->id,
            'tipo_user_id' => 2, //empresa
            'canal_id' => 4,
            'status_id' => $request->status_id ?? 1,
            'armazem_id' => $request->armazem_id,
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        DB::commit();
        //     return $produtId;
        // } catch (\Exception $th) {
        //     DB::rollBack();
        // }
    }

    public function update(Request $request, int $produtoId)
    {

        // dd($request->all());

        $produto = Produto::where('id', $produtoId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        $imagem = NULL;
        if ($request->hasFile('imagem_produto') && $request->imagem_produto->isValid()) {
            if (Storage::exists($produto->imagem_produto)) {
                Storage::delete($produto->imagem_produto);
            }
            $imagem = $request->imagem_produto->store("/produtos");
        }

        try {

            DB::beginTransaction();

            DB::table('produtos')->where('id', $produtoId)->update([
                'designacao' => $request->designacao,
                'preco_venda' => $request->preco_venda,
                'preco_compra' => $request->preco_compra ?? 0,
                'categoria_id' => $request->categoria_id,
                'unidade_medida_id' => $request->unidade_medida_id,
                'fabricante_id' => $request->fabricante_id,
                'status_id' => $request->status_id ?? 1,
                'codigo_taxa' => auth()->user()->empresa->tipo_regime_id != 1 ? 1 : $request->codigo_taxa,
                'motivo_isencao_id' => $request->codigo_taxa <= 0 ? 8 : $request->motivo_isencao_id, //Transmissão de bens e serviço não sujeita
                'quantidade_minima' => $request->quantidade_minima ?? 0,
                'quantidade_critica' => $request->quantidade_critica ?? 0,
                'imagem_produto' => $imagem ? $imagem : $request->imagem_produto,
                'stocavel' => $request->stocavel
            ]);

            if ($request->stocavel == 'Não') {
                DB::table('existencias_stocks')->where('produto_id', $produto->id)->update([
                    'quantidade' =>  0
                ]);
            }
            DB::commit();
            return $produtoId;
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }

    public  function listarProdutoComQuantidadeCritica()
    {
        $produtos = ExistenciaStock::with(['produtos'])
            ->whereHas('produtos', function ($q) {
                $q->where('produtos.quantidade_critica', '!=', 0)
                    ->where('produtos.empresa_id', auth()->user()->empresa_id)
                    ->where('produtos.quantidade_critica', '>=', 'existencias_stocks.quantidade');
            })

            ->get();
        return $produtos;
    }
}
