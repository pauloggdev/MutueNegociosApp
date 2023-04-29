<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class PagamentoFornecedor extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'pagamento_fornecedor';
    //
    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function entradaProduto()
    {
        return $this->belongsTo(EntradaStock::class);
    }
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

   
}
