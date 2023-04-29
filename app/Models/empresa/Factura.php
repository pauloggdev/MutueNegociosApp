<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class Factura extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'facturas';
    protected $primarykey = 'id';
    protected $guard = 'id';
    
    const FACTURARECIBO = 1;
    const FACTURA = 2;
    const FACTURAPROFORMA = 3;

    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->faturaReference = mb_strtoupper(Keygen::numeric(9)->generate());
            $model->nextFactura = $model->faturaReference;
        });
    }

    public function status()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function facturas_items()
    {
        return $this->hasMany(FacturaItems::class, 'factura_id', 'id');
    }
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamentoGeral::class, 'formas_pagamento_id');
    }
    
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento');
    }
    public function empresa()
    {
        return $this->hasOne(Empresa_Cliente::class, 'id', 'empresa_id');
    }
    public function tipoUser()
    {
        return $this->belongsTo(TipoUser::class, 'tipo_user_id');
    }
    public function armazem()
    {
        return $this->belongsTo(Armazen::class, 'armazen_id');
    }
    public function canal()
    {
        return $this->belongsTo(CanalComunicacao::class, 'canal_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome_do_cliente", "like", $term)
            ->orwhere("telefone_cliente", "like", $term)
            ->orwhere("nif_cliente", "like", $term)
            ->orwhere("email_cliente", "like", $term)
            ->orwhere("conta_corrente_cliente", "like", $term)
            ->orwhere("numeracaoFactura", "like", $term);
        });
    }
    
}
