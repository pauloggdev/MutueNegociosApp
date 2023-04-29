<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;

class LicencaEmpresa extends Model
{
    protected $connection = 'mysql';
    protected $table ='licenca_empresa';


    public function licenca(){
        return $this->belongsTo(Licenca::class, 'licenca_id');
    }
}