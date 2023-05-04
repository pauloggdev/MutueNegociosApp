<?php

namespace App\Http\Controllers\admin\PedidosLicenca;

use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Jobs\JobMailCancelarPedidoLicenca;
use App\Repositories\Admin\FacturaRepository;
use App\Repositories\Admin\PagamentoRepository;
use App\Repositories\Admin\PedidosLicencaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class PedidoLicencaRejeitadoIndexController extends Component
{

    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;



    private $pedidosLicencaRepository;
    private $pagamentoRepository;
    private $facturaRepository;
    public $pedidoId;
    public $observacao;

    public function mount($pedidoId)
    {
        $this->pedidoId = $pedidoId;
    }

    public function boot(
        PagamentoRepository $pagamentoRepository,
        PedidosLicencaRepository $pedidosLicencaRepository,
        FacturaRepository $facturaRepository
    ) {
        $this->pagamentoRepository = $pagamentoRepository;
        $this->pedidosLicencaRepository = $pedidosLicencaRepository;
        $this->facturaRepository = $facturaRepository;
    }


    public function render()
    {
        return view('admin.pedidosLicenca.rejeitar')->layout('layouts.appAdmin');
    }

    public function rejeitarPedidoLicenca()
    {
        $rules = [
            'observacao' => 'required'
        ];
        $messages = [
            'observacao.required' => 'Motivo da rejeição é obrigatório'

        ];

        $this->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $pedido = $this->pedidosLicencaRepository->getPedidosLicenca($this->pedidoId);


            if ($pedido->pagamento_id) {
                $pagamento = $this->pagamentoRepository->getPagamento($pedido->pagamento_id, $pedido->empresa_id);
                $this->facturaRepository->alterarStatuFacturaParaDivida($pagamento->factura_id, $pedido->empresa_id);
            }
            $this->pedidosLicencaRepository->alterarStatuPedidoLicencaParaAnulado($pedido->id, $pedido->empresa_id, $this->observacao);
            DB::commit();

            $data['emails'] = DB::connection('mysql')->table('users_admin')
                ->where('notificarAtivacaoLicenca', 'Y')
                ->pluck('email')->toArray();
            $data['emails'][] = $pedido['empresa']['email'];

            $dataPedidoLicenca = new carbon($pedido['created_at']);
            $dataPedidoLicenca = $dataPedidoLicenca->format('d/m/Y');

            $data['dataPedidoLicenca'] = $dataPedidoLicenca;
            $data['motivo'] = $this->observacao;
            $data['tipoLicenca'] = $pedido['licenca']['designacao'];
            $data['empresa'] = $pedido['empresa']['nome'];
            JobMailCancelarPedidoLicenca::dispatch($data)->delay(now()->addSecond('5'));

            return redirect()->back()->with('success', 'Operação realizada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
