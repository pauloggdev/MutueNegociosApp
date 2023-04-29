<?php

namespace App\Http\Controllers\empresa\Usuarios;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\empresa\ReportShowController;
use App\Jobs\JobCreateNewUser;
use App\Repositories\Admin\ActivacaoLicencaRepository;
use App\Repositories\Admin\FacturaUserAdicionarRepository;
use App\Repositories\Admin\LicencaRepository;
use App\Repositories\Empresa\RoleRepository;
use App\Repositories\Empresa\UserRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use NumberFormatter;

class UsuarioCreateController extends Component
{

    use LivewireAlert;
    use WithFileUploads;


    public $user;
    private $userRepository;
    private $roleRepository;
    private $activacaoRepository;
    private $facturaUserAdicionarRepository;
    public $qtyUser;
    protected $PERCENTAGEM_ADICIONAR_USER = 20;



    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        ActivacaoLicencaRepository $activacaoRepository,
        FacturaUserAdicionarRepository $facturaUserAdicionarRepository

    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->activacaoRepository = $activacaoRepository;
        $this->facturaUserAdicionarRepository = $facturaUserAdicionarRepository;
    }

    public function render()
    {
        $this->qtyUser = $this->userRepository->quantidadeUsers();
        $data['roles'] = $this->roleRepository->listarPerfis();
        return view('empresa.usuarios.create', $data);
    }
    public function salvarUtilizador()
    {

        // $this->gerarFacturaPagamentoAdicionalLicencaCadastradoUtilizador($user = 649);
        // return;


        $rules = [
            'user.name' => 'required',
            'user.email' => [
                "required", function ($attr, $value, $fail) {
                    $user =  DB::table('users_cliente')
                        ->where('empresa_id', auth()->user()->empresa_id)
                        ->where('email', $value)
                        ->first();

                    if ($user) {
                        $fail("E-mail já cadastrado");
                    }
                }
            ],
            'user.telefone' => "required",
            'user.status_id' => "required",
        ];
        $messages = [
            'user.name.required' => 'Informe o nome',
            'user.email.required' => 'Informe o email',
            'user.telefone.required' => 'Informe o número telefone',
            'user.status_id.required' => 'Informe o status',
        ];

        $this->validate($rules, $messages);


        if (count($this->user['roles']) <= 0) {
            $this->confirm('Informe pelo menos uma função', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        }

        $user = $this->userRepository->createNewUser($this->user);

        $dado = [
            'email' => $this->user['email'],
            'senha' => 'mutue123'
        ];
        JobCreateNewUser::dispatch($dado)->delay(now()->addSecond('5'));

        $this->setarValorPadrao();
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
        if ($this->qtyUser >= 2) {
            $this->gerarFacturaPagamentoAdicionalLicencaCadastradoUtilizador($user);
        }
    }
    public function gerarFacturaPagamentoAdicionalLicencaCadastradoUtilizador($user)
    {
        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $licenca = $this->activacaoRepository->pegarUltimaLicencaActiva();
        $data['valor_pagar'] = $licenca->valor * $this->PERCENTAGEM_ADICIONAR_USER / 100;
        $data['valor_extenso'] = $f->format($data['valor_pagar']);
        $data['licenca'] = $licenca;
        $data['user'] = $user;

        $facturaId =  $this->facturaUserAdicionarRepository->salvarFacturaUtilizadorAdicionado($data);
        return $this->imprimirFacturaAdicionarUtilizador($facturaId);

    }
    public function imprimirFacturaAdicionarUtilizador($facturaId)
    {

        $filename = 'facturaUsuarioAdicionalA4Admin';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $DIR = public_path() . "/upload/documentos/admin/relatorios/";


        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'facturaId' => $facturaId,
                    'logotipo' => $logotipo,
                    'empresa_id' => $empresaCliente->id,
                    'EmpresaNome' => $empresa->nome,
                    'EmpresaEndereco' => $empresa->endereco,
                    'EmpresaNif' => $empresa->nif,
                    'EmpresaTelefone' => $empresa->pessoal_Contacto,
                    'EmpresaEmail' => $empresa->email,
                    'EmpresaWebsite' => $empresa->website,
                    'operador' => auth()->user()->name,
                    'DIR' => $DIR
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }

    public function setarValorPadrao()
    {
        $this->user['name'] = NULL;
        $this->user['username'] = NULL;
        $this->user['email'] = NULL;
        $this->user['telefone'] = NULL;
        $this->user['status_id'] = 1;
        $this->user['role_id'] = 2;
        $this->user['roles'] = [];
    }
}
