<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\contsys\ReportsController;
use App\Http\Controllers\empresa\ReportsController as ReportsClienteController;
use App\Http\Requests\StoreUpdateClienteFormRequest;
use App\Models\empresa\Cliente;
use App\Models\admin\Empresa;
use App\Models\contsys\SubConta;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaDebito;
use App\Models\empresa\Pais;
use App\Models\empresa\Recibos;
use App\Models\empresa\Statu;
use App\Models\empresa\TiposCliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\empresa\User;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Keygen\Keygen;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

use App\Http\Controllers\empresa\VerificaClienteDocumento;
use App\Models\admin\Pais as AdminPais;
use App\Rules\Empresa\EmpresaUniqueNifDiverso;
use App\Rules\Empresa\MultEmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use DateTime;
use Illuminate\Support\Facades\Date;

class ClienteController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['clientes'] = Cliente::with(['tipocliente', 'pais', 'statuGeral'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = Statu::all();
        $data['paises'] = Pais::all();
        $data['tipos_clientes'] = TiposCliente::all();

        // $data['tipocliente']= DB::table('tipos_clientes')->where('id', 1)->first()->designacao;
        return view('empresa.clientes.index', $data);
    }

    public function pegarClienteDiverso(){

        $cliente = Cliente::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'asc')->first();
        return response()->json($cliente->id, 200);

    }
    public function listarClientesInputFactura(){

        $cliente = Cliente::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'asc')->get();
        return response()->json($cliente, 200);
    }

    //usado no vue para listar clientes
    public function listarClientes()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        //Pega o cliente diversos
        $cliente = Cliente::where('empresa_id', $empresa_id)->orderBy('id', 'asc')->first();


        $clientes = Cliente::where('id', '!=', $cliente->id)->distinct()->where('empresa_id', $empresa_id)->get();

        // print_r($clientes);
        return response()->json($clientes, 200);
    }

    public function pegarDependencias()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }
        $data['gestores'] = DB::connection('mysql2')->table('gestor_clientes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('nome', 'ASC')->get();
        $data['fabricantes'] = DB::connection('mysql2')->table('fabricantes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['status_gerais'] = DB::connection('mysql2')->table('status_gerais')->orderBy('designacao', 'ASC')->get();
        $data['tipos_stocagens'] = DB::connection('mysql2')->table('tipos_stocagens')->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['armazens'] = DB::connection('mysql2')->table('armazens')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['classes'] = DB::connection('mysql2')->table('classes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['categorias'] = DB::connection('mysql2')->table('categorias')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['marcas'] = DB::connection('mysql2')->table('marcas')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['unidade_medidas'] = DB::connection('mysql2')->table('unidade_medidas')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();

        return Response()->json($data);
    }

    public function listarClienteFiltro($status_id, $pais_id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        //Fazer bem a consulta
        $clientes = Cliente::where('empresa_id', $empresa_id)->where('status_id', $status_id)->where('pais_id', $pais_id)->get();
        return response()->json($clientes, 200);

        $pdf = PDF::loadView('pdf.relatorios.lista_clientes', $clientes)->setPaper('a4', 'portrait');
        return $pdf->stream('factura.pdf');
    }


    public function imprimirClienteFiltro()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        //Fazer bem a consulta
        // $data = Cliente::where('empresa_id', $empresa_id)->where('status_id',$status_id)->where('pais_id', $pais_id)->get();

        return view('pdf.relatorios.lista_clientes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $tipoClientes = TiposCliente::all();

        return view('empresa.clientes.create', compact(['tipoClientes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $STATUS_ATIVO = 1;

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $telefone_cliente = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_cliente);

        $data = $request->data_contrato;
        $data_contrato = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');

        $message = [
            'nif.required' => 'É obrigatório o nif',
            'nome.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'email.unique' => 'E-mail já cadastrado',
            'telefone_cliente.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'telefone_cliente.unique' => 'O telefone deste cliente já foi cadastrado',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo nacionalidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo cliente',
            'pessoa_contacto.required' => 'É obrigatório a indicação de um valor para o campo pessoa de contacto',
            'data_contrato.required' => 'É obrigatório a indicação de um valor para o campo data contrato',
        ];

        $validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'email' => [new EmpresaUnique('clientes', 'mysql2')],
            'telefone_cliente' => ['required', new EmpresaUnique('clientes', 'mysql2')],
            'nif' => ['required', new EmpresaUnique('clientes', 'mysql2', 'nif', '999999999')],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'pais_id' => ['required'],
            'tipo_cliente_id' => ['required'],
            'pessoa_contacto' => ['required'],
            'data_contrato' => ['required']
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        $empresaContsysId = $this->buscarEmpresaContsysId($empresa);
        $contaCorrente = $this->buscarContaCorrente($empresaContsysId);

        $tipoContaCorrente = "Nacional";
        DB::beginTransaction();
        try {

            $clienteId = DB::connection('mysql2')->table('clientes')
                ->where('empresa_id', $empresa['id'])->insertGetId([

                    'nome' => $request->nome,
                    'pessoa_contacto' => $request->pessoa_contacto,
                    'endereco' => $request->endereco,
                    'email' => $request->email,
                    'website' => $request->website,
                    'cidade' => $request->cidade,
                    'gestor_id' => $request->gestor_id,
                    'canal_id' => $request->canal_id ? $request->canal_id : 2,
                    'status_id' => $STATUS_ATIVO,
                    'pais_id' => $request->pais_id,
                    'nif' => $request->nif ? $request->nif : "999999999",
                    'tipo_cliente_id' => $request->tipo_cliente_id,
                    'empresa_id' => $empresa->id,
                    'user_id' => Auth::user()->id,
                    'telefone_cliente' => $telefone_cliente,
                    'numero_contrato' => $request->numero_contrato,
                    'data_contrato' => $data_contrato,
                    'tipo_conta_corrente' => $tipoContaCorrente,
                    'conta_corrente' => $contaCorrente,
                    'taxa_de_desconto' => $request->taxa_de_desconto,
                    'limite_de_credito' => $request->limite_de_credito,

                ]);

            //criar Subconta contsys
            $CONTA_ATIVO = 3;
            $CONTA_CLIENTE = 16;

            DB::connection('mysql3')->table('subcontas')->insertGetId([

                'Numero' => $contaCorrente,
                'Descricao' => $request->nome,
                'CodConta' => $CONTA_CLIENTE,
                'CodUtilizador' => 1, //admin
                'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'CodTipoConta' => $CONTA_ATIVO,
                'CodEmpresa' => $empresaContsysId,
                'Movimentar' => "SIM",
                'codigoCliente' => $clienteId

            ]);
            DB::commit();

            if ($clienteId) {
                return response()->json($clienteId, 200);
            }
            return response()->json(['error', 'erro ao cadastrar'], 422);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }
    public function buscarContaCorrente($empresaId)
    {
        $CONTA_CLIENTE = 16;
        $resultado =  DB::connection('mysql3')->table('subcontas')->orderBy('Codigo', 'DESC')
            ->where('CodConta', $CONTA_CLIENTE)
            ->where('CodEmpresa', $empresaId)->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->Numero);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string)$ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            $contaCorrente = "31.1.2.1.1";
        }

        return $contaCorrente;
    }

    public function buscarEmpresaContsysId($empresa)
    {
        return DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first()->Codigo;
    }

    public function cadastrarSubContaContsys($data)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($query)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        //Pega o cliente diversos
        $cliente = Cliente::where('empresa_id', $empresa_id)->orderBy('id', 'asc')->first();

        //  $data = DB::select('SELECT  DISTINCT clientes.nome FROM clientes INNER JOIN facturas ON facturas.cliente_id = clientes.id  WHERE clientes.id != "'.$cliente->id.'" AND clientes.empresa_id = "' . $empresa_id . '"');

        $data = Factura::with(['cliente'])->distinct('clientes.cliente_id')->where('tipo_documento', 2)->where('empresa_id', $empresa_id)->where('cliente_id', '!=', $cliente->id)->where('nome_do_cliente', 'like', '%' . $query . '%')->orWhere('nif_cliente', 'like', '%' . $query . '%')->get();

        //$data = Cliente::with(['facturas'])->where('nome', 'like', '%' . $query . '%')->where('empresa_id', $empresa_id)->get();

        return response()->json($data);
    }

    public function detalhes($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $id = base64_decode($id);
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $cliente = Cliente::where('id', $id)->where('empresa_id', $empresa_id)->first();

        if (!$cliente) {
            return redirect()->back();
        }

        $data['cliente'] = Cliente::findOrfail($cliente->id);
        return view('empresa.clientes.detalhes', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        $id = base64_decode($id);

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $cliente = Cliente::where('id', $id)->where('empresa_id', $empresa_id)->first();

        if (!$cliente) {
            return redirect()->back();
        }

        $data['cliente'] = Cliente::findOrfail($cliente->id);
        $data['status'] = Statu::all();
        $data['paises'] = Pais::all();
        $data['tipos_clientes'] = TiposCliente::all();

        return view('empresa.clientes.edit', $data);
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

        $telefone_cliente = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_cliente);


        // dd($request->all());

        // $data_contrato = date_format(date_create($request->data_contrato), 'Y-m-d');

        $message = [
            'nif.required' => 'É obrigatório o nif',
            'nome.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
            'telefone_cliente.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'telefone_cliente.unique' => 'O telefone deste cliente já foi cadastrado',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo nacionalidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo cliente',
            'pessoa_contacto.required' => 'É obrigatório a indicação de um valor para o campo pessoa de contacto',
            'data_contrato.required' => 'É obrigatório a indicação de um valor para o campo data contrato',
        ];



        $validator = Validator::make($request->all(), [

            'nome' => ['required', function ($attribute, $value, $fail) use ($id) {


                // Documento como:facturas e notas de credito
                $vericaClienteTemDocumento = new VerificaClienteDocumento($id);
                $cliente = $vericaClienteTemDocumento->pegarDadosCliente();

                if ($value == $cliente->nome) {
                } else {

                    if ($cliente->nif == "999999999" && $vericaClienteTemDocumento->temDocumento($attribute)) {
                        $fail('O ' . $attribute . ' não pode ser alterado, cliente contem documento e nif genérico');
                    }
                }
            }],
            'email' => ['required', new EmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'telefone_cliente' => ['required', new EmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'nif' => [function ($attribute, $value, $fail) use ($id) {

                // Documento como:facturas e notas de credito
                $vericaClienteTemDocumento = new VerificaClienteDocumento($id);
                $nifCliente = $vericaClienteTemDocumento->pegarDadosCliente();


                if ($value == $nifCliente->nif) {
                } else {

                    $value = $value ? $value : "999999999";

                    if ($nifCliente->nif == "999999999" && $value != "999999999") {

                        $empresaUnica = new EmpresaUnique('clientes', 'mysql2', 'id', $id);
                        $result = $empresaUnica->passes($attribute, $value);

                        if (!$result) {
                            $fail('O ' . $attribute . ' já se encontra registrado');
                        }
                    }
                    if ($nifCliente->nif != "999999999") {
                        if ($vericaClienteTemDocumento->temDocumento($attribute)) {
                            $fail('O ' . $attribute . ' não pode ser alterado contém documentos');
                        } else {

                            $empresaUnica = new EmpresaUnique('clientes', 'mysql2', 'id', $id);
                            $result = $empresaUnica->passes($attribute, $value);

                            if (!$result && $value != "999999999") {
                                $fail('O ' . $attribute . ' já se encontra registrado');
                            }
                        }
                    }
                }
            }],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'pais_id' => ['required'],
            'tipo_cliente_id' => ['required'],
            'nif' => ['required', new EmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'pessoa_contacto' => ['required'],
            'conta_corrente' => ['required', new EmpresaUnique('clientes', 'mysql2', 'id', $id)],
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $tipoContaCorrente = "Nacional";

        DB::beginTransaction();
        // try {

            $clienteId = DB::connection('mysql2')->table('clientes')
                ->where('empresa_id', $empresa['id'])
                ->where('id', $id)
                ->update([
                    'nome' => $request->nome,
                    'pessoa_contacto' => $request->pessoa_contacto,
                    'endereco' => $request->endereco,
                    'email' => $request->email,
                    'website' => $request->website,
                    'cidade' => $request->cidade,
                    'gestor_id' => $request->gestor_id,
                    'canal_id' => 2,
                    'status_id' => 1,
                    'pais_id' => $request->pais_id,
                    'nif' => $request->nif,
                    'tipo_cliente_id' => $request->tipo_cliente_id,
                    'empresa_id' => $empresa->id,
                    'user_id' => Auth::user()->id,
                    'telefone_cliente' => $telefone_cliente,
                    'numero_contrato' => $request->numero_contrato,
                    // 'data_contrato' => $data_contrato,
                    'tipo_conta_corrente' => $tipoContaCorrente,
                    'conta_corrente' => $request->conta_corrente,
                    'taxa_de_desconto' => $request->taxa_de_desconto,
                    'limite_de_credito' => $request->limite_de_credito,

                ]);

            $empresaContsysId = $this->buscarEmpresaContsysId($empresa);

            DB::connection('mysql3')->table('subcontas')
                ->where('codigoCliente', $id)
                ->where('CodEmpresa', $empresaContsysId)
                ->update([
                    'Descricao' => $request->nome
                ]);
            DB::commit();


            return response()->json($id, 200);
            //code...
        // } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json('Erro ao editar cliente', 422);
        // }
    }

    public function updateClienteContsys($request, $empresaContsysId, $codigoCliente)
    {
        $subConta = SubConta::where('codigoCliente', $codigoCliente)->where('CodEmpresa', $empresaContsysId)->first();
        $subConta->Descricao = $request->nome;
        $subConta->save();

        return response()->json($subConta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $cliente = Cliente::where('empresa_id', $empresa['empresa']['id'])->find($id);
        $cliente->delete();

        if ($cliente) {
            $empresaContsysId = $this->buscarEmpresaContsysId($empresa['empresa']);
            $this->deletarClienteContsys($empresaContsysId, $id);
            return response()->json($cliente, 200);
        } else {
            return response()->json("Não é possível eliminar o Cliente Que já emitiu documentos", 500);
        }
    }
    public function deletarClienteContsys($empresaContsysId, $clienteId)
    {
        $subConta = SubConta::where('codigoCliente', $clienteId)->where('CodEmpresa', $empresaContsysId)->first();
        $subConta->delete();
    }

    public function PegarSaldoClientePorContaCorrente($conta_corrente)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $totalNotaCredito  = NotaCredito::where('conta_corrente_cliente', $conta_corrente)->where('empresa_id', $empresa_id)->sum('valor_credito');
        $totalNotaDebito  = NotaDebito::where('conta_corrente_cliente', $conta_corrente)->where('empresa_id', $empresa_id)->sum('valor_debito');
        $totalRecibos  = Recibos::where('conta_corrente_cliente', $conta_corrente)->where('empresa_id', $empresa_id)->where('anulado', 1)->sum('valor_total_entregue');
        $totalFacturas  = Factura::where('conta_corrente_cliente', $conta_corrente)->where('tipo_documento', 2)->where('anulado', 1)->where('empresa_id', $empresa_id)->sum('valor_a_pagar');


        //  dd((($totalNotaCredito + $totalRecibos) - ($totalNotaDebito + $totalFacturas)));

        $saldoCliente = (($totalNotaCredito + $totalRecibos) - ($totalNotaDebito + $totalFacturas));

        return $saldoCliente;
    }

    public function PegarSaldoCliente($idCliente)
    {


        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }


        $totalNotaCredito  = NotaCredito::where('cliente_id', $idCliente)->where('empresa_id', $empresa_id)->sum('valor_credito');
        $totalNotaDebito  = NotaDebito::where('cliente_id', $idCliente)->where('empresa_id', $empresa_id)->sum('valor_debito');
        $totalRecibos  = Recibos::where('cliente_id', $idCliente)->where('empresa_id', $empresa_id)->where('anulado', 1)->sum('valor_total_entregue');
        $totalFacturas  = Factura::where('cliente_id', $idCliente)->where('tipo_documento', 2)->where('anulado', 1)->where('empresa_id', $empresa_id)->sum('valor_a_pagar');


        //  dd((($totalNotaCredito + $totalRecibos) - ($totalNotaDebito + $totalFacturas)));

        $saldoCliente = (($totalNotaCredito + $totalRecibos) - ($totalNotaDebito + $totalFacturas));

        return response()->json(number_format($saldoCliente, 2, ',', '.'));
    }

    public function listarClienteApi()
    {

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        //Pega o cliente diversos
        // $cliente = Cliente::where('empresa_id', $empresa_id)->orderBy('id', 'asc')->first();


        // $clientes = Cliente::where('id', '!=', $cliente->id)->distinct()->where('empresa_id', $empresa_id)->get();
        $clientes = Cliente::distinct()->where('empresa_id', $empresa_id)->get();

        // print_r($clientes);
        return response()->json($clientes, 200);
    }
    public function listarClientesApi()
    {

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }
        $clientes = Cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])->where("diversos", '!=', "Sim")->where('empresa_id', $empresa_id)->get();
        return response()->json($clientes, 200);
    }
    public function ApiListaCliente($clienteId)
    {

        if (Auth::guard('WebApi')->check()) {
            if ((Auth::guard('WebApi')->user()->tipo_user_id) == 1) {
                return response()->json(['message' => 'Usuário não permitido']);
            }
        }

        if (Auth::guard('WebApi')->check()) {

            $referencia = Empresa::where('user_id', auth('WebApi')->user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $clientes = Cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])
            ->where("diversos", '!=', "Sim")
            ->where("id", $clienteId)
            ->where('empresa_id', $empresa_id)
            ->get();
        return response()->json($clientes, 200);
    }
    public function listarPaisesApi()
    {

        $paises = AdminPais::get();
        return response()->json($paises, 200);
    }
    public function listarTipoClienteApi()
    {

        $tipoClientes = DB::connection('mysql2')->table('tipos_clientes')->get();
        return response()->json($tipoClientes, 200);
    }
    public function imprimirClientes()
    {



        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $clientes_status = Cliente::where('empresa_id', $empresa['empresa']['id'])->where('status_id', $status_id)->get();

            if (count($clientes_status) == 0) {
                $status_id = $todosStatus;
            }
        }


        if ($status_id == 3) {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%"]; //parametros where do report
        } else {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%" . $status_id]; //parametros where do report
        }

        $reportController = new ReportsClienteController();
        return $reportController->show(
            [
                'report_file' => 'clientes',
                'report_jrxml' => 'clientes.jrxml',
                'report_parameters' => $options
            ]
        );
    }



    public function imprimirExtratoConta(Request $request)
    {



        $dataInicial = date_format(date_create($request->dataInicial), 'Y-m-d');
        $dataFinal = date_format(date_create($request->dataFinal), 'Y-m-d');


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['empresa']['referencia'])->first();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $saldoCliente = $this->PegarSaldoClientePorContaCorrente($request->conta_corrente);



        $totalDebito = DB::connection('mysql3')->table('movimentos')
            ->join('movimentos_item', 'movimentos.Codigo', '=', 'movimentos_item.CodigoMovimento')
            ->join('subcontas', 'subcontas.Codigo', '=', 'movimentos_item.CodigoConta')
            ->where('movimentos_item.CodigoTipoMovimento', 1)
            ->where('movimentos.CodEmpresa', $empresaContsys->Codigo)
            ->where('subcontas.Numero', $request->conta_corrente)
            ->where('subcontas.codigoCliente', $request->id)
            ->whereDate('movimentos.DataMovimento', '>=', $dataInicial)
            ->whereDate('movimentos.DataMovimento', '<=', $dataFinal)
            ->sum('movimentos_item.Valor');



        $totalCredito = DB::connection('mysql3')->table('movimentos')
            ->join('movimentos_item', 'movimentos.Codigo', '=', 'movimentos_item.CodigoMovimento')
            ->join('subcontas', 'subcontas.Codigo', '=', 'movimentos_item.CodigoConta')
            ->where('movimentos_item.CodigoTipoMovimento', 2)
            ->where('movimentos.CodEmpresa', $empresaContsys->Codigo)
            ->where('subcontas.Numero', $request->conta_corrente)
            ->where('subcontas.codigoCliente', $request->id)
            ->whereDate('movimentos.DataMovimento', '>=', $dataInicial)
            ->whereDate('movimentos.DataMovimento', '<=', $dataFinal)
            ->sum('movimentos_item.Valor');



        // if ($totalCredito && $totalDebito) {
        //     throw ("error");
        // }



        $reportController = new ReportsController();

        return $reportController->show(
            [
                'report_file' => 'extrato_conta',
                'report_jrxml' => 'extrato_conta.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $caminho,
                    "empresa_id" =>  $empresaContsys->Codigo,
                    "conta_corrente" => $request->conta_corrente,
                    "dataInicial" => $dataInicial,
                    "dataFinal" => $dataFinal,
                    "saldoCliente" => $saldoCliente,
                    "cliente_id" => $request->id,
                    "totalCredito" => $totalCredito,
                    "totalDebito" => $totalDebito
                ]
            ]
        );
    }

    public function storeApi(Request $request)
    {
        $STATUS_ATIVO = 1;

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }

        $telefone_cliente = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_cliente);

        $data_contrato = date_format(date_create($request->data_contrato), 'Y-m-d');


        $message = [
            'nome.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
            'telefone_cliente.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'telefone_cliente.unique' => 'O telefone deste cliente já foi cadastrado',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo nacionalidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo cliente',
            'pessoa_contacto.required' => 'É obrigatório a indicação de um valor para o campo pessoa de contacto',
            'data_contrato.required' => 'É obrigatório a indicação de um valor para o campo data contrato',
        ];

        $validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'email' => ['required', new MultEmpresaUnique('clientes', 'mysql2')],
            'telefone_cliente' => ['required', new MultEmpresaUnique('clientes', 'mysql2')],
            'nif' => [new MultEmpresaUnique('clientes', 'mysql2', 'nif', '999999999')],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'pais_id' => ['required'],
            'tipo_cliente_id' => ['required'],
            'pessoa_contacto' => ['required'],
            'data_contrato' => ['required']
        ], $message);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $empresaContsysId = $this->buscarEmpresaContsysId($empresa);
        $contaCorrente = $this->buscarContaCorrente($empresaContsysId);

        $tipoContaCorrente = "Nacional";
        DB::beginTransaction();
        try {

            $clienteId = DB::connection('mysql2')->table('clientes')
                ->where('empresa_id', $empresa['id'])->insertGetId([

                    'nome' => $request->nome,
                    'pessoa_contacto' => $request->pessoa_contacto,
                    'endereco' => $request->endereco,
                    'email' => $request->email,
                    'website' => $request->website,
                    'cidade' => $request->cidade,
                    'gestor_id' => $request->gestor_id,
                    'canal_id' => $request->canal_id ? $request->canal_id : 2,
                    'status_id' => $STATUS_ATIVO,
                    'pais_id' => $request->pais_id,
                    'nif' => $request->nif ? $request->nif : "999999999",
                    'tipo_cliente_id' => $request->tipo_cliente_id,
                    'empresa_id' => $empresa->id,
                    'user_id' => auth('EmpresaApi')->user()->id,
                    'telefone_cliente' => $telefone_cliente,
                    'numero_contrato' => $request->numero_contrato,
                    'data_contrato' => $data_contrato,
                    'tipo_conta_corrente' => $tipoContaCorrente,
                    'conta_corrente' => $contaCorrente,
                    'taxa_de_desconto' => $request->taxa_de_desconto,
                    'limite_de_credito' => $request->limite_de_credito,

                ]);

            //criar Subconta contsys
            $CONTA_ATIVO = 3;
            $CONTA_CLIENTE = 16;

            DB::connection('mysql3')->table('subcontas')->insertGetId([

                'Numero' => $contaCorrente,
                'Descricao' => $request->nome,
                'CodConta' => $CONTA_CLIENTE,
                'CodUtilizador' => 1, //admin
                'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'CodTipoConta' => $CONTA_ATIVO,
                'CodEmpresa' => $empresaContsysId,
                'Movimentar' => "SIM",
                'codigoCliente' => $clienteId

            ]);
            DB::commit();

            if ($clienteId) {
                return response()->json($clienteId, 200);
            }
            //return response()->json(['error', 'erro ao cadastrar'], 422);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['error', 'erro ao cadastrar'], 422);
        }
    }

    public function updateApi(Request $request, $id)
    {
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }

        $telefone_cliente = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_cliente);

        $data_contrato = date_format(date_create($request->data_contrato), 'Y-m-d');

        $message = [
            'nome.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
            'telefone_cliente.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'telefone_cliente.unique' => 'O telefone deste cliente já foi cadastrado',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo nacionalidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo cliente',
            'pessoa_contacto.required' => 'É obrigatório a indicação de um valor para o campo pessoa de contacto',
            'data_contrato.required' => 'É obrigatório a indicação de um valor para o campo data contrato',
        ];



        $validator = Validator::make($request->all(), [

            'nome' => ['required', function ($attribute, $value, $fail) use ($id, $empresa_id) {


                // Documento como:facturas e notas de credito
                // $vericaClienteTemDocumento = new VerificaClienteDocumento($id);
                $cliente = DB::connection('mysql2')->table('clientes')->where('empresa_id', $empresa_id)->where('id', $id)->first();

                if ($value == $cliente->nome) {
                } else {

                    if ($cliente->nif == "999999999" && $this->clientHasDocument($id)) {
                        $fail('O ' . $attribute . ' não pode ser alterado, cliente contem documento e nif genérico');
                    }
                }
            }],
            'email' => ['required', new MultEmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'telefone_cliente' => ['required', new MultEmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'nif' => [function ($attribute, $value, $fail) use ($id, $empresa_id) {


                $nifCliente = DB::connection('mysql2')->table('clientes')->where('empresa_id', $empresa_id)->where('id', $id)->first();


                // // Documento como:facturas e notas de credito
                // $vericaClienteTemDocumento = new VerificaClienteDocumento($id);
                // $nifCliente = $vericaClienteTemDocumento->pegarDadosCliente();


                if ($value == $nifCliente->nif) {
                } else {

                    $value = $value ? $value : "999999999";

                    if ($nifCliente->nif == "999999999" && $value != "999999999") {

                        $empresaUnica = new MultEmpresaUnique('clientes', 'mysql2', 'id', $id);
                        $result = $empresaUnica->passes($attribute, $value);

                        if (!$result) {
                            $fail('O ' . $attribute . ' já se encontra registrado');
                        }
                    }
                    if ($nifCliente->nif != "999999999") {
                        if ($this->clientHasDocument($id)) {
                            $fail('O ' . $attribute . ' não pode ser alterado contém documentos');
                        } else {

                            $empresaUnica = new MultEmpresaUnique('clientes', 'mysql2', 'id', $id);
                            $result = $empresaUnica->passes($attribute, $value);

                            if (!$result && $value != "999999999") {
                                $fail('O ' . $attribute . ' já se encontra registrado');
                            }
                        }
                    }
                }
            }],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'pais_id' => ['required'],
            'tipo_cliente_id' => ['required'],
            'pessoa_contacto' => ['required'],
            'conta_corrente' => ['required', new MultEmpresaUnique('clientes', 'mysql2', 'id', $id)],
            'data_contrato' => ['required']
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $tipoContaCorrente = "Nacional";

        DB::beginTransaction();
        try {

            $clienteId = DB::connection('mysql2')->table('clientes')
                ->where('empresa_id', $empresa['id'])
                ->where('id', $id)
                ->update([
                    'nome' => $request->nome,
                    'pessoa_contacto' => $request->pessoa_contacto,
                    'endereco' => $request->endereco,
                    'email' => $request->email,
                    'website' => $request->website,
                    'cidade' => $request->cidade,
                    'gestor_id' => $request->gestor_id,
                    'canal_id' => 2,
                    'status_id' => 1,
                    'pais_id' => $request->pais_id,
                    'nif' => $request->nif,
                    'tipo_cliente_id' => $request->tipo_cliente_id,
                    'empresa_id' => $empresa->id,
                    'user_id' => auth('EmpresaApi')->user()->id,
                    'telefone_cliente' => $telefone_cliente,
                    'numero_contrato' => $request->numero_contrato,
                    'data_contrato' => $data_contrato,
                    'tipo_conta_corrente' => $tipoContaCorrente,
                    'conta_corrente' => $request->conta_corrente,
                    'taxa_de_desconto' => $request->taxa_de_desconto,
                    'limite_de_credito' => $request->limite_de_credito,

                ]);

            $empresaContsysId = $this->buscarEmpresaContsysId($empresa);

            DB::connection('mysql3')->table('subcontas')
                ->where('codigoCliente', $id)
                ->where('CodEmpresa', $empresaContsysId)
                ->update([
                    'Descricao' => $request->nome
                ]);
            DB::commit();


            return response()->json($id, 200);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json('Erro ao editar cliente', 422);
        }
    }

    public function clientHasDocument($clienteId)
    {

        //hasfactura
        $clientes =  DB::connection('mysql2')->table('facturas')
            ->where('empresa_id', auth('EmpresaApi')->user()->empresa_id)
            ->where('cliente_id', $clienteId)->get();

        //hasRecibo
        $recibos =  DB::connection('mysql2')->table('recibos')
            ->where('empresa_id', auth('EmpresaApi')->user()->empresa_id)
            ->where('cliente_id', $clienteId)
            ->get();

        //hasNotaCredito
        $notaCredito = DB::connection('mysql2')->table('notas_credito')
            ->where('empresa_id', auth('EmpresaApi')->user()->empresa_id)
            ->where('cliente_id', $clienteId)
            ->get();

        if (count($clientes) > 0 || count($recibos) > 0 || count($notaCredito) > 0) {
            return true;
        }
        return false;
    }
}
