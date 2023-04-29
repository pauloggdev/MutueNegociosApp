<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa\Permission;
use App\Models\empresa\PermissionRole;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function index(){

        
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($this->verificarSeAlterouSenha() || $infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

       $data['permissions']= Permission::all();
       return view('empresa.permissoes.permissaoIndex', $data);

    }

    public function listarRole($permissionId){

        $roles = Permission::with(['roles'])->find($permissionId);
        return response()->json($roles, 200);

    }
}
