<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Banco;
use Illuminate\Support\Str;
use Keygen\Keygen;

class BancoRepository
{

    protected $entity;

    public function __construct(Banco $armazen)
    {
        $this->entity = $armazen;
    }
    public function quantidadeBancos(){
        return $this->entity::where('empresa_id', auth()->user()->empresa_id)->count();
    }

    public function getBancos($search = null)
    {
        $armazen = $this->entity::with(['statuGeral'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate(10);
        return $armazen;
    }

    public function getBanco(int $id)
    {
        $armazen = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $armazen;
    }
    public function store($data)
    {
        $banco = $this->entity::create([
            'designacao' => $data['designacao'],
            'sigla' => $data['sigla'],
            'num_conta' => $data['num_conta'],
            'uuid' => (string) Str::uuid(),
            'iban' => $data['iban'],
            'status_id' => $data['status_id'],
            'canal_id' => $data['canal_id'] ?? 2,
            'empresa_id' => auth()->user()->empresa_id,
            'user_id' => auth()->user()->id,
            'tipo_user_id' => 2
        ]);
        return $banco;
    }

    public function update($banco)
    {
        $banco = $this->entity::where('id', $banco['id'])->update([
            'designacao' => $banco['designacao'],
            'sigla' => $banco['sigla'],
            'num_conta' => $banco['num_conta'],
            'iban' => $banco['iban'],
            'status_id' => $banco['status_id'],
            'empresa_id' => auth()->user()->empresa_id,
        ]);
        return $banco;
    }
    public function deletarBanco($bancoId)
    {
        return $this->entity::where('id', $bancoId)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->delete();
    }
}
