<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;


class TipoMotivoIva extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'motivo';
    protected $primaryKey = 'codigo';

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
}