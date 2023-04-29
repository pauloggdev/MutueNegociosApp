<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\ModeloFactura;
use App\Models\empresa\ParametroImpressao;
use App\Models\empresa\Statu;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class ConfiguracaoController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function modeloDocumentoIndex()
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
        $data['modeloactivo'] = ModeloFactura::with(['modeloDocumentoAtivo'])
            ->whereHas('modeloDocumentoAtivo', function ($query) use ($empresa) {
                return $query->where('empresa_id', $empresa['empresa']['id']);
            })->first();

        // dd($data['modeloactivo']);

        if (!$data['modeloactivo']) {
            $data['modeloactivo']['id'] = 1;
        }
        $data['modelofacturas'] = DB::connection('mysql2')->table('modelo_facturas')
            ->get();


        return view('empresa.configuracoes.modeloDocumentoIndex', $data);
    }
    public function setarModeloDocumento(Request $request)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $modeloAtivo = DB::connection('mysql2')->table('modelo_documento_ativo')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->first();

        if ($modeloAtivo) {
            $modelo = DB::connection('mysql2')->table('modelo_documento_ativo')
                ->where('empresa_id', $empresa['empresa']['id'])
                ->delete();

            $modelo = DB::connection('mysql2')->table('modelo_documento_ativo')->insertGetId([
                'modelo_id' => $request->id,
                'empresa_id' => $empresa['empresa']['id']
            ]);
        } else {
            $modelo = DB::connection('mysql2')->table('modelo_documento_ativo')->insertGetId([
                'modelo_id' => $request->id,
                'empresa_id' => $empresa['empresa']['id']
            ]);
        }

        return response()->json($modelo, 200);
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

        $retencao = DB::connection('mysql2')->table('parametros')->Where('label', 'retencao_na_fonte')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['retencao'] = $retencao ? $retencao : DB::connection('mysql2')->table('parametros')
            ->Where('label', 'retencao_na_fonte')
            ->where("empresa_id", NULL)->first();


        $desconto = DB::connection('mysql2')->table('parametros')->Where('label', 'valor_desconto')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['desconto'] = $desconto ? $desconto : DB::connection('mysql2')->table('parametros')
            ->Where('label', 'valor_desconto')
            ->where("empresa_id", NULL)->first();

        $dias_vencimento_factura = DB::connection('mysql2')->table('parametros')->Where('label', 'n_dias_vencimento_factura')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['vencimentofactura'] = $dias_vencimento_factura ? $dias_vencimento_factura : DB::connection('mysql2')->table('parametros')
            ->Where('label', 'n_dias_vencimento_factura')
            ->where("empresa_id", NULL)->first();

        $dias_vencimento_proforma = DB::connection('mysql2')->table('parametros')->Where('label', 'n_dias_vencimento_factura_proforma')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['vencimentoftproforma'] = $dias_vencimento_proforma ? $dias_vencimento_proforma : DB::connection('mysql2')->table('parametros')
            ->Where('label', 'n_dias_vencimento_factura_proforma')
            ->where("empresa_id", NULL)->first();

        $viaImpressao = DB::connection('mysql2')->table('parametros')->Where('label', 'n_vias_de_impressao')->where("empresa_id", $empresa['empresa']['id'])->first();
        $data['viaimpressao'] = $viaImpressao ? $viaImpressao : DB::connection('mysql2')->table('parametros')->Where('label', 'n_vias_de_impressao')->where("empresa_id", NULL)->first();



        $impressao = DB::connection('mysql2')->table('parametros')->Where('label', 'tipoImpreensao')->where("empresa_id", $empresa['empresa']['id'])->first();

        $data['impressao'] = $impressao ? $impressao : DB::connection('mysql2')->table('parametros')->Where('label', 'tipoImpreensao')->where("empresa_id", NULL)->first();
        $documentoSerie = DB::connection('mysql2')->table('series_documento')
            ->where('empresa_id', $empresa['empresa']['id'])->first();

        $observacao =   DB::connection('mysql2')->table('observacao_factura')
            ->where("empresa_id", $empresa['empresa']['id'])->first();

        $data['observacaofactura']  = $observacao ? $observacao->observacao : NULL;
        $data['documentoserie'] = $documentoSerie ? $documentoSerie : ['serie' => mb_strtoupper(substr(Str::slug($empresa['empresa']['nome']), 0, 3)), 'empresa_id' => $empresa['empresa']['id']];

        return view('empresa.configuracoes.parametros', $data);
    }

    public function atualizarNumeroViaImpressao(Request $request)
    {

        $viaImpressao = DB::connection('mysql2')->table('parametros')
            ->Where('label', 'n_vias_de_impressao')
            ->where("empresa_id", auth()->user()->empresa_id)->first();

        if ($viaImpressao) {

            return DB::connection('mysql2')->table('parametros')
                ->Where('label', 'n_vias_de_impressao')->where("empresa_id", auth()->user()->empresa_id)
                ->update([
                    'valor' => $request->valor,
                    'vida' => $request->valor,
                ]);
        } else {

            return DB::connection('mysql2')->table('parametros')->insertGetId([
                'designacao' => 'Nº VIA DE IMPRESSÃO',
                'valor' => $request->valor,
                'vida' => $request->valor,
                'empresa_id' => auth()->user()->empresa_id,
                'label' => 'n_vias_de_impressao'

            ]);
        }
    }

    public function atualizarTipoImpressao(Request $request)
    {
        $formato = "A4";
        if ($request->folha == 1) {
            $formato = "A4";
            $tipoFolha = 1;
            $designacao = "IMPRESSÃƒO A4";
        } else if ($request->folha == 2) {
            $formato = "A5";
            $tipoFolha = 2;
            $designacao = "IMPRESSÃƒO A5";
        } else {
            $formato = "TICKET";
            $tipoFolha = 3;
            $designacao = "IMPRESSÃƒO TICKET";
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $impressao = DB::connection('mysql2')->table('parametros')
            ->Where('label', 'tipoImpreensao')
            ->where("empresa_id", $empresa['empresa']['id'])->first();

        $parametro_impressao = DB::connection('mysql2')->table('parametro_impressao')
            ->where("empresa_id", auth()->user()->empresa_id)->first();

        if ($parametro_impressao) {
            DB::connection('mysql2')->table('parametro_impressao')
                ->where("empresa_id", auth()->user()->empresa_id)
                ->update(['valor' => $formato, 'designacao' => $designacao, 'vida' => $formato, 'tipoFolha' => $tipoFolha]);
        } else {
            DB::connection('mysql2')->table('parametro_impressao')
                ->insertGetId([
                    'valor' => $formato,
                    'designacao' => $designacao,
                    'vida' => $formato,
                    'empresa_id' => auth()->user()->empresa_id,
                    'tipoFolha' => $tipoFolha
                ]);
        }



        if ($impressao) {


            $impressao = DB::connection('mysql2')->table('parametros')
                ->Where('label', 'tipoImpreensao')
                ->where("empresa_id", $empresa['empresa']['id'])
                ->update(['valor' => $formato, 'vida' => $tipoFolha, 'designacao' => $designacao]);

            return $impressao;
        }



        return DB::connection('mysql2')->table('parametros')
            ->insertGetId([
                'designacao' => $designacao,
                'valor' => $formato,
                'vida' => $tipoFolha,
                'empresa_id' => $empresa['empresa']['id'],
                'label' => 'tipoImpreensao'
            ]);
    }
    public function show(Request $request)
    {
        $formato = "A4";
        if ($request->all()['formatoImpresao'] == 1) {
            $formato = "A4";
            $tipoFolha = 1;
        } else if ($request->all()['formatoImpresao'] == 2) {
            $formato = "A5";
            $tipoFolha = 2;
        } else {
            $formato = "TICKET";
            $tipoFolha = 3;
        }
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $parametroImpressao = ParametroImpressao::where('empresa_id', $empresa_id)->first();
        $parametroImpressao->vida = $formato;
        $parametroImpressao->valor = $formato;
        $parametroImpressao->tipoFolha = $tipoFolha;
        $parametroImpressao->designacao = "IMPRESSÃƒO " . $formato;
        $parametroImpressao->empresa_id = $empresa_id;
        $parametroImpressao->save();
    }

    public function actualizarRetencao(Request $request)
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $retencao = DB::connection('mysql2')->table('parametros')
            ->Where('label', 'retencao_na_fonte')
            ->where("empresa_id", $empresa['empresa']['id'])->first();

        if ($retencao) {
            return DB::connection('mysql2')->table('parametros')
                ->Where('label', 'retencao_na_fonte')
                ->where("empresa_id", $empresa['empresa']['id'])
                ->update(['valor' => $request->valor]);
        }

        return DB::connection('mysql2')->table('parametros')
            ->insertGetId([
                'designacao' => $request->designacao,
                'valor' => $request->valor,
                'vida' => $request->vida,
                'empresa_id' => $empresa['empresa']['id'],
                'label' => $request->label
            ]);
    }
    public function atualizarDesconto(Request $request)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $desconto = DB::connection('mysql2')->table('parametros')
            ->Where('label', 'valor_desconto')
            ->where("empresa_id", $empresa['empresa']['id'])->first();

        if ($desconto) {
            return DB::connection('mysql2')->table('parametros')
                ->Where('label', 'valor_desconto')
                ->where("empresa_id", $empresa['empresa']['id'])
                ->update(['valor' => $request->valor]);
        }

        return DB::connection('mysql2')->table('parametros')
            ->insertGetId([
                'designacao' => $request->designacao,
                'valor' => $request->valor,
                'vida' => $request->vida,
                'empresa_id' => $empresa['empresa']['id'],
                'label' => $request->label
            ]);
    }
    public function alterarDiasVencimentoFactura(Request $request)
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $desconto = DB::connection('mysql2')->table('parametros')
            ->Where('label', $request->label)
            ->where("empresa_id", $empresa['empresa']['id'])->first();

        if ($desconto) {
            return DB::connection('mysql2')->table('parametros')
                ->Where('label', $request->label)
                ->where("empresa_id", $empresa['empresa']['id'])
                ->update(['vida' => $request->vida]);
        }

        return DB::connection('mysql2')->table('parametros')
            ->insertGetId([
                'designacao' => $request->designacao,
                'vida' => $request->vida,
                'empresa_id' => $empresa['empresa']['id'],
                'label' => $request->label
            ]);
    }
    public function alterarDiasVencimentoFtProforma(Request $request)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $desconto = DB::connection('mysql2')->table('parametros')
            ->Where('label', $request->label)
            ->where("empresa_id", $empresa['empresa']['id'])->first();
        if ($desconto) {
            return DB::connection('mysql2')->table('parametros')
                ->Where('label', $request->label)
                ->where("empresa_id", $empresa['empresa']['id'])
                ->update(['vida' => $request->vida]);
        }
        return DB::connection('mysql2')->table('parametros')
            ->insertGetId([
                'designacao' => $request->designacao,
                'vida' => $request->vida,
                'empresa_id' => $empresa['empresa']['id'],
                'label' => $request->label
            ]);
    }
    public function alterarSerieDocumento(Request $request)
    {

        $documentoSerie =  DB::connection('mysql2')->table('series_documento')
            ->where('empresa_id', $request->empresa_id)->first();
        if ($documentoSerie) {

            $serie = DB::connection('mysql2')->table('series_documento')
                ->where('id', $request->id)
                ->where('empresa_id', $request->empresa_id)->update([
                    'serie' => $request->serie
                ]);
        } else {

            $serie = DB::connection('mysql2')->table('series_documento')
                ->insertGetId([
                    'serie' => $request->serie,
                    'empresa_id' => $request->empresa_id
                ]);
        }

        return response()->json($serie, 200);
    }
    public function alterarObservacaoFactura(Request $data)
    {
        $observacaoFactura =  DB::connection('mysql2')->table('observacao_factura')
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        if ($observacaoFactura) {

            $observacao = DB::connection('mysql2')->table('observacao_factura')
                ->where('id', $observacaoFactura->id)
                ->where('empresa_id', auth()->user()->empresa_id)->update([
                    'observacao' => $data[0]
                ]);
        } else {

            $observacao = DB::connection('mysql2')->table('observacao_factura')
                ->insertGetId([
                    'observacao' => $data[0],
                    'empresa_id' => auth()->user()->empresa_id
                ]);
        }

        return response()->json($observacao, 200);
    }

    public function adicionarProdutoExistenciaEstoque($armazen)
    {

        $QUANT_INICIAL = 0;
        $CANAL_PORTAL_EMPRESA = 2;
        $STATUS_ATIVO = 1;

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        $produtos = DB::connection('mysql2')->table('produtos')->where('empresa_id', $empresa_id)->get();


        foreach ($produtos as $key => $produto) {
            $existenciaStock = new ExistenciaStock();
            $existenciaStock->produto_id = $produto->id;
            $existenciaStock->armazem_id = $armazen->id;
            $existenciaStock->quantidade = $QUANT_INICIAL;
            $existenciaStock->canal_id = $CANAL_PORTAL_EMPRESA;
            $existenciaStock->status_id = $STATUS_ATIVO;
            $existenciaStock->empresa_id = $empresa_id;
            $existenciaStock->save();
        }
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
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['armazen'] = Armazen::where('id', $id)->where('empresa_id', $empresa_id)->first();
        $data['status'] = Statu::all();

        return view('empresa.armazens.edit', $data);
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

        // dd($request->all());
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new EmpresaUnique('armazens', 'mysql2', 'id', $id)],
            'codigo' => [new EmpresaUnique('armazens', 'mysql2', 'id', $id)],
            'localizacao' => 'required',
            'status_id' => 'required'
        ]);

        // try{
        $armazen = Armazen::where('id', $id)->first();

        $armazen->designacao = $request->designacao;
        $armazen->sigla = $request->sigla;
        $armazen->localizacao = $request->localizacao;
        $armazen->status_id = $request->status_id;
        $armazen->user_id = $operador;
        $armazen->empresa_id = $empresa_id;
        $armazen->save();

        if ($armazen) {
            return response()->json($armazen, 200);
        }
        // }catch (\Exception $th) {
        //     return response()->json($th->getMessage(), 500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        try {
            $armazen = Armazen::where("id", $id)->first();
            $armazen->delete();
            if ($armazen) {
                return response()->json($armazen, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! NÃ£o possÃ­vel Eliminar", 500);
        }
    }

    public function pegarDependencias()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['status_gerais'] = DB::connection('mysql2')->table('status_gerais')->orderBy('designacao', 'ASC')->get();

        return Response()->json($data);
    }
    //API
    public function listarArmazens()
    {
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        $data['armazens'] = Armazen::with('statuGeral')->where('empresa_id', $empresa_id)->get();
        return response()->json($data, 200);
    }
}
