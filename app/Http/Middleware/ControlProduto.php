<?php

namespace App\Http\Middleware;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Produto;
use App\Repositories\Empresa\ProdutoRepository;
use Carbon\Carbon;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Session;

class ControlProduto
{
    private $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {

        $this->produtoRepository = $produtoRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = auth()->user()->id;
        $data = Carbon::now()->format('d-m-y');


        $existenciaStock = $this->produtoRepository->listarProdutoComQuantidadeCritica();

        if(count($existenciaStock) <= 0){
            return $next($request);
        }else if (($request->session()->get('user') == $user) && ($request->session()->get('data') == $data)) {
            return $next($request);
        } else {
            $request->session()->put('user', $user);
            $request->session()->put('data', $data);
            return response()->view("empresa.produtos.listarProdutoQuantidadeCritica", ['existenciaStock' => $existenciaStock]);
        }
    }
}
