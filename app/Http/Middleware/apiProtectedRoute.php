<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try{

            $user = JWTAuth::parseToken()->authenticate();

        }catch(\Exception $e){

            if($e instanceof TokenInvalidException){
                return response()->json(['status' => 'Token inválido']);
            }else if($e instanceof TokenExpiredException){
                return response()->json(['status' => 'Token expirado']);
            }else{
                return response()->json(['status' => 'Token não encontrado']);
            }
        }
        return $next($request);
    }
}
