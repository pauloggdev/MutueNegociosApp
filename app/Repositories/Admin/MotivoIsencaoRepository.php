<?php

namespace App\Repositories\Admin;

use App\Models\admin\Motivo_Iva;

class MotivoIsencaoRepository
{

    protected $motivoIsencao;

    public function __construct(Motivo_Iva $motivoIsencao)
    {
        $this->motivoIsencao = $motivoIsencao;
    }

    public function createMotivoIsencao(array $data)
    {

        // dd($data);
        $motivoIsencao  = $this->motivoIsencao::create([
            'codigoMotivo' => $data['codigoMotivo'],
            'descricao' => $data['descricao'],
            'codigoStatus' => $data['codigoStatus'],
            'canal_id' => 3,
            'user_id' => auth()->user()->id,
            'status_id' => $data['codigoStatus'],
            'empresa_id' => 1
        ]);
        return $motivoIsencao;
    }
    public function updateMotivoIsencao($data)
    {

        // dd($data);

        $motivoIsencao  = $this->motivoIsencao::where('codigo', $data['codigo'])->update([
            'codigoMotivo' => $data['codigoMotivo'],
            'descricao' => $data['descricao'],
            'codigoStatus' => $data['codigoStatus'],
            'canal_id' => 3,
            'status_id' => $data['codigoStatus'],
        ]);

        return $motivoIsencao;
    }
    public function deletarMotivoIsencao($motivoIsencaoId)
    {
        return $this->motivoIsencao::where('codigo', $motivoIsencaoId)->delete();
    }


    public function getMotivosIsencao($search)
    {
        $motivos = $this->motivoIsencao::with(['statuGeral'])->search(trim($search))->paginate();
        return $motivos;
    }

    public function getMotivoIsencao(int $id)
    {
        $motivoIsencao = $this->motivoIsencao::find($id);
        return $motivoIsencao;
    }
}
