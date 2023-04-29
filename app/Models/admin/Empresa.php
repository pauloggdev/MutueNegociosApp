<?php

namespace App\Models\admin;

use App\Admin\LicencaEmpresa;
use App\Models\admin\LicencaEmpresa as AdminLicencaEmpresa;
use Illuminate\Database\Eloquent\Model;
use App\Models\empresa\TiposCliente;
use App\Models\admin\StatuGerais;
use App\Models\admin\TiposRegime;
use Illuminate\Notifications\Notifiable;
use Keygen\Keygen;

class Empresa extends Model
{

    use Notifiable;
    
    protected $connection = 'mysql';
    protected $table ='empresas';
    
    protected $fillable = [
        'nome', 'pessoal_Contacto', 'endereco', 'email',
        'website', 'saldo', 'gestor_id', 'canal_id', 'status_id', 'nif','cidade',
        'created_at', 'updated_at', 'tipo_cliente_id', 'tipo_regime_id', 'logotipo', 'gestor_cliente_id', 'user_id', 'empresa_id', 'pais_id', 'user_id', 'referencia','pessoa_de_contacto'
    ];
    
    public static function boot(){
        
        parent::boot();
        
        self::creating(function($model){
            $model->referencia = mb_strtoupper(Keygen::alphanum(7)->generate());
        });
    }
    
    public function users(){
       return $this->hasMany('\App\Models\empresa\User', 'empresa_id');
    }
    
    public function tipocliente()
    {
        return $this->belongsTo(TiposCliente::class, 'tipo_cliente_id');
    }

    public function tiporegime()
    {
        return $this->belongsTo('\App\Models\admin\TiposRegime', 'tipo_regime_id');
    }
    
    public function statusgerais()
    {
        return $this->belongsTo(StatuGerais::class, 'status_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
    public function licencas(){
        return $this->hasMany(AdminLicencaEmpresa::class);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("nome", "like", $term)
                ->orwhere("nif", "like", $term)
                ->orwhere("referencia", "like", $term)
                ->orwhere("email", "like", $term);
        });
    }
}
