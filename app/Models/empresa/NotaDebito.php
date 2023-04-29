<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class NotaDebito extends Model
{
    protected $table = 'notas_debito_clientes';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function empresa(){

        return $this->belongsTo(Empresa_cliente::class, 'empresa_id');

    }
    public function tipoUser()
    {
        return $this->belongsTo(TipoUser::class, 'tipo_user_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome_do_cliente", "like", $term)
            ->orwhere("numeracaoNotaDebito", "like", $term)
            ->orwhere("nif_cliente", "like", $term);
        });
    }

}
