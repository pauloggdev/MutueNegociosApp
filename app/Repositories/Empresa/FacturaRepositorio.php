<?php

namespace App\Repositories\Empresa;


use App\Models\Empresa\Factura;
use App\Models\Empresa\FacturaItems;
use App\Models\Empresa\FacturaOriginal;
use App\Models\Empresa\FacturaItemsOriginal;
use App\Interfaces\Empresa\CrudDao;
use App\Models\Empresa\NotaCredito;
use App\Models\Empresa\NotaDebito;
use App\Models\empresa\RecibosItem;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\TraitChavesEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa\Statu;




class FacturaRepositorio implements CrudDao
{

    use TraitEmpresaAutenticada;
    use TraitChavesEmpresa;

    private $admin_system = 1;
    private $empresa_system = 2;
    private $funcionario_system = 3;

    protected $model = Factura::class;


    public function all()
    {
    }
    public function listarFacturasRetificadas()
    {

        

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        $data['facturas'] = NotaCredito::with('tipoDocumento')
            ->where('retificado', "Sim")
            ->where('empresa_id', $empresa_id)
            ->where(function ($query) {
                $query->where('tipo_documento', 1)
                    ->orWhere('tipo_documento', 2);
            })
            ->get();

        $data['guard'] = $this->pegarEmpresaAutenticadaGuardOperador()['guard'];
        $data['status'] = Statu::all();

        return $data;
    }
    public function store(Request $request)
    {
        
    }
    public function salvarFacturasRecificadas(Request $request)
    {


        $empresaId = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        $facturaId = $request->all()['factura']['id'];




        if ($this->salvarFacturaOriginal($facturaId, $empresaId)) {

            try {
                $factura = DB::table('facturas')->where('empresa_id', $empresaId)->where('id', $facturaId)

                    //$request->all()['factura']
                    ->update(
                        [
                            'id' => $request->all()['factura']['id'],
                            'total_preco_factura' => $request->all()['factura']['total_preco_factura'],
                            'valor_a_pagar' => $request->all()['factura']['valor_a_pagar'],
                            'valor_entregue' => $request->all()['factura']['valor_entregue'],
                            'troco' => $request->all()['factura']['troco'],
                            'valor_extenso' => $request->all()['factura']['valor_extenso'],
                            'codigo_moeda' => $request->all()['factura']['codigo_moeda'], //ver este
                            'desconto' => $request->all()['factura']['desconto'],
                            'total_iva' => $request->all()['factura']['total_iva'],
                            'total_incidencia' => $request->all()['factura']['total_incidencia'],
                            'tipo_user_id' => $request->all()['factura']['tipo_user_id'],
                            'multa' => $request->all()['factura']['multa'],
                            'statusFactura' => $request->all()['factura']['statusFactura'],
                            'anulado' => $request->all()['factura']['anulado'],
                            'nome_do_cliente' => $request->all()['factura']['nome_do_cliente'],
                            'telefone_cliente' => $request->all()['factura']['telefone_cliente'],
                            'nif_cliente' => $request->all()['factura']['nif_cliente'],
                            'email_cliente' => $request->all()['factura']['email_cliente'],
                            'endereco_cliente' => $request->all()['factura']['endereco_cliente'],
                            'conta_corrente_cliente' => $request->all()['factura']['conta_corrente_cliente'],
                            'numeroItems' => $request->all()['factura']['numeroItems'],
                            'tipo_documento' => $request->all()['factura']['tipo_documento'],
                            'tipoFolha' => $request->all()['factura']['tipoFolha'],
                            'retencao' => $request->all()['factura']['total_retencao'],
                            'nextFactura' => $request->all()['factura']['nextFactura'],
                            'faturaReference' => $request->all()['factura']['faturaReference'],
                            'numSequenciaFactura' => $request->all()['factura']['numSequenciaFactura'],
                            'numeracaoFactura' => $request->all()['factura']['numeracaoFactura'],
                            'hashValor' => $request->all()['factura']['hashValor'],
                            'retificado' => $request->all()['factura']['retificado'],
                            'formas_pagamento_id' => $request->all()['factura']['formas_pagamento_id'],
                            'descricao' => $request->all()['factura']['descricao'],
                            'observacao' => $request->all()['factura']['observacao'],
                            'armazen_id' => $request->all()['factura']['armazen_id'],
                            'cliente_id' => $request->all()['factura']['cliente_id'],
                            'empresa_id' => $request->all()['factura']['empresa_id'],
                            'canal_id' => $request->all()['factura']['canal_id'],
                            'status_id' => $request->all()['factura']['status_id'],
                            'user_id' => $request->all()['factura']['user_id'],
                            'created_at' => $request->all()['factura']['created_at'],
                            'updated_at' => $request->all()['factura']['updated_at'],
                            'data_vencimento' => $request->all()['factura']['data_vencimento'],
                            'operador' => $request->all()['factura']['operador']
                        ]
                    );

                foreach ($request->all()['factura']['facturas_items'] as $key => $facturaItem) {

                    if ($facturaItem['quantidade_produto'] == 0) {
                        $this->removerItemFacturaItemSeQtForZero($facturaItem);
                    } else {
                        $facturaItem = FacturaItems::where('id', $facturaItem['id'])
                            ->update($this->camposFacturaItem($facturaItem));
                    }
                }
                return $factura;
            } catch (\Exception $th) {
                throw $th;
            }
        }
    }


