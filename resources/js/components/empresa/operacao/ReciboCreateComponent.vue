<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Emitir Recibo
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Cadastro
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
                    Os campos marcados com
                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                    são de preenchimento obrigatório.
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">Emitir Recibo</div>
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
                                        <!-- <span v-if="errors.cliente_id" class="error">{{errors.cliente_id[0]}}</span> -->
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
                                        <label class="control-label bold label-select2" for="referencia">Conta Corrente<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="contaCorrenteCliente" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label bold label-select2" for="referencia">Saldo Actual<b class="red fa fa-question-"></b></label>
                                        <div class="input-group">
                                            <input type="text" disabled id="referencia" v-model="saldoActual" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has-info bold" style="left: 0%; position: relative">
                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Factura Liquidar<b class="red fa fa-question-circle"></b></label>
                                        <Select2 :options="OptionsFacturas" @change="facturaChange($event)" placeholder="Selecione a factura">
                                        </Select2>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Valor Factura</label>
                                        <div class="input-group">
                                            <input type="text" disabled="disabled" v-model="valor_a_pagar" id="referencia" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-info-circle bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Total Débito</label>
                                        <div class="input-group">
                                            <input type="text" id="referencia" v-model="totalDebito" disabled="disabled" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-info-circle bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Valor Entregue<b class="red fa fa-question-circle"></b></label>
                                        <div class="input-group">
                                            <input type="number" autocomplete="off" id="referencia" v-model="valor_entregue" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-info-circle bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group has-info bold" style="left: 0%; position: relative">
                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Forma de Pagamento<b class="red fa fa-question-circle"></b></label>
                                        <Select2 :options="pagamentos" v-model="dataRecibo.forma_pagamento_id" placeholder="Selecione a forma de Pagamento">
                                        </Select2>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Valor Retenção</label>
                                        <div class="input-group">
                                            <input type="text" id="referencia" disabled v-model="taxaRetencao" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-info-circle bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label bold label-select2" for="controlo_stock">Borderoux</label>
                                        <div class="input-group">
                                            <input type="text" id="referencia" autocomplete="off" v-model="borderoux" class="col-md-12 col-xs-12 col-sm-3" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-info-circle bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3">
                                        <label class="control-label bold label-select2" for="controlo_stock">Data Operação</label>
                                        <div class="input-group">

                                            <date-pick v-model="data_operacao" :format="'DD-MM-YYYY'"></date-pick>

                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar bigger-110 text-info"></i>
                                            </span>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="form-group has-info bold" style="left: 0%; position: relative">
                                    <div class="col-md-6">
                                        <input class="form-check-input checkedRetencao" :checked="checkedRetencao" :disabled="disabledRetencao" @change="checkRetencao($event)" type="checkbox" value="" id="defaultCheck1" />
                                        <label class="form-check-label" for="defaultCheck1">
                                            Incluir Retenção
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group has-info bold" style="left: 0%; position: relative">
                                    <div class="col-md-12">
                                        <label class="control-label bold label-select2" for="controlo_stock">Observação</label>
                                        <div class="input-group">
                                            <textarea v-model="dataRecibo.observacao" class="form-control" style="font-size: 16px; z-index: 1" name="" id="" cols="200" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button @click.prevent="addCarrinho" class="btn btn-sm btn-success">
                                    <i class="glyphicon glyphicon-plus bigger-110"></i>
                                    <span class="bigger-110 no-text-shadow">Adicionar</span>
                                </button>
                                <div class="widget-box widget-color-green" style="left: 0%">
                                    <div class="table-header widget-header">
                                        Todas as facturas adicionadas
                                    </div>

                                    <!-- div.dataTables_borderWrap -->
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Factura</th>
                                                <th>Descrição</th>
                                                <th>Valor Entregue</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="(c, i) in dataRecibo.reciboItem" :key="c.id">
                                                <td>{{ c.factura_numeracao }}</td>
                                                <td>
                                                    Liquidação da factura {{ c.factura_numeracao }}
                                                </td>
                                                <td>{{ c.factura_valor_entregue | currency }}</td>
                                                <td colspan="1">
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="red" @click="delItemCar(i, c)" style="cursor: pointer;">
                                                            <i data-v-28b992ac="" class="ace-icon fa fa-trash-o fa-2x icon-only bigger-130">
                                                            </i>
                                                        </a>
                                                    </div>
                                                </td>
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
                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvar">
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
import DatePick from "vue-date-pick";
import Swal from "sweetalert2";
import {
    showError,
    baseUrl
} from "./../../../config/global";

