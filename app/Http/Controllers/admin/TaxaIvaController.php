<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\admin\Statu;
use App\Models\admin\Taxa_Iva as TaxaIvaAdmin;
use App\Models\empresa\TipoTaxa as TaxaIvaEmpresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\TipoTaxa;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxaIvaController extends Controller
{

    private $admin_system = 1;
    private $empresa_system = 2;

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

       
        $data['taxas'] = TaxaIvaEmpresa::with('statuGeral')->orWhere('empresa_id', null)->get();

        $data['status'] = Statu::all();
        $data['user'] = (Auth::user());
        $data['guard'] = Auth::guard('web')->user();
        return view('admin.taxas.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'taxa' => ['required', new EmpresaUnicaAdmin('tipotaxa', 'mysql2')],
            'codigostatus' => ['required']

        ]);
        $taxa_iva = new TaxaIvaEmpresa();
        $taxa_iva->taxa = $request->taxa;
        $taxa_iva->codigostatus = $request->codigostatus;
        $taxa_iva->codigoMotivo = $request->codigoMotivo;
        $taxa_iva->empresa_id = NULL;
        $taxa_iva->descricao = "IVA(" . number_format($request->taxa, 2, ",", ".") . "%)";
        $taxa_iva->save();

        return response()->json($taxa_iva, 200);
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
    public function update(Request $request, $codigo)
    {

        $this->validate($request, [
            'taxa' => ['required', new EmpresaUnicaAdmin('tipotaxa', 'mysql', 'codigo', $codigo)],
            'codigostatus' => ['required']

        ]);
        $taxa_iva = TaxaIvaEmpresa::find($codigo);
        $taxa_iva->taxa = $request->taxa;
        $taxa_iva->codigostatus = $request->codigostatus;
        $taxa_iva->codigoMotivo = $request->codigoMotivo;
        $taxa_iva->empresa_id = NULL;
        $taxa_iva->descricao = "IVA(" . number_format($request->taxa, 2, ",", ".") . "%)";
        $taxa_iva->save();
        $taxa_iva->refresh();

        return response()->json($taxa_iva, 200);


        // //Admin 
        // if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == $this->admin_system)) {

        //     $this->validate($request, [
        //         'taxa' => ['required', new EmpresaUnicaAdmin('tipotaxa', 'mysql', 'codigo', $codigo)],
        //     ]);

        //     $empresa = Empresa::select('id')->where('user_id', Auth::user()->id)->first();
        //     $taxa_iva = TaxaIvaAdmin::where('empresa_id', $empresa->id)->find($codigo);
        //     $empresa_id = $empresa->id;
        // }
        // // dd($taxa_iva);

        // if (!$taxa_iva) {
        //     return ["errors" => "Sem permissão para alterar a taxa padrão do sistema", "status" => 401];
        // }

        // $taxa_iva->taxa = $request->taxa;
        // $taxa_iva->codigostatus = $request->codigostatus;
        // $taxa_iva->codigoMotivo = $request->codigoMotivo;
        // $taxa_iva->empresa_id = $empresa_id;
        // $taxa_iva->descricao = "IVA(" . number_format($request->taxa, 2, ",", ".") . "%)";
        // $taxa_iva->save();

        // return response()->json($taxa_iva, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {



        //Admin 
        if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == $this->admin_system)) {
            try {

                $taxa_iva = TaxaIvaEmpresa::where('empresa_id', null)->where('codigo', $id)->first();
                $taxa_iva->delete();
                if ($taxa_iva) {
                    return response()->json($taxa_iva, 200);
                }
            } catch (\Exception $th) {
                return response()->json("Erro! Não possível Eliminar", 500);
            }
        }

        return false;
    }
    public function listarTaxas()
    {

        //Admin 
        if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == $this->admin_system)) {
            $empresa = Empresa::select('id')->where('user_id', Auth::user()->id)->first();
            $data['taxas'] = TaxaIvaAdmin::with('statuGeral')->where('empresa_id', $empresa->id)->where('codigostatus', 1)->get();
        }

        //Empresa
        if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == $this->empresa_system)) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;

            $data['taxas'] = TaxaIvaEmpresa::with('statuGeral')->where('codigostatus', 1)->where('empresa_id', null)->orwhere('empresa_id', $empresa_id)->get();
        }

        return response()->json($data, 200);
    }
}
