<?php
namespace App\Repositories\Empresa;

use Carbon\Carbon;

trait TraitUltimaNotaCredito
{


    private function pegarUltimoNotaCredito()
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');
        $notaCredito = $this->notaCredito::where('empresa_id', auth()->user()->empresa_id)
        ->where(function($query){
            $query->where('tipoNotaCredito', 2)//anulação
            ->orwhere('tipoNotaCredito', 3);//retificacao
        }) 
        ->where('numeracaoDocumento', 'like', '%' . $this->mostrarSerieDocumento() . '%')
        ->where('created_at', 'like', '%' . $yearNow . '%')
        ->orderBy('id', 'DESC')->limit(1)->first();

        return $notaCredito;
    }
    
}
