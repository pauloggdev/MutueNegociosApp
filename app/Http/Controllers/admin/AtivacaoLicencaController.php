<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Factura;
use App\Models\admin\Pagamento;
use App\Models\empresa\Empresa_Cliente;
use App\Notifications\AtivacaoLicenca as NotificationsAtivacaoLicenca;
use App\Notifications\RejeitarPedidoLicenca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;

class AtivacaoLicencaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LICENCA_GRATIS = 1;
        $data['ativacaolicencas'] = AtivacaoLicenca::with(['pagamento.factura', 'pagamento.formaPagamento', 'pagamento.contaMovimento.coordernadaBancaria', 'pagamento.contaMovimento', 'licenca', 'statusLicenca', 'empresa', 'pagamento'])->get();
        return view('admin.pedidoLicencas.index', $data);
    }
    public function listarPedidoLicencas()
    {

        $data = AtivacaoLicenca::latest()->with(
            [
                'pagamento.factura',
                'pagamento.formaPagamento',
                'pagamento.contaMovimento.coordernadaBancaria',
                'pagamento.contaMovimento', 'licenca',
                'statusLicenca', 'empresa', 'pagamento'
            ]
        )->paginate(10);

        return response()->json($data, 200);
    }

    public function detalhes($id)
    {

        $id = base64_decode($id);

        $data['ativacaoLicencas'] = AtivacaoLicenca::find($id);

        if (!empty($data['ativacaoLicencas'])) {
            $data['pagamento'] =  DB::connection('mysql')->table('pagamentos')->where('id', $data['ativacaoLicencas']->pagamento_id)->first();

            if (!empty($data['pagamento'])) {
                $data['formaPagamento'] =  DB::connection('mysql')->table('formas_pagamentos')->where('id', $data['pagamento']->forma_pagamento_id)->first();
                $data['contaMovimento'] =  DB::connection('mysql')->table('bancos')->where('id', $data['pagamento']->conta_movimentada_id)->first();
                //$data['tipoRegime'] = (DB::table('tipos_regimes')->where('Codigo', $data['empresa']->tipo_regime_id)->first()->Designacao) ? (DB::table('tipos_regimes')->where('Codigo', $data['empresa']->tipo_regime_id)->first()->Designacao) : '';
            }
        }

        return view('admin.pedidoLicencas.detalhes', $data);
    }


    public function ativarLicenca($id)
    {

        $LICENCA_GRÁTIS = 1;
        $LICENCA_MENSAL = 2;
        $LICENCA_ANUAL = 3;
        $LICENCA_DEFINITIVO = 4;

        $STATUS_ATIVO = 1;
        $STATUS_REJEITADO = 2;

        $paramentro1 = DB::connection('mysql')->table('parametros')->where('id', 25)->first();
        $paramentro2 = DB::connection('mysql')->table('parametros')->where('id', 26)->first();

        $ativacaoLicenca = AtivacaoLicenca::with(['licenca'])->where('id', $id)->first();

        if ($ativacaoLicenca->licenca_id == $LICENCA_ANUAL) {
            $data_inicio = $this->pegarUltimaDataLicenca($ativacaoLicenca->empresa_id);
            $dataInicio = clone $data_inicio;
            $data_fim = $dataInicio->addDays($paramentro2->vida);
        } else if ($ativacaoLicenca->licenca_id == $LICENCA_MENSAL) {
            $data_inicio = $this->pegarUltimaDataLicenca($ativacaoLicenca->empresa_id);
            $dataInicio = clone $data_inicio;
            $data_fim =  $dataInicio->addDays($paramentro1->vida);
        } else if ($ativacaoLicenca->licenca_id == $LICENCA_DEFINITIVO) {
            $data_inicio = $this->pegarUltimaDataLicenca($ativacaoLicenca->empresa_id);
            $data_fim = null;
        }

        $ativacaoLicenca->status_licenca_id = $STATUS_ATIVO;
        $ativacaoLicenca->user_id = auth()->user()->id;
        $ativacaoLicenca->data_inicio = $data_inicio;
        $ativacaoLicenca->data_fim = $data_fim;
        $ativacaoLicenca->data_rejeicao = NULL;
        $ativacaoLicenca->data_activacao = Carbon::now();
        $ativacaoLicenca->observacao = 'activo a licença ' . $ativacaoLicenca->licenca->tipoLicenca->designacao . ' no dia ' . Carbon::now();
        $ativacaoLicenca->save();

        if ($ativacaoLicenca) {
            $pagamento = Pagamento::where('id', $ativacaoLicenca->pagamento_id)->where('empresa_id', $ativacaoLicenca->empresa_id)->first();
            $this->actualizarFacturaStatuPago($pagamento);
            $pagamento->data_validacao = $data_inicio;
            $pagamento->status_id = $STATUS_ATIVO;
            $pagamento->save();

            //actualizar o status da factura
            $STATUS_PAGO = 2;
            $factura = Factura::where('faturaReference', $pagamento->referenciaFactura)->where('empresa_id', $ativacaoLicenca->empresa_id)->first();
            $factura->statusFactura = $STATUS_PAGO;
            $factura->save();


            //DADOS PARA ENVIO DO EMAIL
            $data['data_inicio'] = $data_inicio ? date('d-m-Y', strtotime($data_inicio)) : '';
            $data['data_final'] = $data_fim ? date('d-m-Y', strtotime($data_fim)) : '';
            $data['dataPedidoLicenca'] = $ativacaoLicenca->created_at ? date('d-m-Y', strtotime($ativacaoLicenca->created_at)) : '';
            $data['nomeEmpresa'] = $ativacaoLicenca->empresa->nome;
            $data['emailEmpresa'] = $ativacaoLicenca->empresa->email;
            $data['linkLogin'] = getenv('APP_URL');
            $data['tipoLicenca'] = $ativacaoLicenca->licenca->tipoLicenca->designacao;
            $data['data'] = $ativacaoLicenca;

            $empresa = Empresa_Cliente::where('referencia', $ativacaoLicenca->empresa->referencia)->first();
            $empresa->notify(new NotificationsAtivacaoLicenca($data));

            return response()->json($ativacaoLicenca, 200);
        }
    }
    public function actualizarFacturaStatuPago($pagamento)
    {
        $PAGO = 2;
        $factura = Factura::where('empresa_id', $pagamento->empresa_id)->find($pagamento->factura_id);
        $factura->statusFactura = $PAGO;
        $factura->save();
    }

    public function pegarUltimaDataLicenca($empresaId)
    {

        $dataActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

        $ativacaoLicenca = AtivacaoLicenca::where('data_fim', '!=', NULL)
            ->where('status_licenca_id', 1)
            ->where('data_inicio', '!=', NULL)
            ->where('data_fim', '!=', NULL)
            ->where('empresa_id', $empresaId)->orderBY('created_at', 'DESC')->first();

        if ($ativacaoLicenca) {

            $dataFimUltimaLicenca = Carbon::createFromFormat('Y-m-d', date($ativacaoLicenca->data_fim));

            if ($dataFimUltimaLicenca == $dataActual) {
                return $dataActual;
            } else if ($dataActual < $dataFimUltimaLicenca) {
                return $dataFimUltimaLicenca->addDays(1);
            } else if ($dataActual > $dataFimUltimaLicenca) {
                return $dataActual;
            }
        } else {
            return $dataActual;
        }
    }
    public function imprimirTodasPedidosLicencas()
    {

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'todosPedidoLicenca',
                'report_jrxml' => 'todosPedidoLicenca.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio,
                    "statuId" => $_GET['filter']
                ]
            ]
        );
    }
    public function cancelarLicenca($id, Request $request)
    {

        $STATUS_REJEITADO = 2;


        $ativacaoLicenca = AtivacaoLicenca::where('id', $id)->first();
        $pagamento = Pagamento::where('id', $ativacaoLicenca->pagamento_id)->where('empresa_id', $ativacaoLicenca->empresa_id)->first();

        $DIVIDA = 1;
        $factura = Factura::where('empresa_id', $pagamento->empresa_id)->find($pagamento->factura_id);
        $factura->statusFactura = $DIVIDA;
        $factura->save();

        $ativacaoLicenca->status_licenca_id = $STATUS_REJEITADO; //Status rejeitado
        $ativacaoLicenca->data_rejeicao = Carbon::now();
        $ativacaoLicenca->observacao = $request->observacao;
        $ativacaoLicenca->data_inicio = null;
        $ativacaoLicenca->data_fim = null;
        $ativacaoLicenca->data_activacao = null;
        $ativacaoLicenca->save();

        if ($ativacaoLicenca) {
            $pagamento->data_rejeitacao = date('Y-m-d', strtotime($ativacaoLicenca->data_rejeicao));
            $pagamento->save();
            //actualizar o status da factura
            $STATUS_DIVIDA = 1;
            $factura = Factura::where('faturaReference', $pagamento->referenciaFactura)->where('empresa_id', $ativacaoLicenca->empresa_id)->first();
            $factura->statusFactura = $STATUS_DIVIDA;
            $factura->save();

            //DADOS PARA ENVIAR NO EMAIL
            $data['emailEmpresa'] = $ativacaoLicenca->empresa->email;
            $data['assunto'] = 'Pedido de Activação Rejeitada';
            $data['motivo'] = $request->observacao;
            $data['dataPedidoLicenca'] = $ativacaoLicenca->created_at ? date('d-m-Y', strtotime($ativacaoLicenca->created_at)) : '';
            $data['empresa'] = $ativacaoLicenca->empresa->nome;
            $data['tipoLicenca'] = $ativacaoLicenca->licenca->tipoLicenca->designacao;
            $data['data'] = $ativacaoLicenca;
            //$data['file'] = $request->file;

            $empresa = Empresa_Cliente::where('referencia', $ativacaoLicenca->empresa->referencia)->first();
            $empresa->notify(new RejeitarPedidoLicenca($data));

            // JobMailCancelarPedidoLicenca::dispatch($data)->delay(now()->addSecond('5'));

            // Mail::send(new MailCancelarLicenca($data));
            //FIM

            return response()->json($ativacaoLicenca, 200);
        }
    }
    public function imprimirPedidoLicenca($pedido)
    {

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() .  "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'pedidoLicencas',
                'report_jrxml' => 'pedidoLicencas.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio,
                    "pedidoId" => $pedido
                ]
            ]
        );
    }
}
