<?php

namespace App\Providers;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{

    use TraitEmpresaAutenticada;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //compose all the views....

        view()->composer('*', function ($view) {
            if(Auth::check() && auth()->user()->guard != 'web'){
                $infoNotificacao = $this->alertarActivacaoLicenca();
                View::share('alertaAtivacaoLicenca',$infoNotificacao);
            }

        });



        if ($this->app['request']->server->get('HTTP_HOST') == "127.0.0.1") {
            config(['app.url' => "http://127.0.0.1"]);
        } else {
            config(['app.url' => "http://" . $this->app['request']->server->get('HTTP_HOST')]);
        }
    }
}
