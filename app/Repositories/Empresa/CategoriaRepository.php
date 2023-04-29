<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Categoria;
use App\Models\empresa\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriaRepository
{
    protected $entity;
    public $categorias = [];


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
        $categorias = $this->entity::whereIn('id', $categoriaIds)->search(trim($search))->get();

        foreach ($categorias as $key => $categoria) {
            $this->categorias[] = $this->arrayCat($categoria);
            $subCategorias = $this->getSubcategorias($categoria);
            foreach ($subCategorias as $subCategoria) {
                $this->categorias[$key]['subCategoria'][] = $this->arrayCat($subCategoria);
            }
        }

        dd($this->categorias);
        return $categorias;
    }
    public function arrayCat($categoria)
    {
        return [
            'id' => $categoria['id'],
            'designacao' => $categoria['designacao'],
            'imagem' => $categoria['imagem'],
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
