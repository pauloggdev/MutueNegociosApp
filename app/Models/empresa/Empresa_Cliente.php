<?php

namespace App\Models\empresa;

use App\Models\admin\TiposRegime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Keygen\Keygen;

class Empresa_Cliente extends Model
{

    use Notifiable;

    protected $connection = 'mysql2';
    protected $table ='empresas';

    protected $fillable = [
        'nome', 'pessoal_Contacto', 'endereco', 'email',
        'website', 'saldo', 'gestor_id', 'canal_id', 'status_id', 'nif','cidade',
        'created_at', 'updated_at', 'tipo_cliente_id', 'tipo_regime_id', 'logotipo', 'gestor_cliente_id', 'empresa_id', 'pais_id', 'referencia','pessoa_de_contacto'
    ];

    public function users(){
       return $this->hasMany('\App\Models\empresa\User', 'empresa_id');
    }

    public function tipocliente()
    {
        return $this->belongsTo(TiposCliente::class, 'tipo_cliente_id');
    }

    public function tiporegime()
    {
        return $this->belongsTo(TiposRegime::class, 'tipo_regime_id');
    }

    public function statusgerais()
    {
        return $this->belongsTo(StatuGerais::class, 'status_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

}
