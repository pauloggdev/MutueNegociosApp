<?php

namespace App\Models\empresa;

use App\Models\empresa\ExistenciaStock;
use Illuminate\Database\Eloquent\Model;

class ProdutoLoja extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'produtos_lojas';


    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function produtos(){

        return $this->belongsTo(Produto::class, 'produto_id');

    }

    // public function produtos()
    // {
    //     return $this->morphTo(Produto::class,'produto_id', 'produtotable');
    // }
}
