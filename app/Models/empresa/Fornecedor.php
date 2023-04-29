<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'fornecedores';
    protected $fillable = [
        'nome', 'telefone_empresa', 'email_empresa', 'nif', 'endereco', 'website', 'pessoal_contacto','status_id','user_id','tipo_user_id',
        'telefone_contacto', 'email_contacto', 'conta_corrente', 'data_contracto', 'pais_nacionalidade_id', 'nif', 'created_at','canal_id','empresa_id',
        'updated_at',
    ];

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function statuLicenca()
    {
        return $this->belongsTo(CanalComunicacao::class,'canal_id');
    }
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_nacionalidade_id');
    }

    
}
