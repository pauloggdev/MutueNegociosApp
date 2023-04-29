<?php

namespace App\Http\Controllers\admin\Users;

use App\Http\Controllers\admin\ReportAdminController;
use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;


    public $search = null;
    public $byStatus = null;
    public $perpage = 15;

    private $userRepository;
    private $relatorioRepository;
    private $statuRepository;

    public function boot(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function render()
    {
        $users = $this->userRepository->getUsers($this->byStatus, $this->search, $this->perpage);
        return view('admin.usuarios.index', [
            'users' => $users
        ])->layout('layouts.appAdmin');
    }
    public function imprimirUtilizadores()
    {

        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/admin/relatorios/';

        $filename = "utilizadores";

        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'logotipo' => $logotipo,
                    'diretorio' => $caminho
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
