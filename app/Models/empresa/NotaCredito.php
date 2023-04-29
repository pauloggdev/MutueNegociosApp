<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class NotaCredito extends Model
{
    protected $table = 'notas_credito';
    protected $connection = 'mysql2';



    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento');
    }
    public function notaCreditoItems()
    {
        return $this->hasMany(NotaCreditoItems::class, 'codigoNotaCredito');
    }


    public function empresa()
    {

        return $this->belongsTo(Empresa_cliente::class, 'empresa_id');
    }
    public function tipoUser()
    {
        return $this->belongsTo(TipoUser::class, 'tipo_user_id');
    }
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'facturaId');
    }
    public function recibo()
    {
        return $this->belongsTo(Recibos::class, 'reciboId');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("nome_do_cliente", "like", $term)
                ->orwhere("numeracaoDocumento", "like", $term)
                ->orwhere("nif_cliente", "like", $term)
                ->orwhereHas('recibo', function ($q) use ($term) {
                    $q->where('numeracao_recibo', "like", $term);
                })->orwhereHas('factura', function ($query) use ($term) {
                    $query->where('numeracaoFactura', "like", $term);
                });
        });
    }
}
