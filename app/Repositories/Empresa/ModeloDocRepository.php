<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\ModeloFactura;
use Illuminate\Support\Facades\DB;

class ModeloDocRepository
{
    protected $entity;

    public function __construct(ModeloFactura $entity)
    {
        $this->entity = $entity;
    }

    public function getModeloDocumentos($search = null)
    {
        $documentos = $this->entity::with(['modeloDocumentoAtivo'])->search(trim($search))
        ->paginate();
        return $documentos;
    }
    public function checkedModeloDocumento($modelo){


        $documentoAtivo = DB::table('modelo_documento_ativo')->where('empresa_id', auth()->user()->empresa_id)->first();


        if($documentoAtivo){
            DB::table('modelo_documento_ativo')->where('empresa_id', auth()->user()->empresa_id)->delete();
           
        }
        $documentoAdd  = DB::table('modelo_documento_ativo')->insert([
            'modelo_id' => $modelo['id'],
            'empresa_id' => auth()->user()->empresa_id
        ]);

        return $documentoAdd;


    }
}
