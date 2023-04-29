<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;


trait VerificaSeUsuarioAlterouSenha
{

    private $SENHA_VULNERAVEL = 1;

    public function verificarSeAlterouSenha()
    {
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()['status_senha_id'] == $this->SENHA_VULNERAVEL) {
                return true;
            }
        } else {
            if (Auth::guard('empresa')->user()['status_senha_id'] == $this->SENHA_VULNERAVEL) {
                return true;
            }
        }
        return false;
    }
}
