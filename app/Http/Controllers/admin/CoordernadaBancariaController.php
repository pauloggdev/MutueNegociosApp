<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Bancos;
use App\Models\admin\CoordenadaBancaria;
use App\Models\admin\StatuGerais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CoordernadaBancariaController extends Controller
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
        $data['coordernadasbancaria'] = CoordenadaBancaria::with(['banco','statuGeral'])->get();
        $data['bancos'] = Bancos::get();
        $data['status'] = StatuGerais::get();
        return view('admin.coordenadasBancaria.index', $data);
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
            'num_conta.required' =>'É obrigatório a indicação do campo nº de conta',
            'iban.required' =>'É obrigatório a indicação do campo nº de conta',
            'status_id.required' =>'É obrigatório a indicação do campo status',
            'canal_id.required' =>'É obrigatório a indicação do campo canal',
            'banco_id.required' =>'É obrigatório a indicação do campo banco',
        ];
        $validator = Validator::make($request->all(), [
            'canal_id' => ['required'],
            'status_id' => ['required'], 
            'num_conta' => ['required'], 
            'iban' => ['required'], 
            'banco_id' => ['required'], 
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }

        $coordernadabancaria = new CoordenadaBancaria();
        $coordernadabancaria->canal_id = $request->canal_id;
        $coordernadabancaria->status_id = $request->status_id;
        $coordernadabancaria->num_conta = $request->num_conta;
        $coordernadabancaria->iban = $request->iban;
        $coordernadabancaria->banco_id = $request->banco_id;
        $coordernadabancaria->user_id = Auth::user()->id;
        $coordernadabancaria->save();
        $coordernadabancaria->refresh();
        return response()->json($coordernadabancaria, 200);
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
            'num_conta.required' =>'É obrigatório a indicação do campo nº de conta',
            'iban.required' =>'É obrigatório a indicação do campo nº de conta',
            'status_id.required' =>'É obrigatório a indicação do campo status',
            'canal_id.required' =>'É obrigatório a indicação do campo canal',
            'banco_id.required' =>'É obrigatório a indicação do campo banco',
        ];
        $validator = Validator::make($request->all(), [
            'canal_id' => ['required'],
            'status_id' => ['required'], 
            'num_conta' => ['required'], 
            'iban' => ['required'], 
            'banco_id' => ['required'], 
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }

        $coordernadabancaria = CoordenadaBancaria::find($id);
        $coordernadabancaria->canal_id = $request->canal_id;
        $coordernadabancaria->status_id = $request->status_id;
        $coordernadabancaria->num_conta = $request->num_conta;
        $coordernadabancaria->iban = $request->iban;
        $coordernadabancaria->banco_id = $request->banco_id;
        $coordernadabancaria->user_id = Auth::user()->id;
        $coordernadabancaria->save();
        $coordernadabancaria->refresh();
        return response()->json($coordernadabancaria, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coordernadaBancaria = CoordenadaBancaria::find($id);
        $coordernadaBancaria->delete();
        $coordernadaBancaria->refresh();
        return response()->json($coordernadaBancaria, 200);
    }
}
