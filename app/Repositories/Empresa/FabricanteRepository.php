<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Cliente;
use App\Models\empresa\Fabricante;
use App\Repositories\Empresa\contracts\FabricanteRepositoryInterface;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class FabricanteRepository
{

    protected $entity;

    public function __construct(Fabricante $fabricante)
    {
        $this->entity = $fabricante;
    }
    public function quantidadeFabricantes(){
        return $this->entity::where('empresa_id', auth()->user()->empresa_id)->count();
    }

    public function getFabricantes($search = null)
    {
        $fabricantes = $this->entity::with(['statuLicenca', 'statuGeral'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate();
        return $fabricantes;
    }
    public function deletarFabricante($fabricanteId)
    {
        return $this->entity::where('id', $fabricanteId)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->delete();
    }

    public function getFabricante(int $id)
    {
        $cliente = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $cliente;
    }
    public function store($data)
    {
        $fabricante = $this->entity::create([
            'designacao' => $data['designacao'],
            'empresa_id' => auth()->user()->empresa_id,
            'canal_id' =>  $data['canal_id'] ?? 2,
            'tipo_user_id' => 2,
            'status_id' => $data['status_id'] ?? 1,
            'user_id' => auth()->user()->id
        ]);
        return $fabricante;
    }

    public function update($fabricante)
    {
        $fabricante = $this->entity::where('id', $fabricante['id'])->update([
            'designacao' => $fabricante['designacao'],
            'status_id' => $fabricante['status_id']
        ]);
        return $fabricante;
    }
}
