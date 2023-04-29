<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class FacturaOriginal extends Model
{
    protected $connection = 'mysql2';
    protected $table ='facturas_original';


    public function status(){
        return $this->belongsTo(Statu::class,'status_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function facturas_items(){
        return $this->hasMany(FacturaItemsOriginal::class,'factura_id', 'id');
    }
    public function formaPagamento(){
        return $this->belongsTo(FormaPagamentos::class,'formas_pagamento_id');
    }
    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento');
    }
    public function empresa(){
        return $this->hasOne(Empresa_Cliente::class,'id', 'empresa_id');
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
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
