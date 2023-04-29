<?php

namespace App\Models\empresa;

use App\Models\empresa\Empresa_Cliente;

use \App\Models\empresa\CanalComunicacao;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'clientes';


    protected $fillable = [
        'uuid',
        'nome',
        'pessoa_contacto',
        'email',
        'website',
        'numero_contrato',
        'data_contrato',
        'tipo_conta_corrente',
        'conta_corrente',
        'telefone_cliente',
        'tipo_cliente_id',
        'taxa_de_desconto',
        'limite_de_credito',
        'endereco',
        'gestor_id',
        'canal_id',
        'status_id',
        'nif',
        'operador',
        'user_id',
        'pais_id',
        'diversos',
        'cidade',
        'created_at',
        'updated_at',
        'empresa_id',
    ];

    public function tipocliente()
    {
        return $this->belongsTo(TiposCliente::class, 'tipo_cliente_id');
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa_cliente::class, 'empresa_id');
    }
    public function gestor()
    {

        return $this->belongsTo(Gestor_Clientes::class, 'gestor_id');
    }
    public function facturas()
    {

        return $this->hasMany(Factura::class, 'cliente_id', 'id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome", "like", $term)
                ->orwhere("nif", "like", $term)
                ->orwhere("conta_corrente", "like", $term)
                ->orwhere("telefone_cliente", "like", $term);
        });
    }
}
