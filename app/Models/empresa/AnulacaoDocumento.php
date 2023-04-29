<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class AnulacaoDocumento extends Model
{
    //

    protected $connection = 'mysql2';
    protected $table = 'documento_anulados';

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
    public function recibo()
    {
        return $this->belongsTo(Recibos::class, 'recibo_id');
    }
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento');
    }
    public function cliente(){

        return $this->belongsTo(Cliente::class, 'cliente_id');

    }
    public function empresa(){

        return $this->belongsTo(Empresa_cliente::class, 'empresa_id');

    }
}
