<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class TipoTaxa extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'tipotaxa';
    protected $primaryKey = 'codigo';


    public function motivo()
    {
        return $this->belongsTo(TipoMotivoIva::class, 'codigoMotivo');
    }
    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'codigostatus');
    }
}
