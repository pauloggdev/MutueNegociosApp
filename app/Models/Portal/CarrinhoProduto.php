<?php

namespace App\Models\Portal;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    // use HasFactory;
    // protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
}
