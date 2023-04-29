<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\Banco;
use App\Models\empresa\Cliente;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Fabricante;
use App\Models\empresa\Factura;
use App\Models\empresa\Fornecedor;
use App\Models\empresa\Gestor_Clientes;
use App\Models\empresa\Produto;
use Illuminate\Http\Request;
use App\Models\empresa\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role as ModelsRole;

use App\Traits\VerificaSeUsuarioAlterouSenha;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;


class AuthController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
        //$this->middleware('auth:empresa');
    }

    public function index()
    {
        

        $TIPO_FUNCIONARIO = 3;
        $TIPO_ADMIN = 2;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($this->verificarSeAlterouSenha() || $infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        if ($empresa['tipo_user_id'] === $TIPO_FUNCIONARIO) {
            $data['router'] = "/empresa/funcionario";
        } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
            $data['router'] = "/empresa";
        }
        $data['guard'] = $empresa['guard'];

        $data['Users'] = User::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Clientes'] = Cliente::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Lojas'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Fornecedores'] = Fornecedor::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Fabricantes'] = Fabricante::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Bancos'] = Banco::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Gestores'] = Gestor_Clientes::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Produtos'] = Produto::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Produto_Stock'] = ExistenciaStock::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['Vendas'] = Factura::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['auth'] = Auth::user();


        // if (auth()->user()->status_senha_id == 1) {
        //     auth()->user()->removeRole('Funcionario');
        // }
        // $data['router'] = "/empresa/funcionario";

        return view('empresa.dashboard', $data);
    }

    public function perfil()
    {

        
        // if (Auth::guard('empresa')->user()) {
        //     $data['user'] = User::findOrfail(Auth::user()->id);
        //     $data['roles'] = ModelsRole::with('permissions')->get();
        //     $data['permissions'] = ModelsPermission::with('roles')->get();

        //     $role = $data['user']->roles->first();
        //     $permission = $data['user']->permissions->first();
        //     $permission_id = $permission ? $permission->id : 1;
        //     $role_id = $role ? $role->id : 1;
        //     $data['permission'] = ModelsPermission::findOrfail($permission_id);
        //     $data['funcao'] = ModelsRole::findOrfail($role_id);

        //     return view('empresa.funcionario.usuarios.perfil', $data);
        // }
    }

    public function infoDashboard()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $data['Users'] = User::where('empresa_id', $empresa_id)->get();
        $data['Clientes'] = Cliente::where('empresa_id', $empresa_id)->get();
        $data['Lojas'] = Armazen::where('empresa_id', $empresa_id)->get();
        $data['Fornecedores'] = Fornecedor::where('empresa_id', $empresa_id)->get();
        $data['Fabricantes'] = Fabricante::where('empresa_id', $empresa_id)->get();
        $data['Bancos'] = Banco::where('empresa_id', $empresa_id)->get();
        $data['Gestores'] = Gestor_Clientes::where('empresa_id', $empresa_id)->get();
        $data['Produtos'] = Produto::where('empresa_id', $empresa_id)->get();
        $data['Produto_Stock'] = ExistenciaStock::where('empresa_id', $empresa_id)->get();
        $data['Vendas'] = Factura::where('empresa_id', $empresa_id)->get();

        return response()->json($data);
    }
}
