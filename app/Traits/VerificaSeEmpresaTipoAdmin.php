<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;


trait VerificaSeEmpresaTipoAdmin{

    private $ADMIN_RAMOS_SOFT = 1;
    
    public function isAdmin(){
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == $this->ADMIN_RAMOS_SOFT) {
                return true;
            }
        }
    }
}