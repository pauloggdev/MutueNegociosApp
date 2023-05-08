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
    public $arrayIds = [];


    public function __construct(Categoria $categoria, Produto $produto = null)
    {
        $this->entity = $categoria;
        $this->produto = $produto;
    }

    public function getCategoriasComDiversos()
    {
        return $this->entity = Categoria::where('empresa_id', NULL)
            ->orwhere('empresa_id', auth()->user()->empresa_id)
            ->orderBy('id')
            ->get();
    }
    public function add()
    {
        $categoriaIds = DB::connection('mysql2')->table('produtos')->where('venda_online', 'Y')->pluck('categoria_id');
        $this->exibirCategorias($categoriaIds);
    }
    public function exibirCategorias($categoriaIds)
    {
        $categorias = $this->entity::whereIn('id', $categoriaIds)->get();
        foreach ($categorias as $key => $cat) {
            if ($cat['categoria_pai'] == NULL) {
                $this->categoria[] = $this->arrayCat($cat);
            } else {
                $subCategorias = $this->entity::where('categoria_pai', $cat['categoria_pai'])->get();
                $key = $this->posicaoPai($subCategorias[0]['categoria_pai']);
                foreach ($subCategorias as $subCategoria) {
                    $this->categoria[$key]['subCategoria'][] = $this->arrayCat($subCategoria);
                }
            }
        }
        dd($this->categoria);
        return $this->categoria;
    }

    public function posicaoPai($categoriaId)
    {
        for ($i = 0, $l = count($this->categoria); $i < $l; ++$i) {
            if (in_array($categoriaId, $this->categoria[$i])) return $i;
        }
        return false;
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
    public function mv_listarCategoriasSemPaginacao($search = null)
    {
        $categoriaIds = DB::connection('mysql2')->table('produtos')->where('venda_online', 'Y')->pluck('categoria_id');
        $categorias = $this->entity::whereIn('id', $categoriaIds)->search(trim($search))->get();
        return $categorias;
    }
    public function categoriasComHierarquia($categorias = null)
    {


        $categorias = [
            [
                "id" => 1,
                "designacao" => "Electronico",
                "parent" => null
            ],
            [
                "id" => 2,
                "designacao" => "Telefone",
                "parent" => 1
            ],
            [
                "id" => 3,
                "designacao" => "Iphone",
                "parent" => 2
            ],
            [
                "id" => 4,
                "designacao" => "Computador",
                "parent" => 1
            ],
            [
                "id" => 5,
                "designacao" => "Informática",
                "parent" => null
            ],
            [
                "id" => 6,
                "designacao" => "Vestimenta",
                "parent" => null
            ],
            [
                "id" => 7,
                "designacao" => "Comidas",
                "parent" => null
            ],
            [
                "id" => 8,
                "designacao" => "Macacão",
                "parent" => 6
            ],
            [
                "id" => 9,
                "designacao" => "Frutas",
                "parent" => 7
            ],
            [
                "id" => 10,
                "designacao" => "Banana",
                "parent" => 9
            ]

        ];

        $categoriasComFilhos = [];
        $categoriasPorId = [];
        // Primeiro, criamos um mapa das categorias por ID para facilitar a pesquisa por parent.
        foreach ($categorias as $categoria) {
            $categoriasPorId[$categoria['id']] = [
                'id' => $categoria['id'],
                'designacao' => $categoria['designacao'],
                'children' => []
            ];
        }
        foreach ($categorias as $categoria) {
            $index = $categoria['parent'];
            if ($index) {
                $pai = $categoriasPorId[$index];
                array_push($pai['children'], $categoriasPorId[$categoria['id']]);
            } else {
                array_push($categoriasComFilhos, $categoriasPorId[$categoria['id']]);
            }
        }
        dd($categoriasComFilhos);
        return $categoriasComFilhos;
        // categorias.forEach(categoria => {
        //   categoriasPorId[categoria.id] = {id: categoria.id, designacao: categoria.designacao, children: []};
        // });

        // Em seguida, percorremos as categorias novamente, adicionando cada categoria como um filho da categoria pai apropriada.
        // categorias.forEach(categoria => {
        //   const pai = categoriasPorId[categoria.parent];
        //   if (pai) {
        //     pai.children.push(categoriasPorId[categoria.id]);
        //   } else {
        //     categoriasComFilhos.push(categoriasPorId[categoria.id]);
        //   }
        // });

        // return categoriasComFilhos;
    }

    //   const result = categoriasComHierarquia(categorias);
    //   console.log(result);
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


    //   const result = categoriasComHierarquia(categorias);
    //   console.log(result);
}
