<?php

namespace App\Http\Controllers\admin;

use App\Rules\Empresa\MultEmpresaUnique;


use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\User;
use App\Models\empresa\User as userEmpresa;
use App\Models\empresa\Pais;
use App\Notifications\CadastroEmpresaNotificacao;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\Validator;
use Keygen\Keygen;
use Carbon\Carbon;


class EmpresaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function __construct()
    {
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data['clientes'] =  Empresa::with(['tipocliente', 'tiporegime'])->where('id', '!=', 1)->get();
        return view('admin.empresas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        $data['tipoRegime'] = DB::table('tipos_regimes')->get();
        $data['paises'] = Pais::all();
        return view('admin.empresas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
    }

    public function detalhes($id)
    {
        $id = base64_decode($id);

        $data['empresa'] = Empresa::find($id);

        if (!empty($data['empresa']->status_id)) {
            $data['statusgerais'] = (DB::connection('mysql')->table('status_gerais')->where('id', $data['empresa']->status_id)->first()->designacao) ? (DB::connection('mysql')->table('status_gerais')->where('id', $data['empresa']->status_id)->first()->designacao) : '';
        }
        if (!empty($data['empresa']->gestor_cliente_id)) {
            $data['gestor'] = (DB::connection('mysql')->table('gestor_clientes')->where('id', $data['empresa']->gestor_cliente_id)->first()->nome) ? (DB::connection('mysql')->table('gestor_clientes')->where('id', $data['empresa']->gestor_cliente_id)->first()->nome) : '';
        }
        return view('admin.empresas.detalhes', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
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


        $data['empresa'] = Empresa::where('user_id', Auth::user()->id)->first();


        // dd($data['empresa']);

        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        $data['tipoRegime'] = DB::connection('mysql')->table('tipos_regimes')->get();

        $data['paises'] = Pais::all();

        return view('admin.empresas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        //try {

        $empresas_adm = Empresa::where('user_id', $id)->first();
        $empresas_cli = Empresa_Cliente::where('referencia', $empresas_adm->referencia)->first();

        $user = User::findOrfail($id);
        $empresa_admin = Empresa::findOrfail($empresas_adm->id);
        $empresa_cliente = Empresa_Cliente::findOrfail($empresas_cli->id);


        $photoName = "";

        if (isset($request['logotipo']) && !empty($request['logotipo'])) {
            //remove foto anterior
            if ($user->foto && $user->foto != "utilizadores/cliente/avatarEmpresa.png") {

                try {
                    unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $user->foto);
                    $photoName = $request['logotipo']->store('/utilizadores/cliente');
                } catch (\ErrorException $th) {
                    $photoName = $request->logotipo->store('/utilizadores/cliente');
                }
            } else {
                $photoName = $request->logotipo->store('/utilizadores/cliente');
            }
        } else {
            $photoName = $user->foto;
        }

        $file_alvara = NULL;
        if (isset($empresa_admin['file_alvara']) && !empty($empresa_admin['file_alvara'])) {
            if ($request->file_alvara) {
                $file_alvara = $request->file_alvara->store('/documentos/empresa/documentos');
                unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $empresa_admin['file_alvara']);
            } else {
                $file_alvara = $empresa_admin['file_alvara'];
            }
        } else {
            $file_alvara = $request->file_alvara ? $request->file_alvara->store('/documentos/empresa/documentos') : NULL;
        }

        $file_nif = NULL;
        if (isset($empresa_admin['file_nif']) && !empty($empresa_admin['file_nif'])) {
            if ($request->file_nif && $empresa_admin['file_nif']) {
                $file_nif = $request->file_nif->store('/documentos/empresa/documentos');
                unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $empresa_admin['file_nif']);
            } else {
                $file_nif = $empresa_admin['file_nif'];
            }
        } else {
            $file_nif = $request->file_nif ? $request->file_nif->store('/documentos/empresa/documentos') : NULL;
        }



        $user->name = $request['nome'];
        $user->username = $request['nome'];
        // $empresa_admin->password = Hash::make('mutue123');
        //$user->tipo_user_id = $request['tipo_user_id'];
        $user->canal_id = $request['canal_id'];
        $user->status_id = $request['status_id'];
        $user->foto = $photoName ? $photoName : $user->foto;
        $user->remember_token = $request['remember_token'];
        $user->telefone = $request['pessoal_Contacto'];
        $user->email = $request['email'];

        $user->save();

        if (!$user) {
            return redirect()->back()->withErrors("Erro! Não possível actualizar");
        } else {

            $empresa_admin->nome = $request['nome'];
            $empresa_admin->pessoal_Contacto = $request['pessoal_Contacto'];
            $empresa_admin->endereco = $request['endereco'];
            $empresa_admin->pais_id = $request['pais_id'];
            $empresa_admin->cidade = $request['cidade'];
            $empresa_admin->saldo = 0.00;
            $empresa_admin->file_alvara = $file_alvara;
            $empresa_admin->file_nif = $file_nif;
            //$empresa_cliente->referencia = Empresa::latest()->first()->referencia;
            $empresa_admin->canal_id = $request['canal_id'];
            $empresa_admin->status_id = $request['status_id'];
            $empresa_admin->nif = $request['nif'];
            $empresa_admin->gestor_cliente_id = Empresa::latest()->first()->gestor_cliente_id;
            $empresa_admin->tipo_cliente_id = $request['tipo_cliente_id'];
            $empresa_admin->tipo_regime_id = $request['tipo_regime_id'];
            $empresa_admin->logotipo = $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png";
            $empresa_admin->Website = $request['Website'];
            $empresa_admin->email = $request['email'];
            $empresa_admin->pessoa_de_contacto = $request['pessoa_de_contacto'];

            $empresa_admin->save();

            if (!$empresa_admin) {
                return redirect()->back()->withErrors("Erro! Não possível actualizar");
            } else {
                $empresa_cliente->nome = $request['nome'];
                $empresa_cliente->pessoal_Contacto = $request['pessoal_Contacto'];
                $empresa_cliente->endereco = $request['endereco'];
                $empresa_cliente->pais_id = $request['pais_id'];
                $empresa_cliente->cidade = $request['cidade'];
                $empresa_cliente->saldo = 0.00;
                $empresa_cliente->file_alvara = $file_alvara;
                $empresa_cliente->file_nif = $file_nif;
                //$empresa_cliente->referencia = Empresa::latest()->first()->referencia;
                $empresa_cliente->canal_id = $request['canal_id'];
                $empresa_cliente->status_id = $request['status_id'];
                $empresa_cliente->nif = $request['nif'];
                $empresa_cliente->gestor_cliente_id = Empresa::latest()->first()->gestor_cliente_id;
                $empresa_cliente->tipo_cliente_id = $request['tipo_cliente_id'];
                $empresa_cliente->tipo_regime_id = $request['tipo_regime_id'];
                $empresa_cliente->logotipo = $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png";
                $empresa_cliente->website = $request['Website'];
                $empresa_cliente->email = $request['email'];
                $empresa_cliente->pessoa_de_contacto = $request['pessoa_de_contacto'];

                $empresa_cliente->save();

                return redirect('empresa/configuracao')->withSuccess('Operação efectuada com sucesso!');
            }
        }

        //    }catch (\Exception $th) {
        //         return redirect()->back()->withErrors("Erro! Não possível actualizar");
        //    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        try {
            DB::beginTransaction();

            if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super-Admin')) {

                $empresas_adm = Empresa::where('id', $id)->first();
                $empresas_cli = Empresa_Cliente::where('referencia', $empresas_adm->referencia)->first();

                $user = User::findOrfail($empresas_adm->user_id);
                $empresa_adm = Empresa::findOrfail($empresas_adm->id);
                $empresa_cl = Empresa_Cliente::findOrfail($empresas_cli->id);

                $empresa_cl->forceDelete();
                $empresa_adm->forceDelete();
                $user->forceDelete();

                DB::rollback();
                DB::commit();
            } else {
                return redirect()->back()->withErrors('Sem permissão para efectuar esta operação!');
            }
        } catch (\Exception $th) {
            return redirect()->back()->withErrors("Não é possível eliminar este Cliente, está a ser utilizada por uma entidade");
        }



        return redirect('admin/usuarios')->withSuccess('Operação efectuada com Sucesso!');
    }
    public function cadastrarEmpresaApi(Request $request)
    {


        $CARTAO_CREDITO = 1;
        $STATUS_ATIVO = 1;
        $CANAL_PORTAL_CLIENTE = 2;
        $CANAL_PORTAL_ADMIN = 3;
        $TIPO_USER_EMPRESA = 2;
        $SENHA_VULNERAVEL = 1;
        $data = $request->all();

        $mensagem = [
            'pessoal_Contacto.required' => 'É obrigatória o contacto',
            'pais_id.required' => 'É obrigatória selecionar o país',
            'tipo_cliente_id.required' => 'É obrigatória selecionar o tipo de empresa',
            'tipo_regime_id.required' => 'É obrigatória selecionar o tipo de regime',
        ];

        $validator = Validator::make($data, [
            'email' => ['required', 'email', 'max:145', function ($attribute, $value, $fail) {

                $userCliente = DB::connection('mysql')->table('users_admin')->where('email', $value)->first();
                if ($userCliente) $fail('A ' . $attribute . ' já se encontra registrado');

                $userCliente = DB::connection('mysql2')->table('users_cliente')->where('email', $value)->first();
                if ($userCliente) $fail('A ' . $attribute . ' já se encontra registrado');

                $userCliente = DB::connection('mysql')->table('empresas')->where('email', $value)->first();
                if ($userCliente) $fail('A ' . $attribute . ' já se encontra registrado');
            }],

            'nome' => ['required', 'string', 'min:3', 'max:255', function ($attribute, $value, $fail) {
                $empresa = DB::connection('mysql')->table('empresas')->where('nome', $value)->first();
                if ($empresa) $fail('A ' . $attribute . ' já se encontra registrado');
            }],
            'pessoal_Contacto' => ['required', 'string', 'max:9', function ($attribute, $value, $fail) {
                $empresa = DB::connection('mysql')->table('empresas')->where('pessoal_Contacto', $value)->first();
                if ($empresa) $fail('A ' . $attribute . ' já se encontra registrado');
            }],
            'endereco' => ['required', 'string'],
            'cidade' => ['required'],
            'tipo_cliente_id' => ['required', 'numeric'],
            'tipo_regime_id' => ['required', 'numeric'],
            'pais_id' => ['required', 'numeric'],
            'nif' => ['required', 'string', 'max:14', function ($attribute, $value, $fail) {
                $empresa = DB::connection('mysql')->table('empresas')->where('nif', $value)->first();
                if ($empresa) $fail('A ' . $attribute . ' já se encontra registrado');
            }],
            'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ], $mensagem);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }


        //dd($request->all());

        DB::beginTransaction();

        // try {

        if (isset($data['logotipo']) && !empty($data['logotipo'])) {
            $photoName = $data['logotipo']->store('/utilizadores/cliente');
        } else {
            $photoName = NULL;
        }

        if (isset($data['file_alvara']) && !empty($data['file_alvara'])) {
            $alvaraName = $data['file_alvara']->store('/documentos/empresa/documentos');
        } else {
            $alvaraName = NULL;
        }

        if (isset($data['file_nif']) && !empty($data['file_nif'])) {
            $nifName = $data['file_nif']->store('/documentos/empresa/documentos');
        } else {
            $nifName = NULL;
        }

        // $userId = DB::connection('mysql')->table('users_admin')->insertGetId([
        //     'name' => $data['nome'],
        //     'username' => $data['nome'],
        //     'password' => Hash::make('mutue123'),
        //     'tipo_user_id' => $TIPO_USER_EMPRESA,
        //     'status_id' => $STATUS_ATIVO,
        //     'status_senha_id' => $SENHA_VULNERAVEL,
        //     'foto' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
        //     'remember_token' => $data['remember_token'],
        //     'telefone' => $data['pessoal_Contacto'],
        //     'email' => $data['email'],
        //     'canal_id' => $CANAL_PORTAL_ADMIN
        // ]);


        $referencia = mb_strtoupper(Keygen::alphanum(7)->generate());

        //cadastrar empresa admin
        $empresaAdminId = DB::connection('mysql')->table('empresas')->insertGetId([
            'nome' => $data['nome'],
            'pessoal_Contacto' => $data['pessoal_Contacto'],
            'endereco' => $data['endereco'],
            'pais_id' => $data['pais_id'],
            'saldo' => 0.00,
            'canal_id' => $CANAL_PORTAL_ADMIN,
            'status_id' => $STATUS_ATIVO,
            'nif' => $data['nif'],
            'gestor_cliente_id' => 1,
            'tipo_cliente_id' => $data['tipo_cliente_id'],
            'tipo_regime_id' => $data['tipo_regime_id'],
            'logotipo' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
            'website' => $data['website'],
            'email' => $data['email'],
            'file_alvara' => $alvaraName,
            'file_nif' => $nifName,
            'cidade' => $data['cidade'],
            'referencia' => $referencia
        ]);
        //fim cadastro empresa admin

        //cadastrar empresa cliente
        $empresaId = DB::connection('mysql2')->table('empresas')->insertGetId([
            'nome' => $data['nome'],
            'pessoal_Contacto' => $data['pessoal_Contacto'],
            'endereco' => $data['endereco'],
            'pais_id' => $data['pais_id'],
            'saldo' => 0.00,
            'referencia' => Empresa::latest()->first()->referencia,
            'canal_id' => $CANAL_PORTAL_ADMIN,
            'status_id' => $STATUS_ATIVO,
            'nif' => $data['nif'],
            'gestor_cliente_id' => Empresa::latest()->first()->gestor_cliente_id,
            'tipo_cliente_id' => $data['tipo_cliente_id'],
            'tipo_regime_id' => $data['tipo_regime_id'],
            'logotipo' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
            'website' => $data['website'],
            'email' => $data['email'],
            'file_alvara' => $alvaraName,
            'file_nif' => $nifName,
            'cidade' => $data['cidade'],
            'referencia' => $referencia
        ]);
        //fim cadastro empresa cliente

        $userId = DB::connection('mysql2')->table('users_cliente')->insertGetId([
            'name' => $data['nome'],
            'username' => $data['nome'],
            'password' => Hash::make('mutue123'),
            'tipo_user_id' => $TIPO_USER_EMPRESA,
            'status_id' => $STATUS_ATIVO,
            'status_senha_id' => $SENHA_VULNERAVEL,
            'telefone' => $data['pessoal_Contacto'],
            'email' => $data['email'],
            'canal_id' => $CANAL_PORTAL_ADMIN,
            'empresa_id' => $empresaId,
            'foto' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
            // 'remember_token' => $data['remember_token'],
        ]);

        //Dar função ao utilizador
        DB::connection('mysql2')->table('model_has_roles')->insert([
            'role_id' => 1, //Super admin
            'model_id' => $userId,
            'model_type' => 'App\Models\empresa\User',
        ]);

        //Adicionar Todas permissões
        $permissions = DB::connection('mysql2')->table('permissions')->get();
        foreach ($permissions as $key => $permission) {
            DB::connection('mysql2')->table('model_has_permissions')->insert([
                'permission_id' => $permission->id,
                'model_id' => $userId,
                'model_type' => 'App\Models\empresa\User',
            ]);
        }

        //activação de licença da empresa
        $PORTAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $LICENCA_GRATIS = 1;

        $paramentro = DB::connection('mysql')->table('parametros')->where('id', 1)->first();

        DB::connection('mysql')->table('activacao_licencas')->insertGetId([

            'licenca_id' => $LICENCA_GRATIS,
            'empresa_id' => $empresaAdminId,
            'data_inicio' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_activacao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_fim' => date('Y-m-d', strtotime("+$paramentro->valor days")),
            // 'user_id' =>  $userId,
            'canal_id' => $PORTAL_CLIENTE,
            'status_licenca_id' => $STATUS_ATIVO,
            'observacao' => 'Ativação da licença grátis',
            'data_notificaticao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))

        ]);
        //fim activação de licença da empresa

        //Cadastra armazem principal
        $ARMAZEM_PRINCIPAL = 1;
        DB::connection('mysql2')->table('armazens')->insertGetId([
            'codigo' => mb_strtoupper(Keygen::numeric(9)->generate()),
            'designacao' => "LOJA PRINCIPAL",
            'localizacao' => $data['endereco'],
            'status_id' => $STATUS_ATIVO,
            'diversos' => $ARMAZEM_PRINCIPAL,
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
        ]);

        // Cadastra unidade medida default
        $UN_DIVERSOS = 1;
        DB::connection('mysql2')->table('unidade_medidas')->insertGetId([
            'designacao' => "un",
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
            'canal_id' => 2, //canal cliente
            'status_id' => $STATUS_ATIVO,
            'diversos' => $UN_DIVERSOS
        ]);

        $empresa = Empresa_Cliente::where('id', $empresaId)->first();

        //cadastrar empresa contsys
        $empresaContsysId = DB::connection('mysql3')->table('empresas')->insertGetId([
            'Nome' => $empresa->nome,
            'Endereco' => $empresa->endereco,
            'Movel' => $empresa->pessoal_Contacto,
            'website' => $data['website'],
            'DataCadastro' => date("Y-m-d"),
            'NIF' => $empresa->nif,
            'referenciaEmpresa' => $empresa->referencia
        ]);
        //fim cadastro empresa contsys

        //cadastro utilizador contsys
        $STATUS_ATIVO = 1;
        $TIPO_USUARIO_ADMIN = 1;

        $utilizadorId = DB::connection('mysql3')->table('utilizadores')->insertGetId([
            'Nome' => $data['nome'],
            'Username' => $data['nome'],
            'email' => $data['email'],
            'Password' => Hash::make('mutue123'),
            'CodStatus' => $STATUS_ATIVO,
            'CodTipoUser' => $TIPO_USUARIO_ADMIN,
            'empresa_id' => $empresaId,
            'UserId' => $userId
        ]);
        //fim cadastro utilizador contsys

        //buscar empresa contsys
        $CONTA_CLIENTE = 16;
        $empresaContsysId = $this->buscarEmpresaContsysId($empresa);
        $contaCorrente = $this->buscarContaCorrente($empresaContsysId, $CONTA_CLIENTE);

        // Cadastra cliente default
        $clienteId = DB::connection('mysql2')->table('clientes')->insertGetId([
            'nome' => "Consumidor final",
            'nif' => "999999999",
            'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
            'status_id' => $STATUS_ATIVO, //activo
            'diversos' => "Sim",
            'tipo_cliente_id' => $data['tipo_cliente_id'],
            'conta_corrente' => $contaCorrente,
            'diversos' => "Sim",
            'endereco' => 'Av. Deolinda Rodrigues, 123',
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
            'pais_id' => $data['pais_id'],
            'cidade' => $data['cidade']
        ]);

        //criar Subconta contsys
        $CONTA_ATIVO = 3;
        $CONTA_CLIENTE = 16;
        $CODIGO_ADMIN = 1;

        DB::connection('mysql3')->table('subcontas')->insert([
            'Numero' => $contaCorrente,
            'Descricao' => 'CLIENTE DIVERSOS',
            'CodConta' => $CONTA_CLIENTE,
            'CodUtilizador' => $utilizadorId,
            'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
            'CodTipoConta' => $CONTA_ATIVO,
            'CodEmpresa' => $empresaContsysId,
            'Movimentar' => "SIM",
            'codigoCliente' => $clienteId
        ]);

        //cadastra fabricante default
        $TIPO_EMPRESA = 2;
        DB::connection('mysql2')->table('fabricantes')->insert([
            'designacao' => "DIVERSOS",
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
            'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
            'user_id' => $userId, //user
            'status_id' => $STATUS_ATIVO, //activo
            'diversos' => "Sim",
            'tipo_user_id' =>  $TIPO_EMPRESA
        ]);

        $CONTA_FONECEDOR = 17;
        $FORNECEDOR_DIVERSOS = 1;
        $contaCorrenteFornecedor = $this->buscarContaCorrente($empresaContsysId, $CONTA_FONECEDOR);

        //cadastra fornecedor default
        $fornecedorId = DB::connection('mysql2')->table('fornecedores')->insertGetId([
            'nome' => "DIVERSOS",
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
            'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
            'status_id' => $STATUS_ATIVO, //activo
            'user_id' => $userId, //user
            'diversos' => $FORNECEDOR_DIVERSOS,
            'conta_corrente' => $contaCorrenteFornecedor,
            'pais_nacionalidade_id' => 1, //Angola
            'tipo_user_id' =>  $TIPO_EMPRESA
        ]);
        //cadastra subconta fornecedor contsys
        DB::connection('mysql3')->table('subcontas')->insert([
            'Numero' => $contaCorrenteFornecedor,
            'Descricao' => 'FORNECEDOR DIVERSOS',
            'CodConta' => $CONTA_FONECEDOR,
            'CodUtilizador' => $utilizadorId,
            'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
            'CodTipoConta' => $CONTA_ATIVO,
            'CodEmpresa' => $empresaContsysId,
            'Movimentar' => "SIM",
            'codigoFornecedor' => $fornecedorId
        ]);


        //INFO PARA ENVIO DE EMAIL
        $infoEmail['nome'] = $data['nome'];
        $infoEmail['email'] = $data['email'];
        $infoEmail['senha'] = 'mutue123';
        $infoEmail['linkLogin'] = getenv('APP_URL');
        $infoEmail['pessoal_Contacto'] = $data['pessoal_Contacto'];
        $infoEmail['empresa_id'] = $empresaId;
        $infoEmail['data'] = $empresa;

        //FIM ENVIO EMAIL
        $empresaAdmin = Empresa::where('id', $empresaAdminId)->first();

        $empresaAdmin->notify(new CadastroEmpresaNotificacao($infoEmail));
        $userCliente = userEmpresa::find($userId);
        DB::commit();
        return response()->json($userCliente, 200);
        //} catch (\Exception $th) {
        // DB::rollBack();
        //}
    }
    public function buscarEmpresaContsysId($empresa)
    {
        return DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first()->Codigo;
    }
    public function buscarContaCorrente($empresaId, $tipoConta)
    {
        $CONTA_CLIENTE = 16;
        $CONTA_FONECEDOR = 17;

        if ($tipoConta == $CONTA_CLIENTE) {
            $TIPO_CONTA = $CONTA_CLIENTE;
        } else if ($tipoConta == $CONTA_FONECEDOR) {
            $TIPO_CONTA = $CONTA_FONECEDOR;
        }

        $resultado =  DB::connection('mysql3')->table('subcontas')->where('CodConta', $TIPO_CONTA)
            ->orderBy('Codigo', 'DESC')->where('CodEmpresa', $empresaId)->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->Numero);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string)$ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            if ($tipoConta == $CONTA_CLIENTE) {
                $contaCorrente = "31.1.2.1.1";
            } else {
                $contaCorrente = "32.1.2.1.1";
            }
        }

        return $contaCorrente;
    }

    // public function cadastrarEmpresaApi(Request $request){



    //     $data = $request->all();

    //     $CARTAO_CREDITO = 1;
    //     $STATUS_ATIVO = 1;
    //     $CANAL_PORTAL_CLIENTE = 2;
    //     $CANAL_PORTAL_ADMIN = 3;
    //     $TIPO_USER_EMPRESA = 2;
    //     $SENHA_VULNERAVEL = 1;

    //     $mensagem = [
    //         'pessoal_Contacto.required' => 'É obrigatória o contacto',
    //         'pais_id.required' => 'É obrigatória selecionar o país',
    //         'tipo_cliente_id.required' => 'É obrigatória selecionar o tipo de empresa',
    //         'tipo_regime_id.required' => 'É obrigatória selecionar o tipo de regime',
    //     ];

    //     $validator = Validator::make($data, [
    //         'email' => ['required', 'email', 'max:145', new MultEmpresaUnique('users_admin', 'mysql'), function ($attribute, $value, $fail) {
    //             $userCliente =  new MultEmpresaUnique('users_cliente', 'mysql2');
    //             if (!$userCliente->passes($attribute, $value)) {
    //                 $fail('O ' . $attribute . ' já se encontra registrado');
    //             }

    //             $userCliente =  new MultEmpresaUnique('empresas', 'mysql');
    //             if (!$userCliente->passes($attribute, $value)) {
    //                 $fail('O ' . $attribute . ' já se encontra registrado');
    //             }
    //         }],

    //         'nome' => ['required', 'string', 'min:3', 'max:255', new MultEmpresaUnique('empresas', 'mysql')],
    //         'pessoal_Contacto' => ['required', 'string', 'max:9', new MultEmpresaUnique('empresas', 'mysql')],
    //         'endereco' => ['required', 'string'],
    //         'cidade' => ['required'],
    //         'tipo_cliente_id' => ['required', 'numeric'],
    //         'tipo_regime_id' => ['required', 'numeric'],
    //         'pais_id' => ['required', 'numeric'],
    //         'nif' => ['required', 'string', 'max:14', new MultEmpresaUnique('empresas', 'mysql')],
    //         'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
    //     ], $mensagem);


    //     if ($validator->fails()) {
    //         return response()->json($validator->errors()->messages(), 422);
    //     }

    //     DB::beginTransaction();

    //    try {

    //         if (isset($data['logotipo']) && !empty($data['logotipo'])) {
    //             $photoName = $data['logotipo']->store('/utilizadores/cliente');
    //         } else {
    //             $photoName = NULL;
    //         }

    //         $user = User::create([
    //             'name' => $data['nome'],
    //             'username' => $data['nome'],
    //             'password' => Hash::make('mutue123'),
    //             'tipo_user_id' => $TIPO_USER_EMPRESA,
    //             'status_id' => $STATUS_ATIVO,
    //             'status_senha_id' => $SENHA_VULNERAVEL,
    //             'foto' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
    //             'telefone' => $data['pessoal_Contacto'],
    //             'email' => $data['email'],
    //             'canal_id' => $CANAL_PORTAL_ADMIN,
    //         ]);


    //         $user->assignRole('Empresa');

    //         if (!$user) {
    //             dd('Não foi possivel registar a empresa');
    //         } else {


    //             $referencia = mb_strtoupper(Keygen::alphanum(7)->generate());

    //             $empresaAdminId = DB::connection('mysql')->table('empresas')->insertGetId([
    //                 'nome' => $data['nome'],
    //                 'pessoal_Contacto' => $data['pessoal_Contacto'],
    //                 'endereco' => $data['endereco'],
    //                 'pais_id' => $data['pais_id'],
    //                 'saldo' => 0.00,
    //                 'user_id' => User::latest()->first()->id,
    //                 'canal_id' => $CANAL_PORTAL_ADMIN,
    //                 'status_id' => $STATUS_ATIVO,
    //                 'nif' => $data['nif'],
    //                 'gestor_cliente_id' => 1,
    //                 'tipo_cliente_id' => $data['tipo_cliente_id'],
    //                 'tipo_regime_id' => $data['tipo_regime_id'],
    //                 'logotipo' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
    //                 'website' => $data['website'],
    //                 'email' => $data['email'],
    //                 'cidade' => $data['cidade'],
    //                 'referencia' => $referencia
    //             ]);

    //             $empresaId = DB::connection('mysql2')->table('empresas')->insertGetId([
    //                 'nome' => $data['nome'],
    //                 'pessoal_Contacto' => $data['pessoal_Contacto'],
    //                 'endereco' => $data['endereco'],
    //                 'pais_id' => $data['pais_id'],
    //                 'saldo' => 0.00,
    //                 'referencia' => Empresa::latest()->first()->referencia,
    //                 'canal_id' => $CANAL_PORTAL_ADMIN,
    //                 'status_id' => $STATUS_ATIVO,
    //                 'nif' => $data['nif'],
    //                 'gestor_cliente_id' => Empresa::latest()->first()->gestor_cliente_id,
    //                 'tipo_cliente_id' => $data['tipo_cliente_id'],
    //                 'tipo_regime_id' => $data['tipo_regime_id'],
    //                 'logotipo' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
    //                 'website' => $data['website'],
    //                 'email' => $data['email'],
    //                 'cidade' => $data['cidade'],
    //                 'referencia' => $referencia
    //             ]);

    //             $registerController = new RegisterController();
    //             $registerController->activarLicencaGratis($empresaAdminId, $user->id);

    //             $ARMAZEM_PRINCIPAL = 1;

    //             //Cadastra armazem principal
    //             DB::connection('mysql2')->table('armazens')->insert([
    //                 'designacao' => "LOJA PRINCIPAL",
    //                 'localizacao' => $data['endereco'],
    //                 'status_id' => $STATUS_ATIVO,
    //                 'diversos' => $ARMAZEM_PRINCIPAL,
    //                 'empresa_id' => Empresa_Cliente::latest()->first()->id,
    //             ]);

    //             // Cadastra unidade medida default
    //             $UN_DIVERSOS = 1;
    //             DB::connection('mysql2')->table('unidade_medidas')->insert([
    //                 'designacao' => "un",
    //                 'empresa_id' => Empresa_Cliente::latest()->first()->id,
    //                 'canal_id' => 2, //canal cliente
    //                 'status_id' => $STATUS_ATIVO,
    //                 'diversos' => $UN_DIVERSOS
    //             ]);
    //             // cadastras  contsys
    //             $empresa = DB::connection('mysql2')->table('empresas')->where('id', $empresaId)->first();
    //             $registerController->cadastrarEmpresaContsys($empresa, $data);
    //             $registerController->cadastrarUtilizadorContsys($empresa, $data, $user->id);

    //             $CONTA_CLIENTE = 16;

    //             $empresaContsysId = $registerController->buscarEmpresaContsysId($empresa);
    //             $contaCorrente = $registerController->buscarContaCorrente($empresaContsysId, $CONTA_CLIENTE);

    //             // Cadastra cliente default
    //             $clienteId = DB::connection('mysql2')->table('clientes')->insertGetId([
    //                 'nome' => "Consumidor final",
    //                 'nif' => "999999999",
    //                 'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
    //                 'status_id' => $STATUS_ATIVO, //activo
    //                 'diversos' => "Sim",
    //                 'tipo_cliente_id' => $data['tipo_cliente_id'],
    //                 'conta_corrente' => $contaCorrente,
    //                 'diversos' => "Sim",
    //                 'empresa_id' => Empresa_Cliente::latest()->first()->id,
    //                 'pais_id' => $data['pais_id'],
    //                 'cidade' => $data['cidade']
    //             ]);

    //             //criar Subconta contsys
    //             $CONTA_ATIVO = 3;
    //             $CONTA_CLIENTE = 16;
    //             $CODIGO_ADMIN = 1;

    //             $registerController->cadastrarClienteDiversosContsys([
    //                 'Numero' => $contaCorrente,
    //                 'Descricao' => 'CLIENTE DIVERSOS',
    //                 'CodConta' => $CONTA_CLIENTE,
    //                 'CodUtilizador' => $CODIGO_ADMIN,
    //                 'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
    //                 'CodTipoConta' => $CONTA_ATIVO,
    //                 'CodEmpresa' => $empresaContsysId,
    //                 'Movimentar' => "SIM",
    //                 'codigoCliente' => $clienteId
    //             ]);

    //             //cadastra fabricante default

    //             $TIPO_EMPRESA = 2;
    //             DB::connection('mysql2')->table('fabricantes')->insert([
    //                 'designacao' => "DIVERSOS",
    //                 'empresa_id' => Empresa_Cliente::latest()->first()->id,
    //                 'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
    //                 'user_id' => $user->id, //user
    //                 'status_id' => $STATUS_ATIVO, //activo
    //                 'diversos' => "Sim",
    //                 'tipo_user_id' =>  $TIPO_EMPRESA
    //             ]);

    //             $CONTA_FONECEDOR = 17;
    //             $FORNECEDOR_DIVERSOS = 1;
    //             $contaCorrenteFornecedor = $registerController->buscarContaCorrente($empresaContsysId, $CONTA_FONECEDOR);


    //             //cadastra fornecedor default
    //             $fornecedorId = DB::connection('mysql2')->table('fornecedores')->insertGetId([
    //                 'nome' => "DIVERSOS",
    //                 'empresa_id' => Empresa_Cliente::latest()->first()->id,
    //                 'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
    //                 'status_id' => $STATUS_ATIVO, //activo
    //                 'user_id' => $user->id, //user
    //                 'diversos' => $FORNECEDOR_DIVERSOS,
    //                 'conta_corrente' => $contaCorrenteFornecedor,
    //                 'pais_nacionalidade_id' => 1, //Angola
    //                 'tipo_user_id' =>  $TIPO_EMPRESA
    //             ]);
    //             //cadastra subconta fornecedor contsys
    //             DB::connection('mysql3')->table('subcontas')->insert([
    //                 'Numero' => $contaCorrenteFornecedor,
    //                 'Descricao' => 'FORNECEDOR DIVERSOS',
    //                 'CodConta' => $CONTA_FONECEDOR,
    //                 'CodUtilizador' => $CODIGO_ADMIN,
    //                 'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
    //                 'CodTipoConta' => $CONTA_ATIVO,
    //                 'CodEmpresa' => $empresaContsysId,
    //                 'Movimentar' => "SIM",
    //                 'codigoFornecedor' => $fornecedorId

    //             ]);
    //             DB::commit();
    //         }
    //    } catch (\Exception $th) {
    //         DB::rollBack();
    //    }

    //     if ($user) {
    //         //INFO PARA ENVIO DE EMAIL
    //         $infoEmail['nome'] = $data['nome'];
    //         $infoEmail['email'] = $data['email'];
    //         $infoEmail['senha'] = 'mutue123';
    //         $infoEmail['linkLogin'] = getenv('APP_URL');
    //         $infoEmail['pessoal_Contacto'] = $data['pessoal_Contacto'];
    //         $infoEmail['empresa_id'] = $empresaId;

    //         //FIM ENVIO EMAIL
    //         $user->notify(new NotificationsCadastroEmpresaNotificacao($infoEmail));

    //         return response()->json($user, 200);
    //     }

    //     return null;
    // }
    public function listarTipoEmpresa()
    {

        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        return response()->json($data, 200);
    }
    public function listarRegimeEmpresa()
    {
        $data['tipoRegime'] = DB::table('tipos_regimes')->get();
        return response()->json($data, 200);
    }

    public function imprimirClientes()
    {

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        
        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $dirSubreportEmpresa = public_path() . "/upload/admin/relatorios/";


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'listarClientes',
                'report_jrxml' => 'listarClientes.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => $dirSubreportEmpresa,
                    "diretorio" =>  $diretorio
                ]
            ]
        );
    }
}
