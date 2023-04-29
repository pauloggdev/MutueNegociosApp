<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Mail\CadastroEmpresaNotificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\User;
use App\Models\empresa\Pais;
use App\Notifications\CadastroEmpresaNotificacao as NotificationsCadastroEmpresaNotificacao;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\Validator;
use Keygen\Keygen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];
        $data['empresa'] = $empresa['empresa'];
        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        $data['tipoRegime'] = DB::connection('mysql')->table('tipos_regimes')->get();
        $data['paises'] = Pais::all();

        return view('empresa.configuracoes.editarEmpresa', $data);
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

        $message = [
            'nome.required' => 'É obrigatório a indicação de um valor para o campo nome',
            'nif.required' => 'É obrigatório a indicação de um valor para o campo nif',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo país',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de cliente',
            'tipo_regime_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de regime',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
            'pessoal_Contacto.required' => 'É obrigatório a indicação de um valor para o campo contacto telefonico',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
        ];

        $this->validate($request, [

            'nome' => ['required'],
            'nif' => ['required'],
            'pais_id' => ['required'],
            'cidade' => ['required'],
            'tipo_cliente_id' => ['required'],
            'tipo_regime_id' => ['required'],
            'endereco' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) use ($id) {
                $empresa = DB::connection('mysql2')->table('empresas')
                    ->where('email', $value)->first();
                if ($empresa && $empresa->id != $id) {
                    $fail('O ' . $attribute . ' já se encontra cadastrado');
                }
            }],
            'pessoal_Contacto' => [
                'required', 'digits:9', function ($attribute, $value, $fail) use ($id) {
                    $empresa = DB::connection('mysql2')->table('empresas')
                        ->where('pessoal_Contacto', $value)->first();
                    if ($empresa && $empresa->id != $id) {
                        $fail('O contacto telefone já se encontra cadastrado');
                    }
                }
            ],
            'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ], $message);

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //Logotipo
        $photoName = $empresa['empresa']['logotipo'];
        if ($request->hasFile('logotipo') && $request->logotipo->isValid()) {

            // dd($empresa['empresa']);
            if ($empresa['empresa']['logotipo'] != "utilizadores/cliente/avatarEmpresa.png") {
                if (Storage::exists($empresa['empresa']['logotipo'])) {
                    Storage::delete($empresa['empresa']['logotipo']);
                }
                $photoName = $request->logotipo->store("/utilizadores/cliente");
            }
        }

        //Alvará
        $file_alvara = $empresa['empresa']['file_alvara'];
        if ($request->hasFile('file_alvara') && $request->file_alvara->isValid()) {
            if (Storage::exists($empresa['empresa']['file_alvara'])) {
                Storage::delete($empresa['empresa']['file_alvara']);
            }
            $file_alvara = $request->file_alvara->store("/documentos/empresa/documentos");
        }
        //NIF
        $file_nif = $empresa['empresa']['file_nif'];
        if ($request->hasFile('file_nif') && $request->file_nif->isValid()) {
            if (Storage::exists($empresa['empresa']['file_nif'])) {
                Storage::delete($empresa['empresa']['file_nif']);
            }
            $file_nif = $request->file_nif->store("/documentos/empresa/documentos");
        }

        DB::beginTransaction();

        try {

            DB::connection('mysql2')->table('empresas')->where('id', $id)->update([
                'nome' => $request->nome,
                'pessoal_Contacto' => $request->pessoal_Contacto,
                'telefone1' => $request->telefone1,
                'telefone2' => $request->telefone2,
                'endereco' => $request->endereco,
                'pais_id' => $request->pais_id,
                'status_id' => 1,
                'nif' => $request->nif,
                'tipo_cliente_id' => $request->tipo_cliente_id,
                'tipo_regime_id' => $request->tipo_regime_id,
                'logotipo' => $photoName,
                'website' => $request->website,
                'email' => $request->email,
                'file_alvara' => $file_alvara,
                'file_nif' => $file_nif,
                'cidade' => $request->cidade,
            ]);

            //actualizar empresa admin
            DB::connection('mysql')->table('empresas')->where('referencia', $empresa['empresa']['referencia'])->update([
                'nome' => $request->nome,
                'pessoal_Contacto' => $request->pessoal_Contacto,
                'endereco' => $request->endereco,
                'pais_id' => $request->pais_id,
                'status_id' => 1,
                'nif' => $request->nif,
                'tipo_cliente_id' => $request->tipo_cliente_id,
                'tipo_regime_id' => $request->tipo_regime_id,
                'logotipo' => $photoName,
                'website' => $request->website,
                'email' => $request->email,
                'file_alvara' => $file_alvara,
                'file_nif' => $file_nif,
                'cidade' => $request->cidade,
            ]);

            //

            if ($request->tipo_regime_id == 2) { //Regime simplificado
                $motivoIsencaoId = 9; //MM0
                DB::connection('mysql2')->table('produtos')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->update([
                        'codigo_taxa' => 1,
                        'motivo_isencao_id' => $motivoIsencaoId
                    ]);
            } else if ($request->tipo_regime_id == 3) { //Regime de exclusão
                $motivoIsencaoId = 7; //M04
                DB::connection('mysql2')->table('produtos')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->update([
                        'codigo_taxa' => 1,
                        'motivo_isencao_id' => $motivoIsencaoId
                    ]);
            } else if ($request->tipo_regime_id == 1) { //Regime geral
                $motivoIsencaoId = 8; //M02
                DB::connection('mysql2')->table('produtos')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->update([
                        'motivo_isencao_id' => $motivoIsencaoId
                    ]);
            }

            DB::commit();
            return redirect()->route('empresa.edit')->withSuccess('Operação efectuada com Sucesso!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('empresa.edit')->withErrors('Erro ao actualizar a empresa');
        }
    }

    public function alterarLogotipo(Request $request, $id)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $photoName = "";

        if (isset($request['logotipo']) && !empty($request['logotipo'])) {
            //remove foto anterior
            if ($empresa['empresa']['logotipo'] && $empresa['empresa']['logotipo'] != "utilizadores/cliente/avatarEmpresa.png") {

                try {
                    unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $empresa['empresa']['logotipo']);
                    $photoName = $request['logotipo']->store('/utilizadores/cliente');
                } catch (\ErrorException $th) {
                    $photoName = $request->logotipo->store('/utilizadores/cliente');
                }
            } else {
                $photoName = $request->logotipo->store('/utilizadores/cliente');
            }
        } else {
            $photoName = $empresa['empresa']['logotipo'];
        }

        DB::beginTransaction();

        try {
            DB::connection('mysql2')->table('empresas')->where('id', $id)->update([
                'logotipo' => $photoName
            ]);
            DB::connection('mysql')->table('empresas')->where('referencia', $empresa['empresa']['referencia'])->update([
                'logotipo' => $photoName
            ]);
            DB::commit();
            return redirect()->back()->withSuccess(' Logomarca Alterada com Sucesso!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withErrors('Não foi possível alterar o logotipo');
        }
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



        $data = $request->all();

        $CARTAO_CREDITO = 1;
        $STATUS_ATIVO = 1;
        $CANAL_PORTAL_CLIENTE = 2;
        $CANAL_PORTAL_ADMIN = 3;
        $TIPO_USER_EMPRESA = 2;
        $SENHA_VULNERAVEL = 1;

        $mensagem = [
            'pessoal_Contacto.required' => 'É obrigatória o contacto',
            'pais_id.required' => 'É obrigatória selecionar o país',
            'tipo_cliente_id.required' => 'É obrigatória selecionar o tipo de empresa',
            'tipo_regime_id.required' => 'É obrigatória selecionar o tipo de regime',
        ];

        $validator = Validator::make($data, [
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

            'nome' => ['required', 'string', 'min:3', 'max:255', new EmpresaUnicaAdmin('empresas', 'mysql')],
            'pessoal_Contacto' => ['required', 'string', 'max:9', new EmpresaUnicaAdmin('empresas', 'mysql')],
            'endereco' => ['required', 'string'],
            'cidade' => ['required'],
            'tipo_cliente_id' => ['required', 'numeric'],
            'tipo_regime_id' => ['required', 'numeric'],
            'pais_id' => ['required', 'numeric'],
            'nif' => ['required', 'string', 'max:14', new EmpresaUnicaAdmin('empresas', 'mysql')],
            'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ], $mensagem);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        DB::beginTransaction();

        try {

            if (isset($data['logotipo']) && !empty($data['logotipo'])) {
                $photoName = $data['logotipo']->store('/utilizadores/cliente');
            } else {
                $photoName = NULL;
            }

            $user = User::create([
                'name' => $data['nome'],
                'username' => $data['nome'],
                'password' => Hash::make('mutue123'),
                'tipo_user_id' => $TIPO_USER_EMPRESA,
                'status_id' => $STATUS_ATIVO,
                'status_senha_id' => $SENHA_VULNERAVEL,
                'foto' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
                'telefone' => $data['pessoal_Contacto'],
                'email' => $data['email'],
                'canal_id' => $CANAL_PORTAL_ADMIN,
            ]);


            $user->assignRole('Empresa');

            if (!$user) {
                dd('Não foi possivel registar a empresa');
            } else {


                $referencia = mb_strtoupper(Keygen::alphanum(7)->generate());

                $empresaAdminId = DB::connection('mysql')->table('empresas')->insertGetId([
                    'nome' => $data['nome'],
                    'pessoal_Contacto' => $data['pessoal_Contacto'],
                    'endereco' => $data['endereco'],
                    'pais_id' => $data['pais_id'],
                    'saldo' => 0.00,
                    'user_id' => User::latest()->first()->id,
                    'canal_id' => $CANAL_PORTAL_ADMIN,
                    'status_id' => $STATUS_ATIVO,
                    'nif' => $data['nif'],
                    'gestor_cliente_id' => 1,
                    'tipo_cliente_id' => $data['tipo_cliente_id'],
                    'tipo_regime_id' => $data['tipo_regime_id'],
                    'logotipo' => $photoName ? $photoName : "utilizadores/cliente/avatarEmpresa.png",
                    'website' => $data['website'],
                    'email' => $data['email'],
                    'cidade' => $data['cidade'],
                    'referencia' => $referencia
                ]);

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
                    'cidade' => $data['cidade'],
                    'referencia' => $referencia
                ]);

                $registerController = new RegisterController();
                $registerController->activarLicencaGratis($empresaAdminId, $user->id);

                $ARMAZEM_PRINCIPAL = 1;

                //Cadastra armazem principal
                DB::connection('mysql2')->table('armazens')->insert([
                    'designacao' => "LOJA PRINCIPAL",
                    'localizacao' => $data['endereco'],
                    'status_id' => $STATUS_ATIVO,
                    'diversos' => $ARMAZEM_PRINCIPAL,
                    'empresa_id' => Empresa_Cliente::latest()->first()->id,
                ]);

                // Cadastra unidade medida default
                $UN_DIVERSOS = 1;
                DB::connection('mysql2')->table('unidade_medidas')->insert([
                    'designacao' => "un",
                    'empresa_id' => Empresa_Cliente::latest()->first()->id,
                    'canal_id' => 2, //canal cliente
                    'status_id' => $STATUS_ATIVO,
                    'diversos' => $UN_DIVERSOS
                ]);
                // cadastras  contsys
                $empresa = DB::connection('mysql2')->table('empresas')->where('id', $empresaId)->first();
                $registerController->cadastrarEmpresaContsys($empresa, $data);
                $registerController->cadastrarUtilizadorContsys($empresa, $data, $user->id);

                $CONTA_CLIENTE = 16;

                $empresaContsysId = $registerController->buscarEmpresaContsysId($empresa);
                $contaCorrente = $registerController->buscarContaCorrente($empresaContsysId, $CONTA_CLIENTE);

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
                    'empresa_id' => Empresa_Cliente::latest()->first()->id,
                    'pais_id' => $data['pais_id'],
                    'cidade' => $data['cidade']
                ]);

                //criar Subconta contsys
                $CONTA_ATIVO = 3;
                $CONTA_CLIENTE = 16;
                $CODIGO_ADMIN = 1;

                $registerController->cadastrarClienteDiversosContsys([
                    'Numero' => $contaCorrente,
                    'Descricao' => 'CLIENTE DIVERSOS',
                    'CodConta' => $CONTA_CLIENTE,
                    'CodUtilizador' => $CODIGO_ADMIN,
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
                    'user_id' => $user->id, //user
                    'status_id' => $STATUS_ATIVO, //activo
                    'diversos' => "Sim",
                    'tipo_user_id' =>  $TIPO_EMPRESA
                ]);

                $CONTA_FONECEDOR = 17;
                $FORNECEDOR_DIVERSOS = 1;
                $contaCorrenteFornecedor = $registerController->buscarContaCorrente($empresaContsysId, $CONTA_FONECEDOR);


                //cadastra fornecedor default
                $fornecedorId = DB::connection('mysql2')->table('fornecedores')->insertGetId([
                    'nome' => "DIVERSOS",
                    'empresa_id' => Empresa_Cliente::latest()->first()->id,
                    'canal_id' => $CANAL_PORTAL_CLIENTE, //cliente
                    'status_id' => $STATUS_ATIVO, //activo
                    'user_id' => $user->id, //user
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
                    'CodUtilizador' => $CODIGO_ADMIN,
                    'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                    'CodTipoConta' => $CONTA_ATIVO,
                    'CodEmpresa' => $empresaContsysId,
                    'Movimentar' => "SIM",
                    'codigoFornecedor' => $fornecedorId

                ]);
                DB::commit();
            }
        } catch (\Exception $th) {
            DB::rollBack();
        }

        if ($user) {
            //INFO PARA ENVIO DE EMAIL
            $infoEmail['nome'] = $data['nome'];
            $infoEmail['email'] = $data['email'];
            $infoEmail['senha'] = 'mutue123';
            $infoEmail['linkLogin'] = getenv('APP_URL');
            $infoEmail['pessoal_Contacto'] = $data['pessoal_Contacto'];
            $infoEmail['empresa_id'] = $empresaId;

            //FIM ENVIO EMAIL
            $user->notify(new NotificationsCadastroEmpresaNotificacao($infoEmail));

            return response()->json($user, 200);
        }

        return null;
    }
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
        $diretorio = public_path() . '\\upload\\' . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'listarClientes',
                'report_jrxml' => 'listarClientes.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio
                ]
            ]
        );
    }
}
