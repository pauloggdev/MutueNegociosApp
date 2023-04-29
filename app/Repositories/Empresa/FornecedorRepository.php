<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Fornecedor;
use App\Repositories\Empresa\contracts\FornecedorRepositoryInterface;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class FornecedorRepository
{

    protected $entity;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->entity = $fornecedor;
    }
    public function quantidadeFornecedores(){

        return $this->entity::where('empresa_id', auth()->user()->empresa_id)->count();
    }


    public function getFornecedores($search = null)
    {
        $fornecedores = $this->entity::with(['statuLicenca', 'statuGeral', 'pais'])
            ->where('empresa_id', auth()->user()->empresa_id)->paginate();
        return $fornecedores;
    }
    public function getFornecedoresSemPaginacao()
    {
        $fornecedores = $this->entity::with(['statuLicenca', 'statuGeral', 'pais'])
            ->where('empresa_id', auth()->user()->empresa_id)->get();
        return $fornecedores;
    }

    public function getFornecedor(int $id)
    {
        $fornecedor = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $fornecedor;
    }
    public function store($data)
    {


        $fornecedor = $this->entity::create([

            'nome' => $data['nome'],
            'website' => $data['website'] ?? NULL,
            'email_empresa' => $data['email_empresa'] ?? NULL,
            'telefone_empresa' => $data['telefone_empresa'],
            'email_contacto' => $data['email_contacto'] ?? NULL,
            'telefone_contacto' => $data['telefone_contacto'] ?? NULL,
            'pessoal_contacto' => $data['pessoal_contacto'] ?? NULL,
            'endereco' => $data['endereco'],
            'user_id' => auth()->user()->id,
            'empresa_id' => auth()->user()->empresa_id,
            'status_id' => $data['status_id'] ?? 1,
            'pais_nacionalidade_id' => $data['pais_nacionalidade_id'],
            'tipo_user_id' => 2,
            'canal_id' => 4,
            'data_contracto' => $data['data_contracto'],
            'nif' => $data['nif'],
            'conta_corrente' => $this->contaCorrente()
        ]);

        return $fornecedor;
    }

    private function contaCorrente()
    {
        $resultado =  DB::connection('mysql2')->table('fornecedores')->orderBy('id', 'DESC')
            ->where('empresa_id', auth()->user()->empresa_id)->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->conta_corrente);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string) $ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            $contaCorrente = "31.1.2.1.1";
        }

        return $contaCorrente;
    }
    public function update($data)
    {

        $fornecedor = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $data['id'])
            ->update([
                'nome' => $data['nome'],
                'website' => $data['website'],
                'email_empresa' => $data['email_empresa'],
                'telefone_empresa' => $data['telefone_empresa'],
                'email_contacto' => $data['email_contacto'],
                'telefone_contacto' => $data['telefone_contacto'],
                'pessoal_contacto' => $data['pessoal_contacto'],
                'endereco' => $data['endereco'],
                'user_id' => auth()->user()->id,
                'empresa_id' => auth()->user()->empresa_id,
                'status_id' => $data['status_id'],
                'pais_nacionalidade_id' => $data['pais_nacionalidade_id'],
                'tipo_user_id' => 2,
                'canal_id' => 4,
                'data_contracto' => $data['data_contracto'],
                'nif' => $data['nif']
            ]);

        return $fornecedor;
    }
}
