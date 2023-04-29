<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class TransferenciaProdutoItems extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'transferencias_produto_items';

    public function transferenciaProduto()
    {
        return $this->hasOne(TransferenciaProduto::class, 'id', 'transferencia_produto_id');
    }
}
