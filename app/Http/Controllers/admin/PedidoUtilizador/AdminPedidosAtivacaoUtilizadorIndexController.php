<?php

namespace App\Http\Controllers\admin\PedidoUtilizador;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Jobs\JobCadastroEmpresaNotificacao;
use App\Jobs\JobEnviarEmailDeAtivacaoDoUtilizador;
use App\Jobs\JobEnviarEmailMotivoRejeicaoAtivacaoUtilizador;
use App\Repositories\Admin\FacturaUserAdicionarRepository;
use App\Repositories\Admin\PedidosLicencaRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPedidosAtivacaoUtilizadorIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;



    public $search = null;
    public $byStatus = null;
    public $byLicencas = null;
    public $pathComprovativo;
    public $perpage = 10;
    public $motivo;

    private $facturaUserAdicionarRepository;
    protected $listeners = ['rejeitarActivacaoUtilizador', 'aceitarPedidoAtivacaoUtilizador'];


    public function boot(FacturaUserAdicionarRepository $facturaUserAdicionarRepository)
    {
        $this->facturaUserAdicionarRepository = $facturaUserAdicionarRepository;
    }
    public function render()
    {
        $data['comprovativos'] = $this->facturaUserAdicionarRepository->listarComprovativosAvalidar();
        return view('admin.pedidoAtivacaoUtilizador.index', $data)->layout('layouts.appAdmin');
    }

    public function visualizarComprovativo($comprovativo)
    {
        $comprovativo = "/upload//" . $comprovativo['comprovativo_pgt_recibos'];
        $this->dispatchBrowserEvent('mostrarImagemComprovativo', ['data' => $comprovativo]);
    }
    public function modalRejeicaoActivacaoUtilizador($comprovativo)
    {
        $this->comprovativo = $comprovativo;
    }
    public function enviarMotivoRejeicaoActivacaoUtilizador()
    {

        $rules = [
            'motivo' => 'required',
        ];
        $messages = [
            'motivo.required' => 'Informe o motivo'
        ];

        $this->validate($rules, $messages);

        DB::connection('mysql')->table('comprovativos_facturas')
            ->where('id', $this->comprovativo['id'])
            ->update([
                'status_id' => 3, //rejeitado
                'user_id' => auth()->user()->id
            ]);
        DB::connection('mysql2')->table('users_cliente')
            ->where('id', $this->comprovativo['factura']['user_id_adicionado'])
            ->update([
                'status_id' => 2, //desactivo
                'statusUserAdicional' => 2 //desactivo
            ]);
        $infoEmail['email'] = $this->comprovativo['factura']['email_cliente'];
        $infoEmail['motivo'] = $this->motivo;

        JobEnviarEmailMotivoRejeicaoAtivacaoUtilizador::dispatch($infoEmail)->delay(now()->addSecond('5'));

        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
        $this->motivo = null;
    }
    public function rejeitarActivacaoUtilizador($data)
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
    public function modalActivarUtilizador($comprovativo)
    {
        $this->comprovativo = $comprovativo;
        $this->confirm('Deseja activar o utilizador?', [
            'onConfirmed' => 'aceitarPedidoAtivacaoUtilizador',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function aceitarPedidoAtivacaoUtilizador()
    {
        DB::connection('mysql')->table('comprovativos_facturas')
            ->where('id', $this->comprovativo['id'])
            ->update([
                'status_id' => 1, //activo
                'user_id' => auth()->user()->id
            ]);
        DB::connection('mysql2')->table('users_cliente')
            ->where('id', $this->comprovativo['factura']['user_id_adicionado'])
            ->update([
                'status_id' => 1, //activo
                'statusUserAdicional' => 1 //activo
            ]);

        $infoEmail['email'] = $this->comprovativo['factura']['email_cliente'];
        $infoEmail['nomeUser'] = $this->comprovativo['factura']['nome_utilizador_adicionado'];

        // $infoEmail['email'] = 'pauloggjoao@gmail.com';
        // $infoEmail['nomeUser'] = 'PAULO GONÇALO GARCIA JOÃO';
        JobEnviarEmailDeAtivacaoDoUtilizador::dispatch($infoEmail)->delay(now()->addSecond('5'));


        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function imprimirFactura($comprovativo){


        $filename = 'facturaUsuarioAdicionalA4Admin';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('id', $comprovativo['factura']['empresa_id'])->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $DIR = public_path() . "/upload/documentos/admin/relatorios/";


        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'facturaId' => $comprovativo['factura']['id'],
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


    public function imprimirPedidos()
    {

        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/admin/relatorios/';

        $filename = "pedidosLicencas";

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
