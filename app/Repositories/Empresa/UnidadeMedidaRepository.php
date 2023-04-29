<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\UnidadeMedida;
use Illuminate\Support\Str;

class UnidadeMedidaRepository
{

    protected $entity;

    public function __construct(UnidadeMedida $unidadeMedida)
    {
        $this->entity = $unidadeMedida;
    }

    public function getUnidadeMedidas($search = null)
    {
        $unidadeMedidas = $this->entity::with(['statuGeral'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate(10);
        return $unidadeMedidas;
    }

    public function getUnidadeMedida(int $id)
    {
        $unidadeMedida = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $unidadeMedida;
    }
    public function store($data)
    {
        $unidade = $this->entity::create([
            'designacao' => $data['designacao'],
            'status_id' => $data['status_id'],
            'canal_id' => $data['canal_id'],
            'empresa_id' => auth()->user()->empresa_id,
            'user_id' => auth()->user()->id,
            'diversos' => 2 // unidade nao diverso
        ]);
        return $unidade;
    }

    public function update($unidade)
    {
        $unidade = $this->entity::where('id', $unidade['id'])->update([
            'designacao' => $unidade['designacao'],
            'status_id' => $unidade['status_id'],
        ]);
        return $unidade;
    }
    public function deletarUnidadeMedida($unidadeId)
    {
        return $this->entity::where('id', $unidadeId)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->delete();
    }
}