    public function removerItemFacturaItemSeQtForZero($facturaItem)
    {

        $user = FacturaItems::find($facturaItem['id'])->delete();
        return $user;
    }

    public function salvarFacturaOriginal($idFactura, $empresaId)
    {
        $factura = $this->model::with(['facturas_items'])->where('empresa_id', $empresaId)->where('id', $idFactura)->first();

        DB::beginTransaction();

        try {
            DB::connection('mysql2')->table('facturas_original')->insert(
                $this->camposFactura($factura)
            );
            foreach ($factura->facturas_items as $key => $facturaItem) {
                DB::connection('mysql2')->table('factura_items_original')->insert(
                    $this->camposFacturaItem($facturaItem)
                );
            }
            if (DB::commit() == null)
                return true;
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }
    public function camposFacturaItem($facturaItem)
    {
        return [
            'id' => $facturaItem['id'],
            'descricao_produto' => $facturaItem['descricao_produto'],
            'preco_compra_produto' => $facturaItem['preco_compra_produto'],
            'preco_venda_produto' => $facturaItem['preco_venda_produto'],
            'quantidade_produto' => $facturaItem['quantidade_produto'],
            'desconto_produto' => $facturaItem['desconto_produto'],
            'incidencia_produto' => $facturaItem['incidencia_produto'],
            'retencao_produto' => $facturaItem['retencao_produto'],
            'iva_produto' => $facturaItem['iva_produto'],
            'total_preco_produto' => $facturaItem['total_preco_produto'],
            'produto_id' => $facturaItem['produto_id'],
            'factura_id' => $facturaItem['factura_id']
        ];
    }
    public function camposFactura($factura)
    {
        return [
            'id' => $factura['id'],
            'total_preco_factura' => $factura['total_preco_factura'],
            'valor_a_pagar' => $factura['valor_a_pagar'],
            'valor_entregue' => $factura['valor_entregue'],
            'troco' => $factura['troco'],
            'valor_extenso' => $factura['valor_extenso'],
            'codigo_moeda' => $factura['codigo_moeda'], //ver este
            'desconto' => $factura['desconto'],
            'total_iva' => $factura['total_iva'],
            'total_incidencia' => $factura['total_incidencia'],
            'tipo_user_id' => $factura['tipo_user_id'],
            'multa' => $factura['multa'],
            'statusFactura' => $factura['statusFactura'],
            'anulado' => $factura['anulado'],
            'nome_do_cliente' => $factura['nome_do_cliente'],
            'telefone_cliente' => $factura['telefone_cliente'],
            'nif_cliente' => $factura['nif_cliente'],
            'email_cliente' => $factura['email_cliente'],
            'endereco_cliente' => $factura['endereco_cliente'],
            'conta_corrente_cliente' => $factura['conta_corrente_cliente'],
            'numeroItems' => $factura['numeroItems'],
            'tipo_documento' => $factura['tipo_documento'],
            'tipoFolha' => $factura['tipoFolha'],
            'retencao' => $factura['retencao'],
            'nextFactura' => $factura['nextFactura'],
            'faturaReference' => $factura['faturaReference'],
            'numSequenciaFactura' => $factura['numSequenciaFactura'],
            'numeracaoFactura' => $factura['numeracaoFactura'],
            'hashValor' => $factura['hashValor'],
            'retificado' => $factura['retificado'],
            'formas_pagamento_id' => $factura['formas_pagamento_id'],
            'descricao' => $factura['descricao'],
            'observacao' => $factura['observacao'],
            'armazen_id' => $factura['armazen_id'],
            'cliente_id' => $factura['cliente_id'],
            'empresa_id' => $factura['empresa_id'],
            'canal_id' => $factura['canal_id'],
            'status_id' => $factura['status_id'],
            'user_id' => $factura['user_id'],
            'created_at' => $factura['created_at'],
            'updated_at' => $factura['updated_at'],
            'data_vencimento' => $factura['data_vencimento'],
            'operador' => $factura['operador']
        ];
    }

    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }

