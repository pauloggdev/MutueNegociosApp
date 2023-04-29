<?php

namespace App\Http\Controllers\Api\Categorias;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\CategoriaRepository;

class CategoriaIndexController extends Controller
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository )
    {
        $this->categoriaRepository = $categoriaRepository;
    }
    public function mv_listarCategoriasSemPaginacao($search = null){
        return $this->categoriaRepository->mv_listarCategoriasSemPaginacao($search);
    }

}
