<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    protected $connection = 'mysql2';
    protected $table ='classificacao';
    protected $primarykey = 'id';
    protected $guard = 'id';
    protected $fillable = ['produto_id','user_id','num_classificacao', 'comentario'];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
