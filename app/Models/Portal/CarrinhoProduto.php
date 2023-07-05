<?php

namespace App\Models\Portal;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\empresa\Produto;
use App\Models\empresa\User;
use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    // use HasFactory;
    // protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
}
