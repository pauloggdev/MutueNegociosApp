<?php

namespace App\Models\empresa;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\empresa\Permission;
use App\Models\Traits\UserACLTrait;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResetPassword;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use Notifiable,HasRoles,HasApiTokens;
    use UserACLTrait;


    /**
     * The accessors to append to the model's array form
     * @var array
     */
    protected $connection = 'mysql2';
    protected $table = 'users_cliente';
    protected $guard_name = 'empresa';
    protected $appends = ['all_permissions','can'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'uuid',
        'statusUserAdicional',
        'name',
        'telefone',
        'email',
        'empresa_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'canal_id',
        'tipo_user_id',
        'status_id',
        'username',
        'foto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function user()
    {
        return $this->hasMany('\App\Models\empresa\Empresa_Cliente', 'referencia');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("name", "like", $term)
            ->orwhere('username', "like", $term)
            ->orwhere('email', "like", $term);
        });
    }

    public function getAllPermissionsAttribute()
    {


        return $this->getAllPermissions();
    }

    public function getCanAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {

            if(Auth::user())
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        return $permissions;
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function perfis()
    {
        return $this->belongsToMany(Role::class, UserPerfil::class, 'user_id', 'perfil_id');

    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }



    /**
     * API
     */

    // /**
    //  * Get the identifier that will be stored in the subject claim of the JWT.
    //  *
    //  * @return mixed
    //  */
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // /**
    //  * Return a key value array, containing any custom claims to be added to the JWT.
    //  *
    //  * @return array
    //  */
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
}
