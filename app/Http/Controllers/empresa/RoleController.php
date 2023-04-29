<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa\PermissionRole;
use App\Models\empresa\Role;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;

class RoleController extends Controller
{
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

       $data['roles']= Role::where('empresa_id', null)
        ->orwhere('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.permissoes.funcaoIndex', $data);

    }
    public function listarPermissoes($roleId){

        $permissionRole = Role::with(['permissions'])->find($roleId);
        return response()->json($permissionRole, 200);
    }
}
