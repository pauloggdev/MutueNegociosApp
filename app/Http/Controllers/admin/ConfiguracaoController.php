<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\admin\User;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ConfiguracaoController extends Controller
{


    public function editarEmpresa()
    {

        $data['empresas'] = Empresa::with(['pais'])->where('id', 1)->first();
        $data['paises'] = DB::connection('mysql')->table('paises')->get();
        $data['regimes'] = DB::connection('mysql')->table('tipos_regimes')->get();
        return view('admin.configuracao.editar', $data);
        
    }

    public function update(Request $request)
    {

        $data = json_decode($request->empresa, true);


        $validate = Validator::make($data, [
            'nome' => ['required', new EmpresaUnique('empresas', 'mysql', 'id', $data['id'])],
            'email' => ['required', new EmpresaUnique('empresas', 'mysql', 'id', $data['id'])],
            'pessoal_Contacto' => ['required', new EmpresaUnique('empresas', 'mysql', 'id', $data['id'])],
            'nif' => [new EmpresaUnique('empresas', 'mysql', 'id', $data['id'])],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'pais_id' => ['required'],
            'tipo_cliente_id' => ['required'],
            'tipo_regime_id' => ['required'],
            'canal_id' => ['required'],
            'user_id' => ['required']
        ]);

        $empresaLogotipo = $this->verificarExisteFoto($data['id']); //Pega Logotipo anterior

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        if (isset($request->logotipo) && !empty($request->logotipo)) {

            if ($empresaLogotipo && $empresaLogotipo->logotipo != "admin/avatarEmpresa.jpg") {
                unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $data['logotipo']);
            }
            $photoName = $request->logotipo->store('/admin');
        } else {

            if ($empresaLogotipo) {
                $photoName = $empresaLogotipo->logotipo;
            }else{
                $photoName = "admin/avatarEmpresa.jpg";
            }
        }

        $empresa = Empresa::find($data['id']);
        $empresa->nome = $data['nome'];
        $empresa->pessoal_Contacto = $data['pessoal_Contacto'];
        $empresa->endereco = $data['endereco'];
        $empresa->pais_id = $data['pais_id'];
        $empresa->nif = $data['nif'];
        $empresa->tipo_regime_id = $data['tipo_regime_id'];
        $empresa->logotipo = $photoName;
        $empresa->website = $data['website'];
        $empresa->email = $data['email'];
        $empresa->cidade = $data['cidade'];
        $empresa->save();

        if ($empresa) {
            $this->updateUser($empresa);
        }

        return response()->json($empresa, 200);
    }
    public function updateUser($data)
    {

        $usuario = User::find(1);
        $usuario->name = $data->nome;
        $usuario->telefone = $data->pessoal_Contacto;
        $usuario->foto = $data->logotipo;
        $usuario->save();
        return response()->json($usuario, 200);
    }
    public function verificarExisteFoto($empresaId)
    {
        return DB::connection('mysql')->table('empresas')->where('id', $empresaId)->first();
    }
    //
}
