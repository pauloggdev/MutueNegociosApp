<?php

namespace App\Http\Controllers\empresa\Roles;

use App\Repositories\Empresa\RoleRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RoleCreateController extends Component
{

    use TraitEmpresaAutenticada;
    use LivewireAlert;

    public $role;
    public $search;
    private $roleRepository;

    public function __construct()
    {
        $this->setarValorPadrao();
    }
    public function setarValorPadrao()
    {
        $this->role['status_id'] = 1;
        $this->role['designacao'] = NULL;
    }

    public function boot(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        $data['perfis'] = $this->roleRepository->listarPerfis($this->search);
        return view('empresa.roles.create', $data);
    }
    public function salvarPerfil()
    {
        $rules = [
            'role.designacao' => ["required", function ($attr, $value, $fail) {

                $role = DB::table('perfils')
                    ->where('designacao', $value)
                    ->where(function ($query) {
                        $query->orwhere('empresa_id', auth()->user()->empresa_id)
                            ->orwhere('empresa_id', NULL);
                    })
                    ->first();
                if ($role) {
                    $fail("Função já cadastrado");
                }
            }],
            "role.status_id" => "required"

        ];
        $messages = [
            'role.designacao.required' => 'Informe a função',
            'role.status_id.required' => 'Informe o status',
        ];

        $this->validate($rules, $messages);
        
        $this->roleRepository->store($this->role);
        $this->setarValorPadrao();

        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success',

        ]);
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