    public function verificarFacturaContemRecibo($idFactura)
    {

        $STATUS_ATIVO = 1;

        $resultado = false;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $verificaRecibo = RecibosItem::where('empresa_id', $empresa->id)->where('anulado', 1)->where('factura_id', $idFactura)->get();

        if (count($verificaRecibo) > 0) {
            $resultado = true;
        }
        return $resultado;
    }
    public function alteraStatuNuloFactura($idFactura)
    {

        $STATUS_NULO = 2;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        $resultado = $this->model::where('empresa_id', $empresa->id)->where('id', $idFactura)
            ->update(['anulado' => $STATUS_NULO]);
        return $resultado;
    }
    public function camposNotaCredito($factura)
    {
        $TIPO_RETIFICACAO = 3;

        return [

            'empresa_id' => $factura['empresa_id'],
            'tipoNotaCredito' => $TIPO_RETIFICACAO,
            'cliente_id' => $factura['cliente_id'],
            'descricao' => $factura['descricao'],
            'id' => $factura['id'],
            'total_preco_factura' => $factura['total_preco_factura'],
            'valor_a_pagar' => $factura['valor_a_pagar'],
            'valor_entregue' => $factura['valor_entregue'],
            'troco' => $factura['troco'],
            'valor_extenso' => $factura['valor_extenso'],
            'codigo_moeda' => $factura['codigo_moeda'], //ver este
            'desconto' => $factura['desconto'],
            'total_iva' => $factura['total_iva'],
            'total_incidencia' => $factura['total_incidencia'],
            'tipo_user_id' => $factura['tipo_user_id'],
            'multa' => $factura['multa'],
            'statusFactura' => $factura['statusFactura'],
            'anulado' => $factura['anulado'],
            'nome_do_cliente' => $factura['nome_do_cliente'],
            'telefone_cliente' => $factura['telefone_cliente'],
            'nif_cliente' => $factura['nif_cliente'],
            'email_cliente' => $factura['email_cliente'],
            'endereco_cliente' => $factura['endereco_cliente'],
            'conta_corrente_cliente' => $factura['conta_corrente_cliente'],
            'numeroItems' => $factura['numeroItems'],
            'tipo_documento' => $factura['tipo_documento'],
            'tipoFolha' => $factura['tipoFolha'],
            'retencao' => $factura['retencao'],
            'nextFactura' => $factura['nextFactura'],
            'faturaReference' => $factura['faturaReference'],
            'numSequenciaFactura' => $factura['numSequenciaFactura'],
            'numeracaoFactura' => $factura['numeracaoFactura'],
            'hashValor' => $factura['hashValor'],
            'retificado' => $factura['retificado'],
            'formas_pagamento_id' => $factura['formas_pagamento_id'],
            'observacao' => $factura['observacao'],
            'armazen_id' => $factura['armazen_id'],
            'canal_id' => $factura['canal_id'],
            'status_id' => $factura['status_id'],
            'user_id' => $factura['user_id'],
            'created_at' => $factura['created_at'],
            'updated_at' => $factura['updated_at'],
            'data_vencimento' => $factura['data_vencimento'],
            'operador' => $factura['operador']
        ];
    }
}
