<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeController extends Component
{

    public function index()
    {

        $data['auth'] = Auth::user();
        $data['countusers'] = DB::connection('mysql')->table('users_admin')->count();
        $data['countclientes'] = DB::connection('mysql')->table('empresas')->where('id', '!=', 1)->count();
        $data['countlicencas'] = DB::connection('mysql')->table('licencas')->count();
        $data['countlicencasativas'] = DB::connection('mysql')->table('activacao_licencas')
            ->where('status_licenca_id', 1)
            ->count();

        $data['countlicencaspendente'] = DB::connection('mysql')->table('activacao_licencas')->where('status_licenca_id', 3)->where('licenca_id', '!=', 4)->count();
        $data['countlicencasrejeitada'] = DB::connection('mysql')->table('activacao_licencas')->where('status_licenca_id', 2)->count();
        $data['countbancos'] = DB::connection('mysql')->table('bancos')->count();


        $data['licencasMaisVendido'] = DB::connection('mysql')
            ->select('
        select licencas.designacao, count(activacao_licencas.licenca_id) AS quantidade, 
        SUM(licencas.valor) AS total_preco from activacao_licencas 
        INNER JOIN licencas ON activacao_licencas.licenca_id = licencas.id 
        where activacao_licencas.data_activacao 
        GROUP by activacao_licencas.licenca_id 
        order by count(activacao_licencas.licenca_id) desc
        
        ');

        $currentYear = now()->year;
        $data['licencaativasmensal'] = DB::connection('mysql')
            ->table('activacao_licencas')
            ->join('licencas', 'activacao_licencas.licenca_id', 'licencas.id')
            ->select(DB::raw('SUM(licencas.valor) as total_licenca, MONTH(activacao_licencas.created_at) AS mes'))
            ->groupBy(DB::raw('MONTH(activacao_licencas.created_at)'))
            ->whereRaw("YEAR(activacao_licencas.created_at) = {$currentYear}")
            ->get();

        return view('admin.dashboard', $data);
    }
}
