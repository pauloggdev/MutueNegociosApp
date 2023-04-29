<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\Classificacao;
class ClassificacaoRepository
{
    protected $entity;

    public function __construct(Classificacao $entity)
    {
        $this->entity = $entity;
    }
    public function store($data)
    {
        $classificacao = $this->entity::where('produto_id', $data['produto_id'])
        ->where('user_id', auth()->user()->id)->first();
        if($classificacao){
            return $classificacao->update([
                'num_classificacao' => $data['num_classificacao']
            ]);
        }
        return $this->entity::create([
            'produto_id' => $data['produto_id'],
            'user_id' => auth()->user()->id,
            'num_classificacao' => $data['num_classificacao'],
        ]);
    }
}
