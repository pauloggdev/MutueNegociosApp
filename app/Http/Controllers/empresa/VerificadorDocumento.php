<?php


namespace App\Http\Controllers\empresa;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;



class VerificadorDocumento extends Controller
{


    private $tabela;

    public function __construct($tabela)
    {
        $this->tabela = $tabela;
    }

    public function pegarIdEmpresaAuth()
    {
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresaId = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresaId = Auth::user()->empresa_id;
        }

        return $empresaId;
    }
    public function comparaDataDocumentoAnteriorComActual($numeracaoDocumento = "numeracaoFactura")
    {


        $empresaSerie = DB::table('series_documento')->where('empresa_id', auth()->user()->empresa_id)->first();
        $serieDocumento = $empresaSerie ? $empresaSerie->serie : mb_strtoupper(substr(auth()->user()->empresa->nome, 0, 3));

        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        $query = DB::table($this->tabela)->where('empresa_id', $this->pegarIdEmpresaAuth())
            ->where($numeracaoDocumento, 'like', '%' . $serieDocumento . '%')
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();

        if ($query == null) {
            return true;
        }

        if ($query) {

            $dataAnteriorDocumento = Carbon::createFromFormat('Y-m-d H:i:s', $query->created_at);
            $dataAtualDocumento = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            //$dataAtualDocumento = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-21 12:42:13');
            if ($dataAtualDocumento > $dataAnteriorDocumento) {
                return true;
            } else {
                return false;
            }
        }
    }
}
