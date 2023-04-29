<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoriaRepository;
use App\Repositories\Admin\MarcaRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class CategoriaUpdateController extends Controller
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function update(Request $request)
    {

        $messages = [
            'designacao.required' => 'Informe a marca',
            'designacao.unique' => 'Marca já cadastrado',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => "required|unique:mysql.categoria_produtos,designacao,{$request->id},id",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $categoria =  $this->categoriaRepository->update($request->all());
        if ($categoria)
            return response()->json($categoria, 200);
    }
}
