<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoriaRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class CategoriaCreateController extends Controller
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function store(Request $request)
    {
        $messages = [
            'designacao.required' => 'Informe a categoria',
            'designacao.unique' => 'Categoria já cadastrado',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => 'required|unique:categoria_produtos',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $categoria =  $this->categoriaRepository->store($request->all());
        if ($categoria)
            return response()->json($categoria, 200);
    }
}
