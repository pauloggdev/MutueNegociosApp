<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa\TipoDocumento;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;

class TipoDocumentoController extends Controller
{

    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    //API
    public function listarTipoDocumentos()
    {


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $tipoDocumentos = TipoDocumento::all();

        return response()->json($tipoDocumentos, 200);
    }

    public function listarDocumentoVenda(){

        $tipoDocumentos = TipoDocumento::where('id','<', 4)->get();
        return response()->json($tipoDocumentos, 200);

    }
}
