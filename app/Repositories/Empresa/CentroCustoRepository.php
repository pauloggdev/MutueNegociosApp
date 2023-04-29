<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\CentroCusto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CentroCustoRepository
{

    protected $entity;

    public function __construct(CentroCusto $centroCusto)
    {
        $this->entity = $centroCusto;
    }
    public function getCentroCusto($uuid){
        return $this->entity->where('uuid', $uuid)
        ->where('empresa_id', auth()->user()->empresa_id)
        ->first();
    }
    public function listarCentrosCusto($search){
        return $this->entity::with(['statu'])->where('empresa_id', auth()->user()->empresa_id)
        ->search(trim($search))
        ->paginate(10);
    }
    public function store($request)
    {
        //Adicionar logotipo
        $request = (object) $request;
        if ($request->newLogotipo) {
            $logotipo = $request->newLogotipo->store("/utilizadores/cliente");
        } else {
            $logotipo = auth()->user()->empresa->logotipo;
        }
        //Alvará
        if ($request->newAlvara) {
            $file_alvara = $request->newAlvara->store("/documentos/empresa/documentos");
        } else {
            $file_alvara = auth()->user()->empresa->file_alvara;
        }
        //NIF
        if ($request->newNIF) {
            $file_nif = $request->newNIF->store("/documentos/empresa/documentos");
        } else {
            $file_nif = auth()->user()->empresa->file_nif;
        }

        return DB::table('centro_custos')->insertGetId([
            'uuid' => Str::uuid(),
            'nome' => $request->nome,
            'empresa_id' => auth()->user()->empresa_id,
            'status_id' => $request->status_id,
            'endereco' => $request->endereco,
            'nif' => $request->nif,
            'cidade' => $request->cidade,
            'logotipo' => $logotipo,
            'email' => $request->email,
            'website' => $request->website ?? null,
            'telefone' => $request->telefone,
            'pessoa_de_contacto' => $request->pessoa_de_contacto ?? null,
            'file_alvara' => $file_alvara,
            'file_nif' => $file_nif,
        ]);
    }
    public function update($request)
    {
        //Adicionar logotipo

        $request = (object) $request;


        $logotipo = $request->logotipo;
        if ($request->newLogotipo) {
            if (Storage::exists($request->logotipo)) {
                Storage::delete($request->logotipo);
            }
            $logotipo = $request->newLogotipo->store("/utilizadores/cliente");
        }
        //Alvará
        $file_alvara = $request->file_alvara;
        if ($request->newAlvara) {
            if (Storage::exists($request->file_alvara)) {
                Storage::delete($request->file_alvara);
            }
            $file_alvara = $request->newAlvara->store("/documentos/empresa/documentos");
        }
        //NIF
        $file_nif = $request->file_nif;
        if ($request->newNIF) {
            if (Storage::exists($request->file_nif)) {
                Storage::delete($request->file_nif);
            }
            $file_nif = $request->newNIF->store("/documentos/empresa/documentos");
        }

        return DB::table('centro_custos')->where('uuid', $request->uuid)->where('empresa_id', auth()->user()->empresa_id)->update([
            'nome' => $request->nome,
            'status_id' => $request->status_id,
            'endereco' => $request->endereco,
            'nif' => $request->nif,
            'cidade' => $request->cidade,
            'logotipo' => $logotipo,
            'email' => $request->email,
            'website' => $request->website ?? null,
            'telefone' => $request->telefone,
            'pessoa_de_contacto' => $request->pessoa_de_contacto ?? null,
            'file_alvara' => $file_alvara,
            'file_nif' => $file_nif,
        ]);
    }
}
