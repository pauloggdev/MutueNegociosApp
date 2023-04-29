<?php

namespace App\Repositories\Admin;

use App\Models\admin\Empresa;

class EmpresaRepository
{

    protected $entity;

    public function __construct(Empresa $empresa)
    {
        $this->entity = $empresa;
    }

    public function getEmpresaPelaReferencia($referencia){
        return $this->entity::where('referencia', $referencia)->first();
    }

    public function getEmpresaAdmin()
    {
        $empresa = $this->entity::where('id', 1)->first();
        return $empresa;
    }
    public function atualizarEmpresa($data)
    {

        if (isset($data['logotipoAtual']) && !empty($data['logotipoAtual'])) {
            unlink(public_path() . "\\upload\\" . $data['logotipo']);
            $data['logotipo'] = $data['logotipoAtual']->store("/admin");
        }
        $this->entity::where('id', $data['id'])->update([
            'nome' => $data['nome'],
            'nif' => $data['nif'],
            'pessoal_Contacto' => $data['pessoal_Contacto'],
            'email' => $data['email'],
            'pessoa_de_contacto' => $data['pessoa_de_contacto'],
            'endereco' => $data['endereco'],
            'tipo_regime_id' => $data['tipo_regime_id'],
            'website' => $data['website'],
            'cidade' => $data['cidade'],
            'logotipo' => $data['logotipo']
        ]);
    }
}
