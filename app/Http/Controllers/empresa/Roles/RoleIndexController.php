<?php

namespace App\Http\Controllers\empresa\Roles;

use App\Repositories\Empresa\RoleRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Livewire\Component;

class RoleIndexController extends Component
{

    use TraitEmpresaAutenticada;

    public $search;
    private $roleRepository;

    public function boot(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        $data['perfis'] = $this->roleRepository->listarPerfis($this->search);
        return view('empresa.roles.index', $data);
    }
    public function printNotaDebito($notaDebito)
    {
        /*

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'notaDebito',
                'report_jrxml' => 'notaDebito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'notaDebitoId' => $notaDebito['id'],
                    'logotipo' => $logotipo
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
        */
    }
}
