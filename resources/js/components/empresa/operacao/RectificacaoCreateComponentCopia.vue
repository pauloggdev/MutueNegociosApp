 <template>
<section class="content">

    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Rectificação
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Documento
                </small>
            </h1>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <!-- AVISO -->
                <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">
                        Rectificação
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
            <div class="second-row">
                <div class="tabbable">
                    <div class="tab-content profile-edit-tab-content">
                        <div id="dados_formapagamento" class="tab-pane in active">
                            <div class="row">
                                <div class="form-group has-info">
                                    <div class="col-md-12">
                                        <label class="control-label bold label-select2 header bolder smaller" for="controlo_stock">Pesquise o cliente</label>
                                        <Select2 @select="selectCliente($event)" :options="clientes" placeholder="pesquise por nif, nome, telefone">
                                        </Select2>
                                    </div>
                                </div>
                                <div class="form-group has-info">
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="referencia">Nome cliente<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="nomeCliente" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="referencia">NIF cliente<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="nifCliente" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="referencia">Conta Corrente<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="contaCorrenteCliente" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group has-info bold" style="left: 0%; position: relative">

                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="referencia">Saldo Actual<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="saldoActual" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="controlo_stock">Selecione o documento<b class="red fa fa-question-circle"></b></label>
                                        <Select2 @select="selectTipoDocumento($event)" :options="optionsDocumento" id="tipoDocumento" placeholder="Selecione o documento">
                                        </Select2>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="controlo_stock">Selecione Factura/Recibo<b class="red fa fa-question-circle"></b></label>
                                        <Select2 :options="numeracaoDocumento" @select="selectDocumento($event)" placeholder="Selecione a factura">
                                        </Select2>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="controlo_stock">Selecione Produto / Serviço<b class="red fa fa-question-circle"></b></label>
                                        <Select2 :options="produtos" @select="selectProduto($event)" placeholder="Selecione a factura">
                                        </Select2>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label bold label-select2" for="spinner4">Quantidade</label>
                                        <div class="input-icon" id="quantidade_critica">
                                            <vue-numeric-input v-model="quantidade" :min="0" :max="quantidade" :step="1"></vue-numeric-input>
                                        </div>
                                    </div> -->

                                </div>
                                <div class="form-group has-info bold" style="left: 0%; position: relative">
                                    <div class="col-md-12">
                                        <label class="control-label bold label-select2" for="controlo_stock">Descrição<b class="red fa fa-question-circle"></b></label>

                                        <textarea style="height: 70px;" class="col-xs-12" cols="10" rows="3"></textarea>
                                        <!-- <span v-if="errors.descricao" class="error">{{errors.descricao[0]}}</span> -->
                                    </div>
                                </div>

                                <div class="widget-box widget-color-green" style="left: 0%">
                                    <div class="table-header widget-header">
                                        Todos items adicionados
                                    </div>

                                    <!-- div.dataTables_borderWrap -->
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Designação</th>
                                                <th style="text-align: right">Preço</th>
                                                <th style="text-align: center">Qtd factura</th>
                                                <th style="text-align: center">Qtd atual</th>
                                                <th style="text-align: right">IVA</th>
                                                <th style="text-align: right">Retenção</th>
                                                <th style="text-align: right">Desconto</th>
                                                <th style="text-align: right">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="produto in this.facturacao.factura.facturas_items" :key="produto.id">
                                                <td>{{ produto.id }}</td>
                                                <td>{{ produto.descricao_produto }}</td>
                                                <td style="text-align: right">{{ produto.preco_venda_produto |currency }}</td>
                                                <td style="text-align: center">{{produto.quantidadeMaxima}}</td>
                                                <!-- <vue-numeric-input disabled v-model="produto.quantidade" :min="0" :step="1"></vue-numeric-input> -->
                                                <td style="text-align: center">
                                                    <vue-numeric-input :min="quantidadeMinima" @change="recalcularFactura(produto,$event)" :max="produto.quantidadeMaxima" :value="produto.quantidadeMaxima+1" :step="1"></vue-numeric-input>
                                                </td>
                                                <td style="text-align: right">{{ produto.iva_produto | currency}}</td>
                                                <td style="text-align: right">{{ produto.retencao_produto  | currency }}</td>
                                                <td style="text-align: right">{{ produto.desconto_produto  | currency }}</td>
                                                <td style="text-align: right">{{ produto.total_preco_produto  | currency }}</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    <!-- fim tabela de carrinho  -->

                                    <!-- <a href="" @click.prevent="addCarrinho">Adicionar</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvarFacturaRetificada">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Salvar
                        </button>
                        &nbsp; &nbsp;
                        <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                            <i class="ace-icon fa fa-undo bigger-110"></i>
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </form>
        

    </div>

