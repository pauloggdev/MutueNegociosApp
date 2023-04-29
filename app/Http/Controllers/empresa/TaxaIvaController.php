<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa\TipoTaxa as TaxaIvaEmpresa;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Models\admin\Statu;
use App\Models\admin\Taxa_Iva;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Support\Facades\Auth;

class TaxaIvaController extends Controller
{

    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;

    public function __construct()
    {
    }


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

        $data['taxas'] = Taxa_Iva::with('statuGeral')->get();
        $data['status'] = Statu::all();
        $data['user'] = (Auth::user());
        

        return view('empresa.taxas.index', $data);
    }
    public function store(Request $request)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $this->validate($request, [
            'taxa' => ['required', new EmpresaUnique('tipotaxa', 'mysql2', 'codigo', 'taxa', 'codigostatus')],
            'codigostatus' => ['required']

        ]);

        $taxa_iva = new TaxaIvaEmpresa();
        $taxa_iva->taxa = $request->taxa;
        $taxa_iva->codigostatus = $request->codigostatus;
        $taxa_iva->codigoMotivo = $request->codigoMotivo;
        $taxa_iva->empresa_id = $empresa['empresa']['id'];
        $taxa_iva->descricao = "IVA(" . number_format($request->taxa, 2, ",", ".") . "%)";
        $taxa_iva->save();

        return response()->json($taxa_iva, 200);
    }
    public function update(Request $request, $codigo)
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $this->validate($request, [
            'taxa' => ['required', new EmpresaUnique('tipotaxa', 'mysql2', 'codigo', $codigo, 'codigostatus')],
        ]);

        $taxa_iva = TaxaIvaEmpresa::where('empresa_id', $empresa['empresa']['id'])->find($codigo);

        if (!$taxa_iva) {
            return ["errors" => "Sem permissão para alterar taxa padrão do sistema", "status" => 401];
        }

        $taxa_iva->taxa = $request->taxa;
        $taxa_iva->codigostatus = $request->codigostatus;
        $taxa_iva->codigoMotivo = $request->codigoMotivo;
        $taxa_iva->empresa_id = $empresa['empresa']['id'];
        $taxa_iva->descricao = "IVA(" . number_format($request->taxa, 2, ",", ".") . "%)";
        $taxa_iva->save();

        return response()->json($taxa_iva, 200);
    }
    public function destroy($id)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        try {
            $taxa_iva = TaxaIvaEmpresa::where('empresa_id', $empresa['empresa']['id'])->where('codigo', $id)->first();
            $taxa_iva->delete();
            if ($taxa_iva) {
                return response()->json($taxa_iva, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível Eliminar", 500);
        }
        return false;
    }


    //API
    public function listarTaxas()
    {
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }
        $data['taxas'] = TaxaIvaEmpresa::with('statuGeral')->where('empresa_id', $empresa_id)->orWhere('empresa_id', null)->get();

        return response()->json($data, 200);
    }
}
