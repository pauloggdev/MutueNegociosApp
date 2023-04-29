<?php

namespace App\Models\admin;
use App\Models\admin\TipoLicencas;
use App\Models\admin\LicencaEmpresa as AdminLicencaEmpresa;


use Illuminate\Database\Eloquent\Model;

class Licenca extends Model
{
    protected $connection = 'mysql';
    protected $table ='licencas';

    const GRATIS = 1;
    const MENSAL = 2;
    const ANUAL = 3;
    const DEFINITIVO = 4;


    public function tipoLicenca(){
        return $this->belongsTo(TipoLicencas::class,'tipo_licenca_id');
    }
    public function statuGeral(){
        return $this->belongsTo(StatuGerais::class,'status_licenca_id');
    }
    public function empresaLicenca(){
        return $this->hasMany(AdminLicencaEmpresa::class,'licenca_id');

    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }

}