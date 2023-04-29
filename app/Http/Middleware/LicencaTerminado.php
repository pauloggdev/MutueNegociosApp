<?php

namespace App\Http\Middleware;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use Closure;

class LicencaTerminado
{
    use TraitEmpresaAutenticada;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        if($infoNotificacao['diasRestantes'] <= 0 && $infoNotificacao['diasRestantes'] !== null){
            return redirect()->route('assinaturas.index');
        }
        return $next($request);
    }
}
