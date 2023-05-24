<?php

namespace App\Repositories\Empresa;

use App\Http\Resources\ProdutoResource;
use App\Models\empresa\Produto;
use App\Models\empresa\ProdutoFavorito;
use Illuminate\Support\Facades\DB;

class ProdutoFavoritoRepository
{

    public $entity;
    public function __construct(ProdutoFavorito $entity)
    {
        $this->entity = $entity;
    }
    public function mv_listarProdutosFavoritos($search)
    {
        $idsProdutoFavorito =  ProdutoFavorito::where('user_id', auth()->user()->id)
            ->pluck('produto_id')->toArray();
        $produtos = Produto::with(['produtoImagens', 'categoria', 'status', 'empresa'])->whereIn('id', $idsProdutoFavorito)->get();
        foreach ($produtos as $key => $produto) {
            $produtos[$key]['classificacao'] = [
                [
                    'classificacao' => 1,
                    'users' => $this->countUsers(1, $produto['id']),
                    'percentagem' => $this->calcularPercentagem(1, $produto['id'])
                ], [
                    'classificacao' => 2,
                    'users' => $this->countUsers(2, $produto['id']),
                    'percentagem' => $this->calcularPercentagem(2, $produto['id'])

                ],
                [
                    'classificacao' => 3,
                    'users' => $this->countUsers(3, $produto['id']),
                    'percentagem' => $this->calcularPercentagem(3, $produto['id'])

                ],
                [
                    'classificacao' => 4,
                    'users' => $this->countUsers(4, $produto['id']),
                    'percentagem' => $this->calcularPercentagem(4, $produto['id'])

                ],
                [
                    'classificacao' => 5,
                    'users' => $this->countUsers(5, $produto['id']),
                    'percentagem' => $this->calcularPercentagem(5, $produto['id'])

                ]
            ];
            $produtos[$key]['totalClassificacao'] = 0;
            $subClassificado = 0;
            $users = 0;
            foreach ($produtos[$key]['classificacao'] as $subtotal) {
                $subClassificado += $subtotal['classificacao'] * $subtotal['users'];
                $users += $subtotal['users'];
            }
            if ($subClassificado == 0 || $users == 0) {
                $produtos[$key]['totalClassificacao'] = 0;
            } else {
                $produtos[$key]['totalClassificacao'] = $subClassificado / $users;
            }
        }

        $favoritos = [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'foto' => auth()->user()->foto,
            'produtos' => $produtos

        ];
        return $favoritos;
    }
    public function totalUsers($produtoId)
    {
        return DB::connection('mysql2')->table('classificacao')
            ->where('produto_id', $produtoId)
            ->count();
    }
    public function calcularPercentagem($classificacao, $produtoId)
    {
        $totalUsers = $this->totalUsers($produtoId);
        if ($totalUsers <= 0) return 0;
        return (($classificacao * $this->countUsers($classificacao, $produtoId)) / $totalUsers) / 5;
    }
    public function countUsers($classificacao, $produtoId)
    {
        return DB::connection('mysql2')->table('classificacao')
            ->where('produto_id', $produtoId)
            ->where('num_classificacao', $classificacao)
            ->count();
    }
    public function checkFavorito($produtoId)
    {
        $produtoFavorito = ProdutoFavorito::where('user_id', auth()->user()->id)
            ->where('produto_id', $produtoId)
            ->first();
        if ($produtoFavorito) {
            ProdutoFavorito::where('user_id', auth()->user()->id)
                ->where('produto_id', $produtoId)
                ->delete();
            return response()->json([
                'data' => false,
                'message' => "Produto removido no favorito"
            ]);
        }
        ProdutoFavorito::create(['produto_id' => $produtoId, 'user_id' => auth()->user()->id]);
        return response()->json([
            'data' => true,
            'message' => "Produto adicionado no favorito"
        ]);
    }
    public function isProdutoFavorito($produtoId)
    {

        $produtoFavorito = ProdutoFavorito::where('user_id', auth()->user()->id)
            ->where('produto_id', $produtoId)
            ->first();

        if ($produtoFavorito) {
            return response()->json([
                'data' => true,
                'message' => "Produto está no favoritos"
            ]);
        }
        return response()->json([
            'data' => false,
            'message' => "Produto não está no favoritos"
        ]);
    }
}
