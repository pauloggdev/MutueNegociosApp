<?php

namespace App\Http\Controllers\admin\PedidosLicenca;

use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Jobs\JobMailAtivacaoLicenca;
use App\Jobs\JobNotificacaoAtivacaoLicenca;
use App\Jobs\JobNotificacaoPedidoAceiteAtivacaoLicenca;
use App\Models\admin\Licenca;
use App\Repositories\Admin\FacturaRepository;
use App\Repositories\Admin\PagamentoRepository;
use App\Repositories\Admin\PedidosLicencaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Controllers\admin\ReportShowAdminController;



class PedidoLicencaAtivarIndexController extends Component
{

    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;


    public $pedidoId;


    private $pedidosLicencaRepository;
    private $pagamentoRepository;
    private $facturaRepository;

    public function mount($pedidoId)
    {
        $this->pedidoId = $pedidoId;
    }


    public function boot(
        PedidosLicencaRepository $pedidosLicencaRepository,
        PagamentoRepository $pagamentoRepository,
        FacturaRepository $facturaRepository

    ) {
        $this->pedidosLicencaRepository = $pedidosLicencaRepository;
        $this->pagamentoRepository = $pagamentoRepository;
        $this->facturaRepository = $facturaRepository;
    }

    public function render()
    {
        $pedido = $this->pedidosLicencaRepository->getPedidosLicenca($this->pedidoId);
        return view('admin.pedidosLicenca.ativar', compact('pedido'))->layout('layouts.appAdmin');
    }

    public function activarLicenca($pedidoLicencaId)
    {

        $ativacaoLicenca = $this->pedidosLicencaRepository->getPedidosLicenca($pedidoLicencaId);
        $referenciaEmpresaCliente = $ativacaoLicenca->empresa->referencia;

        $data['emails'] = DB::connection('mysql')->table('users_admin')
            ->where('notificarAtivacaoLicenca', 'Y')
            ->pluck('email')->toArray();
        $data['emails'][] = $ativacaoLicenca['empresa']['email'];

        $ultimaDataLicencaAtiva = $this->pedidosLicencaRepository->pegarUltimaDataLicencaDaEmpresa($ativacaoLicenca->empresa_id);


        if ($ativacaoLicenca->licenca_id == Licenca::MENSAL) {
            $data_inicio = $ultimaDataLicencaAtiva;
            $dataInicio = clone $data_inicio;
            $data_fim = $dataInicio->addDays(31);
            $observacao = "ativo a licença mensal no dia " . Carbon::now();
        } else if ($ativacaoLicenca->licenca_id == Licenca::ANUAL) {
            $data_inicio = $ultimaDataLicencaAtiva;
            $dataInicio = clone $data_inicio;
            $data_fim = $dataInicio->addDays(365);
            $observacao = "ativo a licença anual no dia " . Carbon::now();
        } else if ($ativacaoLicenca->licenca_id == Licenca::DEFINITIVO) {
            $data_inicio = $ultimaDataLicencaAtiva;
            $dataInicio = clone $data_inicio;
            $data_fim = NULL;
            $observacao = "ativo a licença definitiva no dia " . Carbon::now();
        }

        try {

            DB::beginTransaction();
            $ativacaoLicenca->status_licenca_id = 1;
            $ativacaoLicenca->user_id = auth()->user()->id;
            $ativacaoLicenca->operador = auth()->user()->name;
            $ativacaoLicenca->data_inicio = $data_inicio;
            $ativacaoLicenca->data_fim = $data_fim;
            $ativacaoLicenca->data_rejeicao = NULL;
            $ativacaoLicenca->data_activacao = Carbon::now();
            $ativacaoLicenca->observacao = $observacao;
            $ativacaoLicenca->save();
            $pagamento = $this->pagamentoRepository->getPagamento($ativacaoLicenca->pagamento_id, $ativacaoLicenca->empresa_id);

            $this->pagamentoRepository->alterarStatuPagamentoAtivo($ativacaoLicenca->pagamento_id, $ativacaoLicenca->empresa_id, $data_inicio);
            $this->facturaRepository->alterarStatuFacturaParaPago($pagamento->referenciaFactura, $ativacaoLicenca->empresa_id);

            $pathFactura = $this->imprimirReciboPagamento($ativacaoLicenca->pagamento_id, $referenciaEmpresaCliente);

            $data['nomeEmpresa'] = $ativacaoLicenca['empresa']['nome'];
            $data['comprovativoReciboPagamento'] = $pathFactura['filename'];
            $data['linkLogin'] = env('APP_URL');
            $data['data_final'] =  '2023-06-11';
            $data['data_inicio'] = '2023-05-11';
            $data['tipoLicenca'] = $ativacaoLicenca['licenca']['designacao'];
            JobMailAtivacaoLicenca::dispatch($data)->delay(now()->addSecond('5'));

            DB::commit();
            $this->flash('success', 'Operação realizada com sucesso', [], '/admin/pedidos/licenca');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function imprimirReciboPagamento($pagamentoId, $referenciaEmpresaCliente)
    {


        $filename = 'reciboPagamentoPedente';
        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();
        $empresaCliente = DB::connection('mysql')->table('empresas')->where('referencia', $referenciaEmpresaCliente)->first();
        $logotipo = public_path() . '/upload//' . $empresa->logotipo;

        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'pagamentoId' => $pagamentoId,
                    'logotipo' => $logotipo,
                    'empresa_id' => $empresaCliente->id,
                    'EmpresaNome' => $empresa->nome,
                    'EmpresaEndereco' => $empresa->endereco,
                    'EmpresaNif' => $empresa->nif,
                    'EmpresaTelefone' => $empresa->pessoal_Contacto,
                    'EmpresaEmail' => $empresa->email,
                    'EmpresaWebsite' => $empresa->website,
                    'operador' => auth()->user()->name
                ]

            ]
        );

        return $report;
    }
}