</section>
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import DatePick from 'vue-date-pick';
import Swal from "sweetalert2";
import VueNumericInput from "vue-numeric-input";

import {
    showError,
    baseUrl
} from "./../../../config/global";

export default {
    props: ["guard"],
    components: {
        Select2,
        DatePick,
        VueNumericInput
    },

    data() {
        return {
            clientes: [],
            contaCorrenteCliente: "", //somente para mostar na tela
            cliente_id: "",
            nomeCliente: "", //somente para mostrar na tela,
            nifCliente: "", //somente para mostrar na tela,
            saldoActual: "",
            quantidade: 0,
            quantidadeMinima: 0,
            numeracaoDocumento: [],
            recalcular: false,
            facturacao: {
                factura: {
                    facturas_items: {
                        taxaDesconto:""
                    }
                },
                facturaRectificada: {
                    facturas_items: {}
                }
            },
            // facturaRectificada: {
            //     facturaItems: [],
            //     cliente: {}
            // },
            produtos: [],
            USUARIO_EMPRESA: 2,
            router: "",
            optionsDocumento: [{
                    id: 2,
                    tipoDocumento: 2,
                    text: "Venda Crédito"
                },
                {
                    id: 1,
                    tipoDocumento: 1,
                    text: "Venda Pronto"
                }
            ]
        }
    },
    created() {

        this.router =
            this.guard.tipo_user_id == this.USUARIO_EMPRESA ?
            window.location.origin + `/empresa` :
            window.location.origin + `/empresa/funcionario`;

        this.listarClientes();

    },
    methods: {

        async listarClientes() {

            let response = await axios.get(`${this.router}/documentosRectificados/clientes`);

            if (response.status === 200) {

                response.data.forEach((element) => {
                    this.clientes.push({
                        id: element.id,
                        nome: element.nome,
                        text: element.nome + " - NIF- " + element.nif,
                        conta_corrente: element.conta_corrente,
                        email_cliente: element.email,
                        nif_cliente: element.nif,
                        endereco_cliente: element.endereco,
                        telefone_cliente: element.telefone_cliente,
                        website: element.website,
                    });
                });

            }

        },
        async selectProduto(produto) {

            this.quantidade = produto.quantidade;

        },
        selectDocumento(doc) {
            this.listarDadoFactura(doc.id);
        },
        async listarDadoFactura(idFactura) {

            // this.facturaRectificada.facturaItems = [];
            let factura = await axios.get(`${this.router}/factura/${idFactura}`);

            // console.log(response);
            // return;

            if (factura.status == 200) {

                //criar copia do object

                this.facturacao = JSON.parse(JSON.stringify(factura.data));
                this.facturacao.factura.retificado = "Sim";

                //copia para factura rectificada
                this.facturacao.facturaRectificada = JSON.parse(JSON.stringify(factura.data.factura));
                this.facturacao.facturaRectificada.retificado = "Sim";

                //definir a quantidade maxima
                this.facturacao.factura.facturas_items.map((item, index) => {
                    this.facturacao.factura.facturas_items[index].quantidadeMaxima = item.quantidade_produto
                    this.facturacao.factura.facturas_items[index].taxaDesconto = this.descontoTotal(item)
                })
            }

        },
        selectCliente(cliente) {

            if (cliente) {
                this.nomeCliente = cliente.nome;
                this.nifCliente = cliente.nif_cliente;
                this.contaCorrenteCliente = cliente.conta_corrente;
                this.cliente_id = cliente.id;

                this.optionsDocumento = [{
                    id: 2,
                    tipoDocumento: 2,
                    text: "Venda Crédito"
                }, {
                    id: 1,
                    tipoDocumento: 1,
                    text: "Venda Pronto"
                }]

                this.mostrarSaldoCliente(cliente.id);

            }

            // this.valor_a_pagar = "";
            // this.valor_entregue = "";
            // this.totalDebito = "";
            // this.factura_id = null;
            // this.dataRecibo.nome_do_cliente = cliente.nome;
            // this.dataRecibo.telefone_cliente = cliente.telefone_cliente;
            // this.dataRecibo.nif_cliente = cliente.nif_cliente;
            // this.dataRecibo.email_cliente = cliente.email_cliente;
            // this.dataRecibo.endereco_cliente = cliente.endereco_cliente;
            // this.dataRecibo.conta_corrente_cliente = cliente.conta_corrente;

            // this.ListarDocumentosEfectuadoCliente(cliente);
            //this.dataRecibo.reciboItem = []; //zero o carrinho
            //this.mostrarSaldoCliente(cliente.id);
        },
        async selectTipoDocumento(event) {

            this.numeracaoDocumento = [];
            this.produtos = [];

            if (!this.cliente_id) {
                this.$toasted.global.defaultError({
                    msg: "Selecione o cliente",
                });
                return;
            }

            let response = await axios.get(`${this.router}/listarFacturasAoSelecionarTipoDocumento/${this.cliente_id}/${event.tipoDocumento}`);

            if (response.status == 200) {
                if (response.data.length) {
                    response.data.forEach((element) => {
                        this.numeracaoDocumento.push({
                            id: element.id,
                            text: element.numeracaoFactura,
                        });
                    });
                } else {
                    this.$toasted.global.defaultError({
                        msg: "Não existe facturas/factura recibo corresponde ao documento selecionado "
                    });
                    this.facturacao.factura.facturas_items = []
                }
            }
        },
        async mostrarSaldoCliente(idCliente) {
            let response = await axios.get(
                `${this.router}/clientes/saldoActual/${idCliente}`
            );

            if (response.status === 200) {
                this.saldoActual = response.data;
            }
        },
        recalcularFactura(facturaItem, quantAtual) {

            //console.log(quantAtual);return;

            if (!isNaN(quantAtual)) {

                this.recalcular = true;

                this.facturacao.factura.facturas_items.map((item, index) => {

                    if (facturaItem.id == item.id) {

                        let total_preco_produto = this.total_preco_produto(item, quantAtual);
                        let valor_desconto = this.valor_desconto(item, quantAtual, this.facturacao.factura.facturas_items[index]);
                        let incidencia = this.valor_incidencia(item, quantAtual);
                        let iva_produto = this.iva_produto(item, quantAtual);
                        let retencao_produto = this.valor_retencao(item, quantAtual);

                        this.facturacao.factura.facturas_items[index].total_preco_produto = total_preco_produto;
                        this.facturacao.factura.facturas_items[index].quantidade_produto = quantAtual;
                        //console.log(valor_desconto);
                        this.facturacao.factura.facturas_items[index].desconto_produto = valor_desconto;
                        // this.facturacao.factura.facturas_items[index].incidencia_produto = incidencia;
                        // this.facturacao.factura.facturas_items[index].iva_produto = iva_produto
                        // this.facturacao.factura.facturas_items[index].retencao_produto = retencao_produto

                        //         /**
                        //          * Dados da retificação da tabela notaCredito e notaCreditoItems
                        //          */

                        //         let quantAnterior = facturaItem.quantidadeMaxima;

                        //         var quant = "";
                        //         if (quantAnterior === quantAtual) {
                        //             quant = quantAnterior;
                        //         } else {
                        //             quant = (quantAnterior - quantAtual);
                        //         }

                        //         let totalPrecoProdutoRetificacao = this.total_preco_produto(item, quant)
                        //         let valor_descontoRetificacao = this.valor_desconto(item, quant);
                        //         let incidenciaRetificacao = this.valor_incidencia(item, quant);
                        //         let iva_produtoRetificacao = this.iva_produto(item, quant);
                        //         let retencao_produtoRetificacao = this.valor_retencao(item, quant);

                        //         // console.log(totalPrecoProdutoRetificacao);return;

                        //         this.facturacao.facturaRectificada.facturas_items[index].total_preco_produto = totalPrecoProdutoRetificacao;
                        //         this.facturacao.facturaRectificada.facturas_items[index].quantidade_produto = quant;
                        //         this.facturacao.facturaRectificada.facturas_items[index].desconto_produto = valor_descontoRetificacao;
                        //         this.facturacao.facturaRectificada.facturas_items[index].incidencia_produto = incidenciaRetificacao;
                        //         this.facturacao.facturaRectificada.facturas_items[index].iva_produto = iva_produtoRetificacao
                        //         this.facturacao.facturaRectificada.facturas_items[index].retencao_produto = retencao_produtoRetificacao

                        //         // this.facturacao.factura.facturas_items[index].retencao_produto = this.valor_retencao(item, quantAtual)
                        //         // this.facturacao.factura.facturas_items[index].incidencia_produto = this.valor_incidencia(item, quantAtual)
                        //         // this.facturacao.factura.facturas_items[index].iva_produto = this.iva_produto(item, quantAtual)
                        //         // this.facturacao.factura.facturas_items[index].valor_com_iva = this.valor_com_iva(item, quantAtual)
                    }
                })

                // this.setarValorTotalFacturacao();
                // this.setarValorTotalFacturacaoTabelaNotaCredito();

            }

        },

        valor_desconto(produto, quantAtual,itemProduto) { //valor desconto por produto

            // if (quantAtual == 0) {
            //     return 0.00;
            // }
            // console.log(produto.preco_venda_produto);
            // console.log(quantAtual);
            // console.log(this.descontoTotal(produto) / 100);
            return ((produto.preco_venda_produto * quantAtual) * itemProduto.taxaDesconto)
        },

        valor_incidencia(produto, quantAtual) { //valor incidencia por produto
            return (produto.preco_venda_produto * quantAtual) - this.valor_desconto(produto, quantAtual);
        },
        iva_produto(item, quantAtual) { //valor iva por produto
            return (item.produto.tipo_taxa.taxa / 100) * this.valor_incidencia(item, quantAtual);
        },
        valor_retencao(item, quantAtual) {
            return this.valor_incidencia(item, quantAtual) * (item.retencao_produto ? 0.065 : 0.00)
        },

        descontoTotal(item) {

            console.log(item.desconto_produto * 100);
            console.log(item.preco_venda_produto);
            console.log(item.quantidade_produto);

            
            return ((item.desconto_produto * 100) / (item.preco_venda_produto * item.quantidade_produto));
        },

        total_preco_produto(produto, quantidade) {
            return (produto.preco_venda_produto * quantidade);
        },
        setarValorTotalFacturacao() { //seta todos os valores totais da facturação

            //console.log(this.facturacao.desconto)
            this.facturacao.factura.total_preco_factura = 0;
            this.facturacao.factura.valor_a_pagar = 0;
            this.facturacao.factura.desconto = 0
            this.facturacao.factura.numeroItems = 0;
            this.facturacao.factura.total_retencao = 0;
            this.facturacao.factura.total_incidencia = 0;
            this.facturacao.factura.total_iva = 0;
            this.facturacao.factura.troco = 0;

            this.facturacao.factura.facturas_items.map((item, index) => {

                this.facturacao.factura.desconto += this.facturacao.factura.facturas_items[index].desconto_produto
                this.facturacao.factura.numeroItems += this.facturacao.factura.facturas_items[index].quantidade_produto
                this.facturacao.factura.total_retencao += this.facturacao.factura.facturas_items[index].retencao_produto
                this.facturacao.factura.total_incidencia += this.facturacao.factura.facturas_items[index].incidencia_produto
                this.facturacao.factura.total_iva += this.facturacao.factura.facturas_items[index].iva_produto
                this.facturacao.factura.total_preco_factura += this.facturacao.factura.facturas_items[index].total_preco_produto
            })

            this.facturacao.factura.valor_a_pagar = (this.facturacao.factura.total_preco_factura + this.facturacao.factura.total_iva) - (this.facturacao.factura.desconto + this.facturacao.factura.total_retencao)

            if (parseInt(this.facturacao.factura.valor_entregue)) {
                if (this.facturacao.factura.valor_a_pagar) {
                    this.facturacao.factura.troco = (parseInt(this.facturacao.factura.valor_entregue) - this.facturacao.factura.valor_a_pagar)
                }
            } else {
                this.facturacao.factura.troco = 0
            }

            //Formatação do valor extenso
            var extenso = require('extenso');
            let valor_pagar_toFixed = this.facturacao.factura.valor_a_pagar.toFixed(2);
            let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

            this.facturacao.factura.valor_extenso = extenso(valor_a_pagar, {
                number: {
                    decimal: 'informal'
                }
            })

        },

        setarValorTotalFacturacaoTabelaNotaCredito() {

            //console.log(this.facturacao.desconto)
            this.facturacao.facturaRectificada.total_preco_factura = 0;
            this.facturacao.facturaRectificada.valor_a_pagar = 0;
            this.facturacao.facturaRectificada.desconto = 0
            this.facturacao.facturaRectificada.numeroItems = 0;
            this.facturacao.facturaRectificada.total_retencao = 0;
            this.facturacao.facturaRectificada.total_incidencia = 0;
            this.facturacao.facturaRectificada.total_iva = 0;
            this.facturacao.facturaRectificada.troco = 0;

            this.facturacao.facturaRectificada.facturas_items.map((item, index) => {

                this.facturacao.facturaRectificada.desconto += this.facturacao.facturaRectificada.facturas_items[index].desconto_produto
                this.facturacao.facturaRectificada.numeroItems += this.facturacao.facturaRectificada.facturas_items[index].quantidade_produto
                this.facturacao.facturaRectificada.total_retencao += this.facturacao.facturaRectificada.facturas_items[index].retencao_produto
                this.facturacao.facturaRectificada.total_incidencia += this.facturacao.facturaRectificada.facturas_items[index].incidencia_produto
                this.facturacao.facturaRectificada.total_iva += this.facturacao.facturaRectificada.facturas_items[index].iva_produto
                this.facturacao.facturaRectificada.total_preco_factura += this.facturacao.facturaRectificada.facturas_items[index].total_preco_produto
            })

            this.facturacao.facturaRectificada.valor_a_pagar = (this.facturacao.facturaRectificada.total_preco_factura + this.facturacao.facturaRectificada.total_iva) - (this.facturacao.facturaRectificada.desconto + this.facturacao.facturaRectificada.total_retencao)

            if (parseInt(this.facturacao.facturaRectificada.valor_entregue)) {
                if (this.facturacao.facturaRectificada.valor_a_pagar) {
                    this.facturacao.facturaRectificada.troco = (parseInt(this.facturacao.facturaRectificada.valor_entregue) - this.facturacao.facturaRectificada.valor_a_pagar)
                }
            } else {
                this.facturacao.facturaRectificada.troco = 0
            }

            //Formatação do valor extenso
            var extenso = require('extenso');
            let valor_pagar_toFixed = this.facturacao.facturaRectificada.valor_a_pagar.toFixed(2);
            let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

            this.facturacao.facturaRectificada.valor_extenso = extenso(valor_a_pagar, {
                number: {
                    decimal: 'informal'
                }
            })

        },
        async salvarFacturaRetificada() {

            try {

                if (this.recalcular) {
                    this.$loading(true)
                    let responseDocRetificado = await axios.post(`${this.router}/salvarFacturasRecitificadas`, this.facturacao);

                    if (responseDocRetificado.status == 200) {

                        this.$toasted.global.defaultSuccess();

                        Swal.fire({
                            title: 'Sucesso',
                            text: 'Operação realizada com sucesso!...',
                            icon: 'success',
                            confirmButtonColor: '#3d5476',
                            confirmButtonText: 'Ok'
                        });

                        let response = await axios.get(`${this.router}/imprimirDocumentoRetificado/${responseDocRetificado.data.id}/${this.facturacao.factura.id}?viaImpressao=1`, {
                            responseType: "arraybuffer"
                        });

                        if (response.status == 200) {

                            this.$loading(false)
                            var file = new Blob([response.data], {
                                type: "application/pdf"
                            });
                            var fileURL = URL.createObjectURL(file);
                            window.open(fileURL);
                            document.location.reload(true)
                        }

                    }
                } else {
                    this.$toasted.global.defaultError({
                        msg: "Não foi rectificado nenhum item"
                    });
                }

            } catch (error) {
                if (error.response.data.isValid == false) {
                    this.$toasted.global.defaultError({
                        msg: error.response.data.errors
                    });
                    this.$loading(false)
                    return;
                }
            }
        }

    }

};
</script>

<style scoped>
.vue-numeric-input {
    width: 100px !important;
}
</style>
