<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Bancos;
use App\Models\admin\StatuGerais;
use App\Models\empresa\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
        $data['bancos'] = Bancos::with(['statuGeral'])->get();

        $data['status'] = StatuGerais::get();

        return view('admin.bancos.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'designacao.required' =>'É obrigatório a indicação do campo nome',
            'status_id.required' =>'É obrigatório a indicação do campo status',
            'canal_id.required' =>'É obrigatório a indicação do campo canal',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required'],
            'status_id' => ['required'], 
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }

        $banco = new Bancos();
        $banco->designacao = $request->designacao;
        $banco->sigla = $request->sigla;
        $banco->status_id = $request->status_id;
        $banco->canal_id = $request->canal_id;
        $banco->user_id = Auth::user()->id;
        $banco->save();
        $banco->refresh();
        return response()->json($banco, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'designacao.required' =>'É obrigatório a indicação do campo nome',
            'status_id.required' =>'É obrigatório a indicação do campo status',
            'canal_id.required' =>'É obrigatório a indicação do campo canal',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required'],
            'status_id' => ['required'], 
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }

        $banco = Bancos::find($id);
        $banco->designacao = $request->designacao;
        $banco->sigla = $request->sigla;
        $banco->status_id = $request->status_id;
        $banco->canal_id = $request->canal_id;
        $banco->user_id = Auth::user()->id;
        $banco->save();
        $banco->refresh();
        return response()->json($banco, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banco = Bancos::find($id);
        $banco->delete();
        $banco->refresh();
        return response()->json($banco, 200);
    }

    public function imprimirBancos(){
        
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() .'\\upload\\'. $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'bancos',
                'report_jrxml'=> 'bancos.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio,
                ]    
            ]
        );

    }
}
