<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class ExistenciaStock extends Model
{
    protected $table = 'existencias_stocks';
    protected $connection = 'mysql2';

    protected $fillable = [
        'produto_id',
        'armazem_id',
        'tipo_stocagem_id',
        'quantidade',
        'canal_id',
        'user_id',
        'status_id',
        'empresa_id',
        'observacao',
    ];

    public function produtos()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    public function armazens()
    {
        return $this->belongsTo(Armazen::class, 'armazem_id');
    }
    public function status()
    {

        return $this->belongsTo(Statu::class, 'status_id');
    }
}
