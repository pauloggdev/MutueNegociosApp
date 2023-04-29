<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class FormaPagamentos extends Model
{
    protected $connection = 'mysql2';
    protected $table ='formas_pagamentos';
    protected $primarykey = 'id';
    protected $guard = 'id';

    protected $fillable = [
        'tipo_pagamento_id', 'designacao', 'descricao_tipo_pagamento', 'sigla_tipo_pagamento','codigo_contabilidade','conta_corrente','empresa_id',
        'status_id', 'canal_id', 'user_id', 'created_at', 'updated_at'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
}
