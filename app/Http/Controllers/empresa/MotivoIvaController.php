<?php

namespace App\Http\Controllers\empresa;

use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Models\empresa\TipoMotivoIva;
use App\Models\admin\Statu;
use App\Http\Controllers\Controller;
use App\Models\admin\Motivo_Iva;
use App\Models\empresa\TipoTaxa;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MotivoIvaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function index()
    {
             
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data['motivos'] = Motivo_Iva::with('statuGeral')->get();

        $data['status'] = Statu::all();
        $data['user'] = Auth::user();
        return view('empresa.motivos.index', $data);
    }
    public function store(Request $request)
    {
        $canal_cliente = 2;

        $this->validate($request, [
            'codigoMotivo' => ['required', new EmpresaUnique('motivo', 'mysql2', 'codigo', 'codigoMotivo', 'codigostatus')],
            'descricao' => ['required', new EmpresaUnique('motivo', 'mysql2', 'codigo', 'descricao', 'codigostatus')],
            'status_id' => ['required']
        ]);

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $motivo_iva = new TipoMotivoIva();


        $motivo_iva->codigoMotivo = $request->codigoMotivo;
        $motivo_iva->descricao = $request->descricao;
        $motivo_iva->codigoStatus = $request->status_id;
        $motivo_iva->status_id = $request->status_id;
        $motivo_iva->empresa_id = $empresa['empresa']['id'];
        $motivo_iva->canal_id = $canal_cliente;
        $motivo_iva->user_id = null;
        $motivo_iva->save();

        return response()->json($motivo_iva, 200);
    }
    public function update(Request $request, $id)
    {

        $canal_cliente = 2;

        $this->validate($request, [
            'codigoMotivo' => ['required', new EmpresaUnique('motivo', 'mysql2', 'codigo', $id, 'codigostatus')],
            'descricao' => ['required', new EmpresaUnique('motivo', 'mysql2', 'codigo', $id, 'codigostatus')],
            'status_id' => ['required']

        ]);

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $motivo_iva = TipoMotivoIva::where('empresa_id', $empresa['empresa']['id'])->find($id);

        if (!$motivo_iva) {
            return ["errors" => "Sem permissão para alterar o Motivo padrão do sistema", "status" => 500];
        }

        $motivo_iva->codigoMotivo = $request->codigoMotivo;
        $motivo_iva->descricao = $request->descricao;
        $motivo_iva->codigoStatus = $request->status_id;
        $motivo_iva->status_id = $request->status_id;
        $motivo_iva->empresa_id = $empresa['empresa']['id'];
        $motivo_iva->canal_id = $canal_cliente;
        $motivo_iva->user_id = null;
        $motivo_iva->save();
        return response()->json($motivo_iva, 200);
    }

    public function destroy($codigo)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        try {
            $motivo_iva = TipoMotivoIva::where('empresa_id', $empresa['empresa']['id'])->where('codigo', $codigo)->first();
            $motivo_iva->delete();
            if ($motivo_iva) {
                return response()->json($motivo_iva, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível Eliminar", 500);
        }

        return false;
    }

    public function listar($regimeEmpresaAuth)
    {
        
        $regimeNaoSujeicao = 3;
        $regimeGeral = 1;
        $regimeTransitorio = 2;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        if ($regimeEmpresaAuth == $regimeNaoSujeicao) {
            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [7, 8])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa['empresa']['id'])
                ->get();
        } else if ($regimeEmpresaAuth == $regimeGeral) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->where('empresa_id', NULL)->where('codigo', '!=', 9)
                ->where('codigo', '!=', 7)
                ->orWhere('empresa_id', $empresa['empresa']['id'])
                ->get();
        } else if ($regimeEmpresaAuth == $regimeTransitorio) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [8, 9])->where('empresa_id', NULL)->orWhere('empresa_id', $empresa['empresa']['id'])
                ->get();
        }
       
        return response()->json($tipoMotivoIva, 200);
    }
}
