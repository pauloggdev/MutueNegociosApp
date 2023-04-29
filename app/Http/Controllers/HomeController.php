<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Admin\User;
use Carbon\Carbon;
use App\Models\admin\Empresa;
use App\Jobs\JobMailPrazoLicencaEmpresa;
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
use App\Models\empresa\User as EmpresaUser;
use Facade\FlareClient\Http\Response;
use App\Traits\Empresa\TraitEmpresaAutenticada;

use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\VerificaSeEmpresaTipoAdmin;


date_default_timezone_set('Africa/Luanda');

class HomeController extends Controller
{

    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
         $this->middleware('auth');
    }

    public function indexAdmin1111()
    {

        $data['auth'] = Auth::user();
        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            $data['countusers'] = DB::connection('mysql')->table('users_admin')->where('tipo_user_id', 1)->count();
            $data['countclientes'] = DB::connection('mysql')->table('empresas')->where('id', '!=', 1)->count();
            $data['countlicencas'] = DB::connection('mysql')->table('licencas')->count();
            $data['countlicencasativas'] = DB::connection('mysql')->table('activacao_licencas')->where('status_licenca_id', 1)->where('licenca_id', '!=', 4)->count();
            $data['countlicencaspendente'] = DB::connection('mysql')->table('activacao_licencas')->where('status_licenca_id', 2)->where('licenca_id', '!=', 4)->count();
            $data['countlicencasrejeitada'] = DB::connection('mysql')->table('activacao_licencas')->where('status_licenca_id', 3)->where('licenca_id', '!=', 4)->count();
            $data['countbancos'] = DB::connection('mysql')->table('bancos')->count();
            return view('admin.dashboard', $data);
        } else {
            $infoNotificacao = $this->alertarActivacaoLicenca();
            $data['alertaAtivacaoLicenca'] = $infoNotificacao;
            $data['router'] = "/empresa";
            return view('empresa.dashboard', $data);
        }
    }


    public function index()
    {


        // dd(Auth::user()->can['gerir empresas']);

        $TIPO_FUNCIONARIO = 3;
        $TIPO_ADMIN = 2;
        $TIPO_FACTURA = 2;
        $TIPO_FACTURA_RECIBO = 1;

        $data['auth'] = Auth::user();

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['produtoMaisVendido'] = DB::select('
          select factura_items.descricao_produto,
          sum(factura_items.quantidade_produto) AS quantidade,
          SUM(factura_items.total_preco_produto) AS total_preco
                 from facturas
                 INNER JOIN factura_items ON facturas.id = factura_items.factura_id
                 WHERE facturas.anulado=1 AND facturas.empresa_id = "' . $empresa['empresa']['id'] . '"
                 GROUP by factura_items.descricao_produto
                 order by sum(factura_items.quantidade_produto) desc
                 LIMIT 6');

        $currentYear = now()->year;
        $data['vendasmensal'] = DB::connection('mysql2')->table('facturas')
            ->select(DB::raw('SUM(valor_a_pagar) as total_factura, MONTH(created_at) AS mes'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            // ->where(DB::raw('YEAR(created_at)=2021'))
            ->whereRaw("YEAR(created_at) = {$currentYear}")
            ->where('anulado', 1)
            ->where('empresa_id', $empresa['empresa']['id'])
            ->get();

        $data['countusers'] = DB::connection('mysql2')->table('users_cliente')
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countclientes'] = DB::connection('mysql2')->table('clientes')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('diversos', '!=', 'Sim')->count();

        $data['countarmazens'] = DB::connection('mysql2')->table('armazens')
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countfornecedores'] = DB::connection('mysql2')->table('fornecedores')
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countfabricantes'] = DB::connection('mysql2')->table('fabricantes')
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countbancos'] = DB::connection('mysql2')->table('bancos')
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countprodutos'] = DB::connection('mysql2')->table('produtos')
            ->where('status_id', 1)
            ->where('empresa_id', $empresa['empresa']['id'])->count();

        $data['countvendas'] = DB::connection('mysql2')->table('facturas')
            ->where('anulado', 1)
            ->where('empresa_id', $empresa['empresa']['id'])->where(function ($query) use ($TIPO_FACTURA, $TIPO_FACTURA_RECIBO) {
                $query->where('tipo_documento', $TIPO_FACTURA)
                    ->orwhere('tipo_documento', $TIPO_FACTURA_RECIBO);
            })->count();

        $data['counttotalvendas'] = DB::connection('mysql2')->table('facturas')
            ->where('anulado', 1)
            ->where('empresa_id', $empresa['empresa']['id'])->where(function ($query) use ($TIPO_FACTURA, $TIPO_FACTURA_RECIBO) {
                $query->where('tipo_documento', $TIPO_FACTURA)
                    ->orwhere('tipo_documento', $TIPO_FACTURA_RECIBO);
            })->sum('valor_a_pagar');


        if ($empresa['tipo_user_id'] === $TIPO_FUNCIONARIO) {
            $data['router'] = "/empresa/funcionario";
        } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
            $data['router'] = "/empresa";
        }
        $data['guard'] = $empresa['guard'];

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        return view('empresa.dashboard', $data);
    }
    public function listarVendasMensal()
    {
        $data['vendasmensal'] = DB::connection('mysql2')
            ->select('SELECT SUM(valor_a_pagar) AS valor_pago, MONTH(created_at) AS mes FROM facturas  WHERE facturas.anulado =1 AND YEAR(CURDATE()) GROUP BY
        MONTH(created_at)');
    }

    public function perfil()
    {


        $TIPO_FUNCIONARIO = 3;
        $TIPO_ADMIN = 2;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        if ($empresa['tipo_user_id'] === $TIPO_FUNCIONARIO) {
            $data['router'] = "/empresa/funcionario";
            $redirecionar = "empresa/home";
        } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
            $data['router'] = "/empresa";
            $redirecionar = "empresa/home";
        }
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect($redirecionar);
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        return view('empresa.usuarios.perfil', $data);

        // if (Auth::guard('web')->user()) {
        //     $data['user'] = User::findOrfail(Auth::user()->id);
        //     $data['roles'] = Role::with('permissions')->get();
        //     $data['permissions'] = Permission::with('roles')->get();

        //     $role = $data['user']->roles->first();
        //     $permission = $data['user']->permissions->first();
        //     $permission_id = $permission ? $permission->id : 1;
        //     $role_id = $role ? $role->id : 1;
        //     $data['permission'] = Permission::findOrfail($permission_id);
        //     $data['funcao'] = Role::findOrfail($role_id);
        // }
        // if ((Auth::user()->tipo_user_id) == 1) {
        //     return view('admin.usuarios.perfil', $data);
        // } else if ((Auth::user()->tipo_user_id) == 2) {
        //     return view('empresa.usuarios.perfil', $data);
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

        $data['Users'] = EmpresaUser::where('empresa_id', $empresa_id)->get();
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

        // if ((Auth::user()->tipo_user_id) == 2) {

        //     $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
        //     $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;

        // }
    }
}
