<?php

namespace App\Models\admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\admin\Permission;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResetPassword;


class User extends Authenticatable
{
    use Notifiable, HasRoles; //HasApiTokens;


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $connection = 'mysql';
    protected $table = 'users_admin';
    protected $guard_name = 'web';
    protected $appends = ['all_permissions', 'can'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'telefone', 'email', 'empresa_id', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'canal_id', 'tipo_user_id', 'status_id', 'username', 'foto',
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


    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }

    public function getCanAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {

            if (Auth::user())
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("name", "like", $term)
                ->orwhere("email", "like", $term)
                ->orwhere("username", "like", $term)
                ->orwhere("telefone", "like", $term);
        });
    }
}
