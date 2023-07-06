<?php

namespace App\Repositories\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait TraitSerieDocumento
{
    public function mostrarSerieDocumento()
    {

        $empresaId = auth()->user()?auth()->user()->empresa_id:158;
        $documentoSerie = DB::connection('mysql2')->table('series_documento')
            ->where('empresa_id',$empresaId )->first();

        if ($documentoSerie) {
            return mb_strtoupper(substr(Str::slug($documentoSerie->serie), 0, 3));
        }
        return mb_strtoupper(substr(Str::slug(auth()->user()->empresa->nome), 0, 3));
    }
}
