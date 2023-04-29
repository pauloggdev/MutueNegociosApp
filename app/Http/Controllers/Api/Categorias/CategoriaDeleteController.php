<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoriaRepository;
use App\Repositories\Admin\MarcaRepository;
use Illuminate\Http\Request;


class CategoriaDeleteController extends Controller
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function destroy($categoriaId)
    {
        $categoria =  $this->categoriaRepository->destroy($categoriaId);
        if ($categoria)
            return response()->json($categoria, 200);
    }
}
