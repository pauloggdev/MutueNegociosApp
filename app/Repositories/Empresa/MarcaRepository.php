<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\Marca;

class MarcaRepository
{
    protected $entity;

    public function __construct(Marca $marca)
    {
        $this->entity = $marca;
    }


    public function getMarcas()
    {
        $marcas = $this->entity = Marca::with(['statuGeral', 'empresa'])
            ->where('empresa_id', auth()->user()->empresa_id)->get();
        return $marcas;
    }

    public function getMarca(int $id)
    {
        $marca = $this->entity::where('empresa_id', auth()->user()->empresa_id)
        ->where('id', $id)
        ->first();
        return $marca;

    }

    public function store($data)
    {
        $marcas = $this->entity::create([
            'designacao' => $data['designacao'],
            'user_id' => auth()->user()->id,
            'empresa_id' => auth()->user()->empresa_id,
            'status_id' => $data['status_id'],
            'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,

        ]);

        return $marcas;
    }

    public function update($data)
    {
        
        $marca = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $data['id'])
            ->update([
           
            'user_id' => auth()->user()->id,
            'empresa_id' => auth()->user()->empresa_id,
            'status_id' => $data['status_id'],
            'designacao' => $data['designacao'],
            'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,
     
        ]);

        return $marca;
    }
}
