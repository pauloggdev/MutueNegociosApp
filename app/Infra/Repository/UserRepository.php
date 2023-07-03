<?php

namespace App\Infra\Repository;

use App\Models\admin\User as UserDatabase;

class UserRepository
{
    public function emaisUserParaNotificar(){
        return UserDatabase::where('notificarAtivacaoLicenca', 'Y')->pluck('email')->toArray();
    }

}
