<?php

namespace App\Http\Controllers\empresa\Usuarios;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Admin\FacturaUserAdicionarRepository;
use App\Repositories\Empresa\UserRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsuarioIndexController extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    use LivewireAlert;
    use WithFileUploads;



    public $banco;
    public $userId;
    public $search = null;
    public $utilizadorId;
    public $comprovativoPgtFactura;
    public $numero_operacao_bancaria;
    private $userRepository;
    private $facturaUserAdicionarRepository;
    protected $listeners = ['deletarUtilizador'];

    public function updatingSearch()
    {
        $this->emit('refresh');
    }
    public function paginationView()
    {
        return 'livewire::' . (property_exists($this, 'paginationTheme') ? $this->paginationTheme : 'tailwind');
    }

    public function boot(UserRepository $userRepository, FacturaUserAdicionarRepository $facturaUserAdicionarRepository)
    {
        $this->userRepository = $userRepository;
        $this->facturaUserAdicionarRepository = $facturaUserAdicionarRepository;
    }

    public function render()
    {
        $data['qtyUsers'] = $this->userRepository->quantidadeUsers();
        $data['users'] = $this->userRepository->getUsers($this->search);
        return view('empresa.usuarios.index', $data);
    }
    public function modalDel($utilizadorId)
    {
        $this->utilizadorId = $utilizadorId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarUtilizador',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarUtilizador($data)
    {

        if ($data['value']) {
            try {
                $this->userRepository->deletarUtilizador($this->utilizadorId);
                $this->confirm('Operação realizada com sucesso', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'success'
                ]);
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }
    public function mostrarFactura($userId)
    {
        $factura = DB::connection('mysql')->table('facturas_users_adicionais')->where('user_id_adicionado', $userId)->first();
        return $this->imprimirFacturaAdicionarUtilizador($factura->id);
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
                    'viaImpressao' => 2,
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
    public function modalComprovativo($userId)
    {
        $this->userId = $userId;
    }
    public function enviarComprovativo()
    {
        $rules = [
            'comprovativoPgtFactura' => 'required',
            'numero_operacao_bancaria' => ['required', function ($attr, $numeroOperacaoBancaria, $fail) {
                $numeroOperacaoBancaria = DB::connection('mysql')->table('comprovativos_facturas')->where('numero_operacao_bancaria', $numeroOperacaoBancaria)->first();
                if ($numeroOperacaoBancaria) {
                    $fail("Número de operação já utilizado");
                    return;
                }
            }]
        ];
        $messages = [
            'comprovativoPgtFactura.required' => 'Anexa o comprovativo',
            'numero_operacao_bancaria.required' => 'Informe o número de operação bancária',
        ];

        $this->validate($rules, $messages);

        $data = [
            'comprovativoPgtFactura' => $this->comprovativoPgtFactura,
            'numero_operacao_bancaria' => $this->numero_operacao_bancaria

        ];

        $comprovativo = $this->facturaUserAdicionarRepository->enviarComprovativoFacturaUserAdicionado($data, $this->userId);

        if ($comprovativo) {
            $this->confirm('Comprovativo enviado, aguarda activação do utilizador', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'success'
            ]);
        }
    }

    public function imprimirUtilizadores()
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "utilizadores";

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }

}
