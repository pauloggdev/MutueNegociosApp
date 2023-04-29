<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class AtualizacaoStocks extends Model
{
    protected $connection = 'mysql2';
    protected $table ='actualizacao_stocks';


    public function produtos(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
    public function armazens(){
        return $this->belongsTo(Armazen::class,'armazem_id');
    }
    public function status(){

        return $this->belongsTo(Statu::class,'status_id');


    }
}
