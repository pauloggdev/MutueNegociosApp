<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagamentoVendaOnlineDatabase extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table ='pagamentos_vendas_online';

    protected $fillable = [
        'comprovativoBancario',
        'dataPagamentoBanco',
        'formaPagamentoId',
        'iban'
    ];

}
