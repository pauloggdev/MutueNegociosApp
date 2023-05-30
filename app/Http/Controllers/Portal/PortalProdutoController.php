<?php

namespace App\Http\Controllers\Portal;
use App\Models\empresa\Produto;
// use App\Repositories\Empresa\contracts\ProdutoRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortalProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPodutoDetalhes($id)
    {
        $produtos = Produto::with('produtoImagens', 'categoria', 'status', 'classificacao','empresa')
        ->where('venda_online', 'Y')->where('uuid',$id)->first();
        return response()->json($produtos);
    }

    public function pesquisarProdutoById($key)
    {
        $produtos = Produto::with('produtoImagens', 'categoria', 'status', 'classificacao')
        ->where('venda_online', 'Y')->where('designacao','LIKE',"%{$key}%")->get();
        return response()->json($produtos);
    }
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
