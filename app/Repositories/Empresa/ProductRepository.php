<?php
namespace App\Repositories\Empresa;

use App\Models\empresa\Statu;
use App\Models\empresa\Produto;
use App\Interfaces\Empresa\CrudDao;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Illuminate\Http\Request;



class ProductRepository implements CrudDao{

    use TraitEmpresaAutenticada;

    private $admin_system = 1;
    private $empresa_system = 2;
    private $funcionario_system = 3;

    protected $model = Produto::class;


    public function all(){

        $STATUS_ATIVO = 1;

        $resultado = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $resultado['guard'];
        $data['status'] = Statu::all();
        $data['produtos'] = $this->model::with('statuGeral')->where('empresa_id', $resultado['empresa']['id'])->where('status_id', $STATUS_ATIVO)->get();
    
        return $data;

    }
    public function store(Request $request){

        

    }

    public function update(Request $request, $id){
        
    }
    public function destroy($id){

    }
}