export default {
    props: ["guard", "formapagamentos"],
    components: {
        Select2,
        DatePick,
    },

    data() {
        return {
            clientes: [],
            OptionsFacturas: [],
            pagamentos: [],
            facturaCarrinho: [], //variavel usado para for do carrinho
            saldoActual: "",
            valor_a_pagar: "",
            checkedRetencao: false,
            disabledRetencao: false,
            dataRecibo: {
                cliente: {},
                data_operacao: this.dateNow(),
                valor_total_entregue: 0,
                valor_extenso: "",
                observacao: "",
                total_retencao: 0,
                taxa: 0,
                reciboItem: [],
            },
            // checked: true,
            contaCorrenteCliente: "", //somente para mostar na tela
            nomeCliente: "", //somente para mostrar na tela

            factura_id: "",
            numeracaoFactura: "",
            valor_a_pagar: "",
            valor_entregue: "",
            //retencao: 0,
            taxaRetencao: "",
            borderoux: "",
            saldoActual: "",
            data_operacao: this.dateNow(),
            forma_pagamento_id: "",
            totalDebito: "",
            USUARIO_EMPRESA: 2,
            router: "",
        };
    },
    created() {
        this.router =
            this.guard.tipo_user_id == this.USUARIO_EMPRESA ?
            window.location.origin + `/empresa` :
            window.location.origin + `/empresa/funcionario`;
        this.listarClientes();
        this.listarFormaPagamentos();
    },
    methods: {
        toFixed: function (valor) {
            return valor.toLocaleString('de-DE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
        },
        checkRetencao(event) {
            if (event.target.checked) {
                this.checkedRetencao = true;
                //  this.dataRecibo.total_retencao = event.target.checked ?this.retencao : 0.0;
            } else {
                this.checkedRetencao = false;
            }
        },
        async listarClientes() {
            try {
                let response = await axios.get(
                    `${this.router}/recibo/ListarClientesComFacturas`
                );

                if (response.status === 200) {
                    response.data.clientes.forEach((element) => {
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

                        // if (this.clientes.length) {
                        //     let result = this.clientes.find(el => {
                        //         return el.id === element.cliente.id
                        //     });

                        //     if (!result) {
                        //         this.clientes.push({
                        //             id: element.cliente.id,
                        //             nome: element.cliente.nome,
                        //             text: element.cliente.nome + " - NIF- " + element.cliente.nif,
                        //             conta_corrente: element.cliente.conta_corrente,

                        //         })
                        //     }

                        // } else {
                        //     this.clientes.push({
                        //         id: element.cliente.id,
                        //         nome: element.cliente.nome,
                        //         text: element.cliente.nome + " - NIF- " + element.cliente.nif,
                        //         conta_corrente: element.cliente.conta_corrente,

                        //     })
                        // }
                    });

                    this.facturaCarrinho = response.data.facturas;
                }
            } catch (error) {
                console.log("ERRO API");
            }
        },
        async addCarrinho() {

            if (!this.factura_id) {
                this.$toasted.global.defaultError({
                    msg: "Selecione a factura a liquidar",
                });
                return;
            } else if (!this.valor_entregue) {
                this.$toasted.global.defaultError({
                    msg: "Informe o valor entregue",
                });
                return;
            } else if (!this.data_operacao) {
                this.$toasted.global.defaultError({
                    msg: "Informe o data da operação",
                });
                return;
            } else if (!this.dataRecibo.forma_pagamento_id) {
                this.$toasted.global.defaultError({
                    msg: "Informe a forma de pagamento",
                });
                return;
            } else if (this.valor_entregue <= 0) {
                this.$toasted.global.defaultError({
                    msg: "O valor entregue não deve ser negativo",
                });
                return;
            }

            //retorna os dados da factura selecionado
            const item = this.facturaCarrinho.find((element) => {
                if (element.id == this.factura_id) {
                    return element;
                }
            });

            if (this.dataRecibo.reciboItem.length > 0) {
                let result = this.dataRecibo.reciboItem.find((element) => {
                    if (element.factura_id == item.id) {
                        return true;
                    } else {
                        return false;
                    }
                });

                if (result) {
                    this.$toasted.global.defaultError({
                        msg: "Esta factura já está no carrinho",
                    });
                } else {
                    this.pushCarrinho(item);
                    return;
                }
            } else {
                this.pushCarrinho(item);
                return;
            }
        },

        pushCarrinho(item) {

            this.verificaAplicadoRetencao(item.id).then(resultado => {

                var retencao = 0;
                if (resultado) {
                    retencao = 0;
                } else {
                    retencao = this.checkedRetencao ? item.retencao : 0;
                }

                let totalDebito = this.totalDebito.toString().replace(".", "");

                if (parseFloat(this.valor_entregue) > parseFloat(totalDebito)) {
                    this.$toasted.global.defaultError({
                        msg: "Valor entregue é maior que a divida",
                    });
                    return;
                }
                this.dataRecibo.reciboItem.push({
                    factura_id: item.id,
                    factura_numeracao: item.numeracaoFactura,
                    factura_valor_entregue: parseFloat(this.valor_entregue),
                    valor_entregue: parseFloat(this.valor_entregue),
                    retencao: parseFloat(retencao),
                    borderoux: this.borderoux,
                });

                //recalcula o valor do recibo,retencao principal;
                this.dataRecibo.valor_total_entregue += parseFloat(this.valor_entregue);
                this.dataRecibo.total_retencao += retencao;

            })

            //this.dataRecibo.total_retencao += parseFloat(this.retencao);
        },
        async ListarFacturaPorCliente(cliente) {
            try {
                let response = await axios.get(
                    `${this.router}/facturasCliente/${cliente.id}`
                );

                if (response.status === 200) {
                    this.OptionsFacturas = [];
                    response.data.forEach((element) => {
                        this.OptionsFacturas.push({
                            id: element.id,
                            text: element.numeracaoFactura,
                            valor_a_pagar: element.valor_a_pagar,
                        });
                    });

                    this.dataRecibo.cliente = {
                        id: cliente.id,
                        conta_corrente: cliente.conta_corrente,
                        limite_de_credito: cliente.limite_de_credito,
                        nome: cliente.nome,
                    };

                    this.facturas = [];
                    this.pagamentos = [];
                    this.listarFormaPagamentos();
                    this.dataRecibo.observacao = "";
                    // this.facturaCarrinho = response.data; //preenche o array da factura
                    // this.query = ""
                }
            } catch (error) {
                console.log(error);
            }
        },
        dateNow() {
            const o_date = new Intl.DateTimeFormat();
            const f_date = (m_ca, m_it) =>
                Object({
                    ...m_ca,
                    [m_it.type]: m_it.value,
                });
            const m_date = o_date.formatToParts().reduce(f_date, {});

            return m_date.day + "-" + m_date.month + "-" + m_date.year;
        },

        async verificaAplicadoRetencao(facturaId) {

            let APLICADO_RETENCAO = 1;

            let response = await axios.get(
                `${this.router}/recibo/verificaAplicacaoRetencaoRecibo/${facturaId}`
            );

            if (response.data == true) {
                this.checkedRetencao = true;
                this.disabledRetencao = true;
                return true;
            } else {
                $(".checkedRetencao").removeAttr("checked");
                $(".checkedRetencao").removeAttr("disabled");
            }

            return response.data;

        },
        async facturaChange(id) {

            try {
                let response = await axios.get(`${this.router}/factura/${id}`);

                if (response.status === 200) {
                    let idFactura = response.data.factura.id;

                    //Pega o total de valor entregue desta factura
                    this.valor_a_pagar = parseFloat(response.data.factura.valor_a_pagar);
                    this.totalDebito = this.valor_a_pagar - response.data.totalEntregue;

                    this.totalDebito = this.toFixed(this.totalDebito);
                    this.valor_a_pagar = this.toFixed(this.valor_a_pagar);

                    this.factura_id = idFactura;
                    this.numeracaoFactura = response.data.factura.numeracaoFactura;
                    this.valor_entregue = "";
                    this.taxaRetencao = this.toFixed(response.data.factura.retencao);
                    //this.taxaRetencao = response.data.factura.retencao > 0 ? 0.65 : 0;
                    this.retencao = response.data.factura.retencao;
                    this.dataRecibo.taxa = response.data.factura.total_iva ? 0.14 : 0.0;
                    this.pagamentos = [];

                    this.listarFormaPagamentos();

                    //verifica se foi aplicado retençao
                    this.verificaAplicadoRetencao(response.data.factura.id);
                }
            } catch (error) {}

            // const factura = this.facturas.find((element) => {
            //     if (element.id == id) {
            //         return element
            //     }
            // });

            // this.valor_a_pagar = factura.valor_a_pagar;
            // this.numeracaoFactura = factura.text;
            // this.factura_id = factura.id;
        },
        async listarFormaPagamentos() {
            this.formapagamentos.forEach((element) => {
                this.pagamentos.push({
                    id: element.id,
                    text: element.descricao,
                });
            });

        },
        delItemCar(index, element) {

            let retencao = this.checkedRetencao ? this.retencao : 0;

            this.dataRecibo.reciboItem.splice(index, 1);
            this.dataRecibo.valor_total_entregue -= parseFloat(this.valor_entregue);
            this.dataRecibo.total_retencao -= retencao;
        },
        selectCliente(cliente) {
            if (cliente) {
                this.nomeCliente = cliente.nome;
                this.contaCorrenteCliente = cliente.conta_corrente;
                this.valor_a_pagar = "";
                this.valor_entregue = "";
                this.totalDebito = "";
                this.factura_id = null;
                this.dataRecibo.nome_do_cliente = cliente.nome;
                this.dataRecibo.telefone_cliente = cliente.telefone_cliente;
                this.dataRecibo.nif_cliente = cliente.nif_cliente;
                this.dataRecibo.email_cliente = cliente.email_cliente;
                this.dataRecibo.endereco_cliente = cliente.endereco_cliente;
                this.dataRecibo.conta_corrente_cliente = cliente.conta_corrente;

                this.ListarFacturaPorCliente(cliente);
                this.dataRecibo.reciboItem = []; //zero o carrinho
                this.mostrarSaldoCliente(cliente.id);
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
        async salvar() {

            this.$loading(true);
            //Formatação do valor extenso
            var extenso = require("extenso");
            let valor_pagar_toFixed = this.dataRecibo.valor_total_entregue.toFixed(2);
            let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

            this.dataRecibo.valor_extenso = extenso(valor_a_pagar, {
                number: {
                    decimal: "informal"
                },
            });

            if (!this.dataRecibo.reciboItem.length) {
                this.$toasted.global.defaultError({
                    msg: "Adicione facturas no carrinho",
                });
                this.$loading(false);
                return;
            }

            // this.dataRecibo.totalDebito = this.totalDebito - this.valor_entregue;

            try {

                let responseComparaData = await axios.get(
                    `${this.router}/comparaDataDocumento?tabela=recibos`
                );

                if (responseComparaData.data.status == 401) {
                    this.$toasted.global.defaultError({
                        msg: responseComparaData.data.errors
                    });
                    return;
                }

                let response = await axios.post(`${this.router}/recibo/salvar`, this.dataRecibo, {
                    responseType: "arraybuffer"
                });

                if (response.status === 200 && response.data.status != 401) {

                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Factura registada com sucesso!...',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            this.$loading(false);
                            var file = new Blob([response.data], {
                                type: "application/pdf",
                            });
                            var fileURL = URL.createObjectURL(file);
                            window.open(fileURL);
                            document.location.reload(true);
                        }
                    });

                } else {
                    this.$loading(false);
                    console.log("Erro ao carregar pdf");
                }
            } catch (error) {
                console.log("Erro Api");
            }
        },
    }

};
</script>

<style>
</style>
