<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Role;
use Illuminate\Support\Str;

class RoleRepository
{

    private $entity;

    public function __construct(Role $entity)
    {
        $this->entity = $entity;
    }


    public function listarPerfis($search = null)
    {
        $perfis = $this->entity::with(['statuGeral'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->orwhere('empresa_id', NULL)
            ->search(trim($search))->paginate();
        return $perfis;
    }
    public function getPerfil($uuid)
    {
        $perfil = $this->entity::with(['statuGeral'])
            ->where('uuid', $uuid)
            ->where('empresa_id', auth()->user()->empresa_id)->first();



        return $perfil;
    }
    public function store($data)
    {
        $perfil = $this->entity::create([
            'designacao' => $data['designacao'],
            'status_id' => $data['status_id'],
            'empresa_id' => auth()->user()->empresa_id,
            'uuid' => Str::uuid()
        ]);
        return $perfil;
    }
    public function update($data)
    {
        $perfil = $this->entity::where('id', $data['id'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->update([
                'designacao' => $data['designacao'],
                'status_id' => $data['status_id']
            ]);
        return $perfil;
    }
}
