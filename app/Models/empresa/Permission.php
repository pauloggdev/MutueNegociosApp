<?php

namespace App\Models\empresa;

use App\Models\empresa\Role;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'permissions';


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("name", "like", $term);
        });
    }
}
