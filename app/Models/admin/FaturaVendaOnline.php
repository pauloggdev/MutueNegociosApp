<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class FaturaVendaOnline extends Model
{
    protected $connection = 'mysql';
    protected $table ='facturas_vendas_online';

    protected  $fillable = [
        'total_fatura',
        'valor_a_pagar',
        'total_incidencia',
        'retencao',
        'total_iva',
        'desconto',
        'troco',
        'valor_extenso',
        'texto_hash',
        'hashValor',
        'numeroItems',
        'fatura_referencia',
        'numSequencia',
        'numeracaoFatura',
        'observacao',
        'nome_do_cliente',
        'nif_cliente',
        'email_cliente',
        'telefone_cliente',
        'endereco_cliente',
        'conta_corrente_cliente',
        'empresa_id'
    ];
}
