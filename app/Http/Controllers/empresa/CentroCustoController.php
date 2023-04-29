<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa\CentroCusto;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CentroCustoController extends Controller
{

    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;
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
        $data['centrocustos'] = CentroCusto::with(['statu'])->where('empresa_id', auth()->user()->empresa_id)->get();
        return view('empresa.centroCustos.index', $data);
    }
    public function centroCustosIndex(){

        $data['centrocustos'] = CentroCusto::where('empresa_id', auth()->user()->empresa_id)->get();

        return view('empresa.centroCustos.centroCustosIndex', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresa.centroCustos.create');
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

            'nome.required' => 'Nome é obrigatório',
            'nome.unique' => 'Nome já cadastrado',
            'nif.required' => 'NIF é obrigatório',
            'nif.unique' => 'NIF já cadastrado',
            'cidade.required' => 'Cidade é obrigatório',
            'endereco.required' => 'Endereço é obrigatório',
            'email.required' => 'E-mail é obrigatório',
            'telefone.required' => 'Telefone é obrigatório',
        ];

        $this->validate($request, [
            'nome' => ['required', new EmpresaUnique('centro_custos')],
            'nif' => ['required'],
            'cidade' => ['required'],
            'endereco' => ['required'],
            'email' => ['required'],
            'telefone' => ['required']
        ], $message);


        try {
            DB::beginTransaction();

            if ($request->hasFile('logotipo') && $request->logotipo->isValid()) {
                $photoName = $request->logotipo->store("/utilizadores/empresa/centroCustos");
            } else {
                if (auth()->user()->empresa->logotipo) {
                    $fileName = Str::after(auth()->user()->empresa->logotipo, 'utilizadores/cliente/');
                    $photoName = 'utilizadores/empresa/centroCustos/' . $fileName;
                    if (!Storage::exists($photoName)) {
                        Storage::copy(auth()->user()->empresa->logotipo, $photoName);
                    }
                } else {
                    $photoName = NULL;
                }
            }
            //Alvará
            if ($request->hasFile('file_alvara') && $request->file_alvara->isValid()) {
                $file_alvara = $request->file_alvara->store("/documentos/empresa/documentos/centroCustos");
            } else {
                if (auth()->user()->empresa->file_alvara) {
                    $fileNameAlvara = Str::after(auth()->user()->empresa->file_alvara, 'documentos/empresa/documentos/');
                    $file_alvara = 'documentos/empresa/documentos/centroCustos/' . $fileNameAlvara;
                    if (!Storage::exists($file_alvara)) {
                        Storage::copy(auth()->user()->empresa->file_alvara, $file_alvara);
                    }
                } else {
                    $file_alvara = NULL;
                }
            }
            //NIF
            if ($request->hasFile('file_nif') && $request->file_nif->isValid()) {
                $file_nif = $request->file_nif->store("/documentos/empresa/documentos/centroCustos");
            } else {
                if (auth()->user()->empresa->file_nif) {
                    $fileNameNif = Str::after(auth()->user()->empresa->file_nif, 'documentos/empresa/documentos/');
                    $file_nif = 'documentos/empresa/documentos/centroCustos/' . $fileNameNif;
                    if (!Storage::exists($file_nif)) {
                        Storage::copy(auth()->user()->empresa->file_nif, $file_nif);
                    }
                } else {
                    $file_nif = NULL;
                }
            }

            DB::table('centro_custos')->insertGetId([
                'uuid' => Str::uuid(),
                'nome' => $request->nome,
                'empresa_id' => auth()->user()->empresa_id,
                'status_id' => $request->statu_id,
                'endereco' => $request->endereco,
                'nif' => $request->nif,
                'cidade' => $request->cidade,
                'logotipo' => $photoName,
                'email' => $request->email,
                'website' => $request->website,
                'telefone' => $request->telefone,
                'pessoa_de_contacto' => $request->pessoa_de_contacto,
                'file_alvara' => $file_alvara,
                'file_nif' => $file_nif,
            ]);

            DB::commit();
            return redirect()->route('centroCusto.index')->withSuccess('Operação efectuada com Sucesso!');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->route('centroCusto.create')->withErrors('Erro ao cadastrar centro de custo!');
        }
    }
    public function edit($uuid)
    {

        $centroCusto =  CentroCusto::where('uuid', $uuid)->where('empresa_id', auth()->user()->empresa_id)->first();
        if (!$centroCusto) {
            return redirect()->back();
        }

        return view('empresa.centroCustos.edit', [
            'centroCusto' => $centroCusto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {


        $message = [

            'nome.required' => 'Nome é obrigatório',
            'nome.unique' => 'Nome já cadastrado',
            'nif.required' => 'NIF é obrigatório',
            'nif.unique' => 'NIF já cadastrado',
            'cidade.required' => 'Cidade é obrigatório',
            'endereco.required' => 'Endereço é obrigatório',
            'email.required' => 'E-mail é obrigatório',
            'telefone.required' => 'Telefone é obrigatório',
        ];

        $this->validate($request, [
            'nome' => "required|min:3|max:255|unique:centro_custos,nome,{$uuid},uuid",
            'nif' => "required|min:3|max:255|unique:centro_custos,nif,{$uuid},uuid",
            'cidade' => ['required'],
            'endereco' => ['required'],
            'email' => ['required'],
            'telefone' => ['required']
        ], $message);

        $centroCusto =  CentroCusto::with(['empresa'])->where('uuid', $uuid)->where('empresa_id', auth()->user()->empresa_id)->first();

        if (!$centroCusto) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            //Logotipo
            $photoName = $centroCusto->logotipo;

            if ($request->hasFile('logotipo') && $request->logotipo->isValid()) {
                if ($photoName != "utilizadores/cliente/avatarEmpresa.png") {

                    if (Storage::exists($photoName)) {
                        Storage::delete($photoName);
                    }
                    $photoName = $request->logotipo->store("/utilizadores/empresa/centroCustos");
                }
            } else {
            }
            //Alvará
            $file_alvara = $centroCusto->file_alvara;

            if (($request->hasFile('file_alvara') && $request->file_alvara->isValid())) {
                if (Storage::exists($file_alvara)) {
                    Storage::delete($file_alvara);
                }
                $file_alvara = $request->file_alvara->store("/documentos/empresa/documentos/centroCustos");
            }
            //NIF
            $file_nif = $centroCusto->file_nif;
            if (($request->hasFile('file_nif') && $request->file_nif->isValid())) {
                if (Storage::exists($file_nif)) {
                    Storage::delete($file_nif);
                }
                $file_nif = $request->file_nif->store("/documentos/empresa/documentos/centroCustos");
            }

            DB::table('centro_custos')->where('uuid', $centroCusto->uuid)->update([
                'nome' => $request->nome,
                'empresa_id' => auth()->user()->empresa_id,
                'status_id' => $request->statu_id,
                'endereco' => $request->endereco,
                'nif' => $request->nif,
                'cidade' => $request->cidade,
                'logotipo' => $photoName,
                'email' => $request->email,
                'website' => $request->website,
                'telefone' => $request->telefone,
                'pessoa_de_contacto' => $request->pessoa_de_contacto,
                'file_alvara' => $file_alvara,
                'file_nif' => $file_nif,
            ]);

            DB::commit();
            return redirect()->route('centroCusto.edit', $centroCusto->uuid)->withSuccess('Operação efectuada com Sucesso!');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->route('centroCusto.edit', $centroCusto->uuid)->withErrors('Erro ao cadastrar centro de custo!');
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
        //
    }
}
