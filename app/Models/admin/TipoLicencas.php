<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class TipoLicencas extends Model
{
    protected $table ='tipos_licencas';
    protected $connection = 'mysql';


    public function Licencas(){
        return $this->hasMany(Licenca::class);
    }
}
