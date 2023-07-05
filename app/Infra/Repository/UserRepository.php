<?php

namespace App\Infra\Repository;

use App\Models\admin\User as UserAdminDatabase;
use App\Models\empresa\User as UserEmpresaDatabase;

class UserRepository
{
    public function emaisUserParaNotificar(){
        return UserAdminDatabase::where('notificarAtivacaoLicenca', 'Y')->pluck('email')->toArray();
    }
    public function getUser($uuid){
        return UserEmpresaDatabase::with(['cliente'])->where('uuid', $uuid)->first();
    }

}
