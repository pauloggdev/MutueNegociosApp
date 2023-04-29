<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBancoFormRequest;
use App\Models\admin\Empresa;
use App\Models\admin\Motivo_Iva;
use App\Models\admin\Statu;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\TipoMotivoIva;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MotivoIvaController extends Controller
{

    private $admin_system = 1;
    private $empresa_system = 2;
    private $empresa_funcionario = 3;


    public function __construct()
    {
        //$this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['motivos'] = TipoMotivoIva::with('statuGeral')->orWhere('empresa_id', null)->get();
        $data['status'] = Statu::all();
        $data['user'] = (Auth::user());

        $data['guard'] = Auth::guard('web')->user();
        return view('admin.motivos.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $canal_admin = 3;


        $this->validate($request, [
            'codigoMotivo' => ['required', new EmpresaUnicaAdmin('motivo', 'mysql', 'codigo')],
            'descricao' => ['required', new EmpresaUnicaAdmin('motivo', 'mysql',  'codigo')],
            'status_id' => ['required']

        ]);

        $motivo_iva = new TipoMotivoIva();
        $motivo_iva->codigoMotivo = $request->codigoMotivo;
        $motivo_iva->descricao = $request->descricao;
        $motivo_iva->codigoStatus = $request->status_id;
        $motivo_iva->status_id = $request->status_id;
        $motivo_iva->empresa_id = null;
        $motivo_iva->canal_id = $canal_admin;
        $motivo_iva->user_id = Auth::user()->id;
        $motivo_iva->save();
        $motivo_iva->refresh();


        return response()->json($motivo_iva, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $canal_admin = 3;


        $this->validate($request, [
            'codigoMotivo' => ['required', new EmpresaUnicaAdmin('motivo', 'mysql', 'codigo', $id)],
            'descricao' => ['required', new EmpresaUnicaAdmin('motivo', 'mysql',  'codigo', $id)],
            'status_id' => ['required']

        ]);

        $motivo_iva = TipoMotivoIva::find($id);
        $motivo_iva->codigoMotivo = $request->codigoMotivo;
        $motivo_iva->descricao = $request->descricao;
        $motivo_iva->codigoStatus = $request->status_id;
        $motivo_iva->status_id = $request->status_id;
        $motivo_iva->empresa_id = null;
        $motivo_iva->canal_id = $canal_admin;
        $motivo_iva->user_id = Auth::user()->id;
        $motivo_iva->save();
        $motivo_iva->refresh();


        return response()->json($motivo_iva, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        try {

            $motivo_iva = TipoMotivoIva::find($codigo);
            $motivo_iva->delete();
            $motivo_iva->refresh();
            if ($motivo_iva) {
                return response()->json($motivo_iva, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível Eliminar", 500);
        }
    }



    public function listar($regimeEmpresaAuth)
    {
        $regimeNaoSujeicao = 3;
        $regimeGeral = 1;
        $regimeTransitorio = 2;

        //Empresa
        if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == $this->empresa_system)) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        if ($regimeEmpresaAuth == $regimeNaoSujeicao) {
            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [7, 8])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa_id)
                ->get();
        } else if ($regimeEmpresaAuth == $regimeGeral) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->where('empresa_id', NULL)->where('codigo', '!=', 9)
                ->where('codigo', '!=', 7)
                ->orWhere('empresa_id', $empresa_id)
                ->get();
        } else if ($regimeEmpresaAuth == $regimeTransitorio) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [8, 9])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa_id)
                ->get();
        }
        return response()->json($tipoMotivoIva, 200);
    }


    /**
     * 
     * API MOTIVOS
     */
    public function listarMotivos()
    {

        $regimeNaoSujeicao = 3;
        $regimeGeral = 1;
        $regimeTransitorio = 2;

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();

        }

        // //Empresa
        // if (Auth::guard('WebApi')->check() && (Auth::guard('WebApi')->user()->tipo_user_id == $this->empresa_system)) {
        //     $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
        //     $empresa = Empresa_Cliente::where('referencia', $referencia)->first();
        // } else if (Auth::guard('EmpresaApi')->user()->tipo_user_id == $this->empresa_funcionario) {

        //     $empresa_id = Auth::guard('EmpresaApi')->user()->empresa_id;
        //     $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        // }

        if ($empresa->tipo_regime_id == $regimeNaoSujeicao) {
            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [7, 8])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa->id)
                ->get();
        } else if ($empresa->tipo_regime_id == $regimeGeral) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->where('empresa_id', NULL)->where('codigo', '!=', 9)
                ->where('codigo', '!=', 7)
                //->where('codigo','!=',8)
                ->orWhere('empresa_id', $empresa->id)
                ->get();
        } else if ($empresa->tipo_regime_id == $regimeTransitorio) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [8, 9])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa->id)
                ->get();
        }
        return response()->json($tipoMotivoIva, 200);
    }
}
