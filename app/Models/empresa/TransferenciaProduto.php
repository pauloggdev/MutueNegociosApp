<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class TransferenciaProduto extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'transferencias_produtos';


    public function transferenciaProdutoItems()
    {
        return $this->hasMany(TransferenciaProdutoItems::class, 'transferencia_produto_id', 'id');
    }
    
}
