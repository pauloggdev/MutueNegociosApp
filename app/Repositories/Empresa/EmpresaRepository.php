<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Empresa_Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpresaRepository
{

    protected $entity;

    public function __construct(Empresa_Cliente $empresa)
    {
        $this->entity = $empresa;
    }

    public function getEmpresa()
    {
        return auth()->user()->empresa;
    }
    public function store($request)
    {

        //Adicionar logotipo
        if (($request->logotipo != "utilizadores/cliente/avatarEmpresa.png") && $request->newLogotipo) {

            if (Storage::exists($request->logotipo)) {
                Storage::delete($request->logotipo);
            }
            $photoName = $request->newLogotipo->store("/utilizadores/cliente");
        } else {
            $photoName = $request->logotipo;
        }
        $request['photoName'] = $photoName;

        //Alvará
        $file_alvara = $request->file_alvara;
        if ($request->newFileAlvara) {
            if (Storage::exists($request->file_alvara)) {
                Storage::delete($request->file_alvara);
            }
            $file_alvara = $request->newFileAlvara->store("/documentos/empresa/documentos");
        }
        //NIF
        $file_nif = $request->file_nif;
        if ($request->newFileNIF) {
            if (Storage::exists($request->file_nif)) {
                Storage::delete($request->file_nif);
            }
            $file_nif = $request->newFileNIF->store("/documentos/empresa/documentos");
        }
        $request['file_alvara'] = $file_alvara;
        $request['file_nif'] = $file_nif;

        DB::connection('mysql2')->table('empresas')->where('id', auth()->user()->empresa->id)->update([
            'nome' => $request->nome,
            'pessoal_Contacto' => $request->pessoal_Contacto,
            'telefone1' => $request->telefone1,
            'telefone2' => $request->telefone2,
            'endereco' => $request->endereco,
            'pais_id' => $request->pais_id,
            'status_id' => 1,
            'nif' => $request->nif,
            'logotipo' => $photoName,
            'file_alvara' => $file_alvara,
            'file_nif' => $file_nif,
            'tipo_cliente_id' => $request->tipo_cliente_id,
            'tipo_regime_id' => $request->tipo_regime_id,
            'website' => $request->website,
            'email' => $request->email,
            'cidade' => $request->cidade,
        ]);
        $this->atualizarEmpresaAdmin($request);
    }
    public function atualizarEmpresaAdmin($request)
    {
        DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->update([
            'nome' => $request->nome,
            'pessoal_Contacto' => $request->pessoal_Contacto,
            'endereco' => $request->endereco,
            'pais_id' => $request->pais_id,
            'status_id' => 1,
            'nif' => $request->nif,
            'logotipo' => $request->photoName,
            'file_alvara' => $request->file_alvara,
            'file_nif' => $request->file_nif,
            'tipo_cliente_id' => $request->tipo_cliente_id,
            'tipo_regime_id' => $request->tipo_regime_id,
            'website' => $request->website,
            'email' => $request->email,
            'cidade' => $request->cidade,
        ]);
    }
}
