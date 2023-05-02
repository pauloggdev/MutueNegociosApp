<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Categoria;
use App\Models\empresa\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriaRepository
{
    protected $entity;
    public $categoria = [];


    public function __construct(Categoria $categoria)
    {
        $this->entity = $categoria;
    }

    public function getCategoriasComDiversos()
    {
        return $this->entity = Categoria::where('empresa_id', NULL)
            ->orwhere('empresa_id', auth()->user()->empresa_id)
            ->orderBy('id')
            ->get();
    }
    public function mv_listarCategoriasSemPaginacao($search = null)
    {
        $categoriaIds = DB::connection('mysql2')->table('produtos')->where('venda_online', 'Y')->pluck('categoria_id');

        // dd($categoriaIds);
        // $categorias = $this->entity::whereIn('id', $categoriaIds)->search(trim($search))->get();

        // foreach ($categorias as $key => $categoria) {
        //     $this->categorias[] = $this->arrayCat($categoria);
        //     $subCategorias = $this->getSubcategorias($categoria);
        //     foreach ($subCategorias as $subCategoria) {
        //         $this->categorias[$key]['subCategoria'][] = $this->arrayCat($subCategoria);
        //     }
        // }

        // dd($this->categorias);
        // return $categorias;
        $this->exibirCategorias($categoriaIds);
    }
    public function exibirCategorias($categoriaIds, $parent_id = NULL, $nivel = 0)
    {
        $categorias = $this->entity::whereIn('id', $categoriaIds)->get();
        foreach ($categorias as $key => $cat) {
            if ($cat['categoria_pai'] == NULL) {
                $this->categoria[] = $this->arrayCat($cat);
            } else {
                $subCategorias = $this->entity::wherein('id', $categoriaIds)
                    ->where('categoria_pai', $cat['categoria_pai'])
                    ->get();

                foreach ($subCategorias as $key => $sub) {
                    //aqui pegar a posição do array
                    $categoria = $this->getCategoriaCollection($sub['categoria_pai']);

                    dd($categoria);
                    $categoria['subCategoria'][] = $this->arrayCat($sub);
                    // $this->categoria[$key]['subCategoria'][] = $this->arrayCat($cat);
                }


                // dd($teste);

                // $this->categoria[$key]['subCategoria'][] = $this->arrayCat($cat);

                // $this->exibirCategorias($categoriaIds, $cat['categoria_pai'], $nivel + 1);
            }
        }


        dd($this->categoria);
    }

    public function getCategoriaCollection($categoriaId)
    {
        
        return collect($this->categoria)->firstWhere('id', $categoriaId);
    }



    public function arrayCat($categoria)
    {
        return [
            'id' => $categoria['id'],
            'designacao' => $categoria['designacao'],
            'imagem' => $categoria['imagem'],
            'categoria_pai' => $categoria['categoria_pai'],
            'subCategoria' => []
        ];
    }
    public function getSubcategorias($categoria)
    {
        return $this->entity::where('categoria_pai', $categoria['id'])
            ->where('id', '!=', $categoria['id'])
            ->get();
    }
    // public function mv_listarCategoriasSemPaginacao($search = null)
    // {
    //     $categoriaIds = DB::connection('mysql2')->table('produtos')->where('venda_online', 'Y')->pluck('categoria_id');
    //     $categorias = $this->entity::whereIn('id', $categoriaIds)->search(trim($search))->get();
    //     return $categorias;
    // }
    public function getCategorias()
    {
        $categoria = $this->entity = Categoria::with(['statuGeral', 'empresa', 'produtos', 'categoria'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->get();
        return $categoria;
    }

    public function getCategoria(int $id)
    {

        $categoria = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $categoria;
    }

    public function store($data)
    {
        $categoria = $this->entity::create([
            'designacao' => $data['designacao'],
            'user_id' => auth()->user()->id,
            'empresa_id' => auth()->user()->empresa_id,
            'status_id' => 1,
            'canal_id' => isset($data['canal_id'])  ? $data['canal_id'] : 2,
            'imagem' => env('APP_URL') . "upload/" . $this->uploadFile($data['imagem'])
        ]);

        $this->entity::where('id', $categoria->id)->update([
            'categoria_pai' => $data['categoria_pai'] ?? $categoria->id
        ]);
        return $categoria;
    }
    public function uploadFile($newImagem, $imagemAnterior = null)
    {
        if ($imagemAnterior) {
            $path = public_path() . "/" . str_replace(env('APP_URL'), "", $imagemAnterior);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return Storage::disk('public')->putFile('categorias', $newImagem);
    }
    public function addSubCategoria($categoriaId, $subCategorias)
    {
        foreach ($subCategorias as $key => $sub) {
            $this->entity::create([
                'designacao' => $sub['designacao'],
                'user_id' => auth()->user()->id,
                'empresa_id' => auth()->user()->empresa_id,
                'status_id' => 1,
                'categoria_pai' => $categoriaId,
                'imagem' => env('APP_URL') . "upload/" . $this->uploadFile($sub['imagem'])
            ]);
        }
        return $categoriaId;
    }

    public function update($data)
    {

        $categoria = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $data['id'])
            ->update([
                'status_id' => $data['status_id'],
                'designacao' => $data['designacao'],
                'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,
                'imagem' => $data['newImagem'] ? env('APP_URL') . "upload/" . $this->uploadFile($data['newImagem'], $data['imagem']) : $data['imagem']
            ]);

        return $categoria;
    }
}
