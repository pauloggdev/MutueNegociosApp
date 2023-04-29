<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\JobAtivacaoEmpresa;
use App\Jobs\JobCadastroEmpresaNotificacao;
use App\Mail\AtivacaoEmpresa;
use App\Mail\CadastroEmpresaNotificacao;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\admin\Empresa;
use App\Models\contsys\SubConta;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Pais;
use App\Models\empresa\User as EmpresaUser;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use Illuminate\Support\Facades\Mail;
use Keygen\Keygen;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/empresa/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!strpos(url()->current(), "api")) {
            $this->middleware('guest');
        }
    }

    public function showRegistrationForm()
    {
        return view('admin.empresas.create');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    // public function validarEmpresa(Request $data)
    // {
    //     $this->validator($data);
    // }

    public function validator(array $data)
    {

        $mensagem = [
            'pessoal_Contacto.required' => 'É obrigatória o contacto',
            'pais_id.required' => 'É obrigatório selecionar o país',
            'tipo_cliente_id.required' => 'É obrigatório selecionar o tipo de empresa',
            'tipo_regime_id.required' => 'É obrigatório selecionar o tipo de regime',
            'file_alvara.mimes' => 'É obrigatório selecionar arquivo no formato pdf',
            'file_nif.mimes' => 'É obrigatório selecionar arquivo no formato pdf',
        ];

        // if (strpos(url()->current(), "api")) {
        //     $data = $data->all();
        // }

        // return response()->json($data, 400);
        $validator =  Validator::make($data, [
            'email' => ['required', 'email', 'max:145', new EmpresaUnicaAdmin('users_admin', 'mysql'), function ($attribute, $value, $fail) {
                $userCliente =  new EmpresaUnicaAdmin('users_cliente', 'mysql2');
                if (!$userCliente->passes($attribute, $value)) {
                    $fail('O ' . $attribute . ' já se encontra registrado');
                }
                $userCliente =  new EmpresaUnicaAdmin('empresas', 'mysql');
                if (!$userCliente->passes($attribute, $value)) {
                    $fail('O ' . $attribute . ' já se encontra registrado');
                }
            }],

            'nome' => ['required', 'string', 'max:255', new EmpresaUnicaAdmin('empresas', 'mysql')],
            'pessoal_Contacto' => ['required', 'string', new EmpresaUnicaAdmin('empresas', 'mysql'), function ($attribute, $value, $fail) {

                $contatoExiste = DB::connection('mysql2')->table('empresas')->where('pessoal_Contacto', $value)->first();
                if ($contatoExiste) {
                    $fail('O contato já cadastrado no sistema');
                }
            }],
            'endereco' => ['required', 'string'],
            'cidade' => ['required'],
            'file_alvara' => ['file', 'mimes:pdf'],
            'file_nif' => ['file', 'mimes:pdf'],
            'tipo_cliente_id' => ['required', 'numeric'],
            'tipo_regime_id' => ['required', 'numeric'],
            'pais_id' => ['required', 'numeric'],
            'nif' => ['required', 'string'],
            'logotipo' => ['image'],
        ], $mensagem);


        if (strpos(url()->current(), "api")) {
            if ($validator->fails()) {
                return response()->json($validator->errors()->messages(), 400);
            } else {
                return response()->json('ok', 200);
            }
        } else {
            return $validator;
        }
    }

    public function validarEmpresa(Request $request)
    {
        if (strpos(url()->current(), "api")) {
            $canal_id = 4;
            $dataRequest = $this->validator($request->all());
            if ($dataRequest->status() == 400) {
                return $dataRequest;
            }
        } else {
            $canal_id = 2;
            $this->validator($request->all())->validate();
        }



        if (isset($request['logotipo']) && !empty($request['logotipo'])) {
            $photoName = $request['logotipo']->store('/utilizadores/cliente');
        } else {
            $photoName = 'utilizadores/cliente/avatarEmpresa.png';
        }


        if (isset($request['file_alvara']) && !empty($request['file_alvara'])) {
            $alvaraName = $request['file_alvara']->store('/documentos/empresa/documentos');
        } else {
            $alvaraName = NULL;
        }

        if (isset($request['file_nif']) && !empty($request['file_nif'])) {
            $nifName = $request['file_nif']->store('/documentos/empresa/documentos');
        } else {
            $nifName = NULL;
        }

        $token = md5(time() . rand(0, 99999) . rand(0, 99999));

        DB::beginTransaction();

        try {
            DB::connection('mysql')->table('validacao_empresa')->insertGetId([
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'pais_id' => $request->pais_id,
                'nif' => $request->nif,
                'tipo_cliente_id' => $request->tipo_cliente_id,
                'tipo_regime_id' => $request->tipo_regime_id,
                'canal_comunicacao_id' => $canal_id,
                'logotipo' => $photoName,
                'website' => $request->website,
                'email' => $request->email,
                'cidade' => $request->cidade,
                'pessoal_Contacto' => $request->pessoal_Contacto,
                'file_alvara' => $alvaraName,
                'file_nif' => $nifName,
                'token' => $token,
                'expirado_em' => date('Y-m-d H:i', strtotime('+2 days')),
                'used' => 0,
                'remember_token' => $request->remember_token
            ]);

            $data['email'] = $request->email;
            $data['url'] = env('APP_URL') . 'register?token=' . $token . '&canal=' . $canal_id;

            $mensagem = 'Acessa o email ' . $request->email . ', clica no link para confirmar o cadastro da sua empresa';
            $data['mensagem'] = $mensagem;
            JobAtivacaoEmpresa::dispatch($data)->delay(now()->addSecond('5'));


            $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
            $data['tipoRegime'] = DB::table('tipos_regimes')->get();
            $data['paises'] = Pais::all();
            DB::commit();

            if (strpos(url()->current(), "api")) {
                return response()->json($mensagem, 200);
            }
            return view('admin.empresas.create', $data);
            // return redirect('/register?token=' . $token);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function removerTokenInvalidos()
    {
        DB::connection('mysql')->table('validacao_empresa')
            ->whereDate('expirado_em', '<=', date('Y-m-d H:i:s'))
            ->delete();
    }

    public function getEmpresaTokenValido($request)
    {
        return DB::connection('mysql')->table('validacao_empresa')
            ->where('token', $request->token)->where('used', 0)
            ->whereDate('expirado_em', '>=', date('Y-m-d H:i:s'))
            ->first();
    }

    public function cadastrarEmpresaAdmin($data)
    {
        return DB::connection('mysql')->table('empresas')->insertGetId([
            'nome' => $data->nome,
            'pessoal_Contacto' => $data->pessoal_Contacto,
            'endereco' => $data->endereco,
            'pais_id' => $data->pais_id,
            'saldo' => 0.00,
            'nif' => $data->nif,
            'gestor_cliente_id' => 1,
            'tipo_cliente_id' => $data->tipo_cliente_id,
            'tipo_regime_id' => $data->tipo_regime_id,
            'logotipo' => $data->logotipo,
            'website' => $data->website,
            'email' => $data->email,
            'referencia' => $data->referencia,
            'status_id' => 1,
            'canal_id' => 3,
            'cidade' => $data->cidade,
            'file_alvara' => $data->file_alvara,
            'file_nif' => $data->file_nif
        ]);
    }
    public function cadastrarEmpresaCliente($data)
    {
        return DB::connection('mysql2')->table('empresas')->insertGetId([
            'nome' => $data->nome,
            'pessoal_Contacto' => $data->pessoal_Contacto,
            'telefone1' => $data->pessoal_Contacto,
            'endereco' => $data->endereco,
            'pais_id' => $data->pais_id,
            'saldo' => 0.00,
            'canal_id' => 2,
            'status_id' => 1,
            'nif' => $data->nif,
            'gestor_cliente_id' => 1,
            'tipo_cliente_id' => $data->tipo_cliente_id,
            'tipo_regime_id' => $data->tipo_regime_id,
            'logotipo' => $data->logotipo,
            'website' => $data->website,
            'email' => $data->email,
            'referencia' => $data->referencia,
            'file_alvara' => $data->file_alvara,
            'file_nif' => $data->file_nif,
            'cidade' => $data->cidade,
        ]);
    }
    public function cadastrarCentroDeCusto($data)
    {

        $alvaraCentro = NULL;
        $nifCentro = NULL;
        $photoNameCentro = NULL;

        if ($data->logotipo) {
            $photoNameCentro = Str::after($data->logotipo, 'utilizadores/cliente/');
            $photoNameCentro = 'utilizadores/empresa/centroCustos/' . $photoNameCentro;
        }

        if ($data->file_alvara) {
            $alvaraCentro = Str::after($data->file_alvara, '/documentos/empresa/documentos/');
            $alvaraCentro = 'documentos/empresa/documentos/centroCustos/' . $alvaraCentro;
        }
        if ($data->file_nif) {
            $nifCentro = Str::after($data->file_nif, '/documentos/empresa/documentos/');
            $nifCentro = 'documentos/empresa/documentos/centroCustos/' . $nifCentro;
        }

        return DB::table('centro_custos')->insertGetId([
            'uuid' => Str::uuid(),
            'nome' => $data->nome,
            'empresa_id' => $data->empresaClienteId,
            'status_id' => 1, //ativo
            'endereco' => $data->endereco,
            'nif' => $data->nif,
            'cidade' => $data->cidade,
            'email' => $data->email,
            'website' => $data->website,
            'telefone' => $data->pessoal_Contacto,
            'file_alvara' => $alvaraCentro,
            'file_nif' => $nifCentro,
            'logotipo' => $photoNameCentro
        ]);
    }
    public function cadastrarUsuario($data)
    {

        return DB::connection('mysql2')->table('users_cliente')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => $data->nome,
            'username' => $data->nome,
            'password' => Hash::make('mutue123'),
            'tipo_user_id' => 2,
            'status_id' => 1,
            'status_senha_id' => 1,
            'telefone' => $data->pessoal_Contacto,
            'email' => $data->email,
            'canal_id' => 3,
            'empresa_id' => $data->empresaClienteId,
            'foto' => $data->logotipo,
            'remember_token' => $data->remember_token,
        ]);
    }
    public function activarModuloPadraoDocumento($data)
    {
        return DB::connection('mysql2')->table('modelo_documento_ativo')->insert([
            'modelo_id' => 2,
            'empresa_id' =>  $data->empresaClienteId
        ]);
    }
    public function AtribuirPerfilSuperAdminNoUtilizador($userId)
    {
        return DB::table('user_perfil')->insert([
            'user_id' => $userId,
            'perfil_id' => 1
        ]);
    }

    public function getNumerosDiasLicencaGratis()
    {
        return DB::connection('mysql')->table('parametros')->where('id', 1)->first();
    }
    public function ativarLicencaGratisEmpresa($data)
    {
        return DB::connection('mysql')->table('activacao_licencas')->insertGetId([

            'licenca_id' => 1,
            'empresa_id' => $data->empresaAdminId,
            'data_inicio' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_activacao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_fim' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->addDay(31),
            'canal_id' => 2,
            'status_licenca_id' => 1,
            'observacao' => 'Ativação da licença definitiva',
            'data_notificaticao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))
        ]);
    }

    public function cadastrarArmazemPadrao($data)
    {
        return  DB::connection('mysql2')->table('armazens')->insertGetId([
            'codigo' => mb_strtoupper(Keygen::numeric(9)->generate()),
            'designacao' => "LOJA PRINCIPAL",
            'localizacao' => $data->endereco,
            'status_id' => 1,
            'diversos' => 1,
            'empresa_id' => $data->empresaClienteId
        ]);
    }
    public function cadastrarUnidadeMedidaPadrao($data)
    {
        return DB::connection('mysql2')->table('unidade_medidas')->insertGetId([
            'designacao' => "un",
            'empresa_id' => $data->empresaClienteId,
            'canal_id' => 2, //canal cliente
            'status_id' => 1,
            'diversos' => 1
        ]);
    }
    public function cadastrarFornecedorPadrao($data)
    {

        return DB::connection('mysql2')->table('fornecedores')->insertGetId([
            'nome' => "DIVERSOS",
            'empresa_id' => $data->empresaClienteId,
            'canal_id' => 2, //cliente
            'status_id' => 1, //activo
            'user_id' => $data->userId, //user
            'diversos' => 1,
            'conta_corrente' => $this->buscarUltimaContaCorrente($data),
            'pais_nacionalidade_id' => 1, //Angola
            'tipo_user_id' =>  2
        ]);
    }
    public function cadastrarFabricantePadrao($data)
    {

        return DB::connection('mysql2')->table('fabricantes')->insert([
            'designacao' => "DIVERSOS",
            'empresa_id' => Empresa_Cliente::latest()->first()->id,
            'canal_id' => 2, //cliente
            'user_id' => $data->userId, //user
            'status_id' => 1, //activo
            'diversos' => "Sim",
            'tipo_user_id' =>  2
        ]);
    }
    public function getEmpresaCliente($data)
    {
        return Empresa_Cliente::where('id', $data->empresaClienteId)->first();
    }
    public function cadastrarCliente($data)
    {
        return DB::connection('mysql2')->table('clientes')->insertGetId([
            'nome' => "Consumidor final",
            'nif' => "999999999",
            'canal_id' => 2, //cliente
            'status_id' => 1, //activo
            'diversos' => "Sim",
            'tipo_cliente_id' => $data->tipo_cliente_id,
            'conta_corrente' => $this->buscarUltimaContaCorrente($data),
            'diversos' => "Sim",
            'empresa_id' => $data->empresaClienteId,
            'pais_id' => $data->pais_id,
            'cidade' => $data->cidade
        ]);
    }
    public function buscarUltimaContaCorrente($data, $isFornecedor = false)
    {

        if ($isFornecedor) {
            $tabela = "fornecedores";
        } else {
            $tabela = "clientes";
        }

        $resultado =  DB::connection('mysql2')->table($tabela)
            ->orderBy('id', 'DESC')->where('empresa_id', $data->empresaClienteId)
            ->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->conta_corrente);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string) $ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            if ($isFornecedor) {
                $contaCorrente = "32.1.2.1.1";
            } else {
                $contaCorrente = "31.1.2.1.1";
            }
        }
        return $contaCorrente;
    }
    public function alterarTokenParaUsado($data)
    {
        return DB::connection('mysql')->table('validacao_empresa')
            ->where('token', $data->token)->update([
                'used' => 1
            ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
        $this->removerTokenInvalidos();
        $empresaInfo = $this->getEmpresaTokenValido($request);

        if (!$empresaInfo) {
            if (strpos(url()->current(), "api")) {
                return response()->json('Token está expirado', 401);
            }
            return view('errors.error_tokenExpired');
        }

        $data = $empresaInfo;

        DB::beginTransaction();

        try {

            $data->referencia =  mb_strtoupper(Keygen::alphanum(7)->generate());

            $data->empresaAdminId = $this->cadastrarEmpresaAdmin($data);
            $data->empresaClienteId = $this->cadastrarEmpresaCliente($data);
            $this->cadastrarCentroDeCusto($data);
            $this->activarModuloPadraoDocumento($data);
            $data->userId = $this->cadastrarUsuario($data);
            $this->AtribuirPerfilSuperAdminNoUtilizador($data->userId);
            $data->diasGratis = $this->getNumerosDiasLicencaGratis();
            $this->ativarLicencaGratisEmpresa($data);
            $this->cadastrarArmazemPadrao($data);
            $this->cadastrarUnidadeMedidaPadrao($data);
            $this->cadastrarFornecedorPadrao($data, true);
            $this->cadastrarFabricantePadrao($data);
            $this->cadastrarCliente($data);
            $this->alterarTokenParaUsado($data);

            //INFO PARA ENVIO DE EMAIL
            $infoEmail['nome'] = $data->nome;
            $infoEmail['email'] = $data->email;
            $infoEmail['senha'] = 'mutue123';
            $infoEmail['telefone'] = $data->pessoal_Contacto;
            $infoEmail['linkLogin'] = getenv('APP_URL');
            $infoEmail['pessoal_Contacto'] = $data->pessoal_Contacto;
            //$infoEmail['empresa_id'] = $empresaId;

            //FIM ENVIO EMAIL
            //  $empresaAdmin = Empresa::where('id', $empresaAdminId)->first();

            // $empresaAdmin->notify(new CadastroEmpresaNotificacao($infoEmail));

            JobCadastroEmpresaNotificacao::dispatch($infoEmail)->delay(now()->addSecond('5'));


            if (strpos(url()->current(), "api")) {
                return response()->json([
                    'nome' => $data->nome,
                    'email' => $data->email,
                    'senha' => 'mutue123',
                ], 200);
            }

            DB::commit();

            if ($request->canal == 4 && !strpos(url()->current(), "api")) { //canal mobile e nao for api
                return view("alert.msg_criacao_empresa_mobile");
            }

            // Mail::send(new CadastroEmpresaNotificacao($infoEmail));

            $userCliente = EmpresaUser::find($data->userId);

            event(new Registered($userCliente));

            $this->guard('empresa')->login($userCliente);

            // DB::commit();

            return $this->registered($request, $userCliente)
                ?: redirect($this->redirectPath());
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }
    protected function guard($guard)
    {
        return Auth::guard($guard);
    }
    public function visualizarFichaCadastro($data)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('
        <h4 style="text-align:center">FICHA DE CADASTRAMENTO</h4>
        <strong>Link de acesso: </strong> <a href="">' . env('APP_URL') . 'login</a><br>
        <strong>Email: </strong>' . $data['email'] . '<br>
        <strong>Telefone: </strong> ' . $data['telefone'] . '<br>
        <strong>Senha:</strong> mutue123<br><br>
        <span style="color:red;">OBS:</span><br>
        <span style="color:red;">Caso a palavra passe for diferente de <strong>mutue123</strong> é necessário que o utilizador acesse a tela de login para recuperar a sua senha</span>
        ');
        // (Optional) Setup the paper size and orientation
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('FICHA_CADASTRAMENTO');
    }

    public function cadastrarClienteDiversosContsys($data)
    {
        $subConta = new SubConta();
        $subConta->Numero = $data['Numero'];
        $subConta->Descricao = $data['Descricao'];
        $subConta->CodConta = $data['CodConta'];
        $subConta->CodUtilizador = $data['CodUtilizador'];
        $subConta->DataCadastro = $data['DataCadastro'];
        $subConta->CodTipoConta = $data['CodTipoConta'];
        $subConta->CodEmpresa = $data['CodEmpresa'];
        $subConta->Movimentar = $data['Movimentar'];
        $subConta->codigoCliente = $data['codigoCliente'];
        $subConta->save();

        return response()->json($subConta, 200);
    }

    public function activarLicencaGratis($empresaId, $userId)
    {
        $PORTAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $LICENCA_GRATIS = 1;

        $paramentro = DB::connection('mysql')->table('parametros')->where('id', 1)->first();

        $licencaId = DB::connection('mysql')->table('activacao_licencas')->insertGetId([
            'licenca_id' => $LICENCA_GRATIS,
            'empresa_id' => $empresaId,
            'data_inicio' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_activacao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d')),
            'data_fim' => date('Y-m-d', strtotime("+$paramentro->valor days")),
            'user_id' =>  $userId,
            'canal_id' => $PORTAL_CLIENTE,
            'status_licenca_id' => $STATUS_ATIVO,
            'observacao' => 'Ativação da licença grátis',
            'data_notificaticao' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))

        ]);
        //return response()->json($licencaId, 200);
    }
    public function cadastrarEmpresaContsys($empresa, $data)
    {
        DB::connection('mysql3')->table('empresas')->insertGetId([
            'Nome' => $empresa->nome,
            'Endereco' => $empresa->endereco,
            'Movel' => $empresa->pessoal_Contacto,
            'website' => $data['website'],
            'DataCadastro' => date("Y-m-d"),
            'NIF' => $empresa->nif,
            'referenciaEmpresa' => $empresa->referencia
        ]);
        //  return $empresaId;
    }

    public function cadastrarUtilizadorContsys($empresa, $data, $userId)
    {

        $STATUS_ATIVO = 1;
        $TIPO_USUARIO_ADMIN = 1;

        DB::connection('mysql3')->table('utilizadores')->insertGetId([
            'Nome' => $data['nome'],
            'Username' => $data['nome'],
            'email' => $data['email'],
            'Password' => Hash::make('mutue123'),
            'CodStatus' => $STATUS_ATIVO,
            'CodTipoUser' => $TIPO_USUARIO_ADMIN,
            'empresa_id' => $empresa->id,
            'UserId' => $userId
        ]);
        //return $utilizadorId;
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
            array_push($array, (string) $ultimoElemento);
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
}
