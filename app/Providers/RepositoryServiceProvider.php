<?php

namespace App\Providers;

use App\Repositories\contracts\IreportRepositoryInterface;
use App\Repositories\Empresa\ArmazenRepository;
use App\Repositories\Empresa\CategoriaRepository;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\contracts\ArmazenRepositoryInterface;
use App\Repositories\Empresa\contracts\CategoriaRepositoryInterface;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\FabricanteRepositoryInterface;
use App\Repositories\Empresa\contracts\FacturacaoRepositoryInterface;
use App\Repositories\Empresa\contracts\FornecedorRepositoryInterface;
use App\Repositories\Empresa\contracts\MarcaRepositoryInterface;
use App\Repositories\Empresa\contracts\PermissaoRepositoryInterface;
use App\Repositories\Empresa\contracts\ProdutoRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Repositories\Empresa\FabricanteRepository;
use App\Repositories\Empresa\FacturacaoRepository;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\IreportRepository;
use App\Repositories\Empresa\MarcaRepository;
use App\Repositories\Empresa\PermissaoRepository;
use App\Repositories\Empresa\ProdutoRepository;
use App\Repositories\Empresa\RelatorioRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(FornecedorRepositoryInterface::class,FornecedorRepository::class);
        $this->app->bind(FabricanteRepositoryInterface::class,FabricanteRepository::class);
        $this->app->bind(ArmazenRepositoryInterface::class,ArmazenRepository::class);
        $this->app->bind(ProdutoRepositoryInterface::class,ProdutoRepository::class);
        $this->app->bind(PermissaoRepositoryInterface::class,PermissaoRepository::class);

        $this->app->bind(MarcaRepositoryInterface::class,MarcaRepository::class);
        $this->app->bind(CategoriaRepositoryInterface::class,CategoriaRepository::class);
        $this->app->bind(RelatorioRepositoryInterface::class, RelatorioRepository::class);
        $this->app->bind(IreportRepositoryInterface::class, IreportRepository::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
