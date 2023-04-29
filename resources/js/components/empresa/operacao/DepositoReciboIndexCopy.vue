<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Déposito de valores
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Recibo
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
                    <div class="search-text">
                        <i class="fa fa-product-hunt"></i>
                        Emitir Recibo
                    </div>
                </div>
            </div>
        </div>

        <!-- PESQUISAR CLIENTES  -->
        <div class="row">
            <div class="col-md-12">
                <div class="input-group" style="margin-top:20px">
                    <input type="text" style="padding-left:10px" placeholder="Pesquisar por nome, nif do clientes" autocomplete="off" id="name" v-model="query" @keyup="changeName" required class="col-md-12 col-xs-12 col-sm-4" />
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-search bigger-110 text-info"></i>
                    </span>
                </div>
            </div>
        </div>
        <!-- FIM PESQUISAR CLIENTES  -->

        <!-- CLIENTES ENCONTRADOS  -->
        <div class="col-md-12" id="area-result-pesquisa" v-if="facturas.length > 0">
            <div class="user-dropdown-content">
                <div v-for="c in facturas" :key="c.id" class="user-dropdown-content-item" @click.prevent="addCliente(c.cliente)">
                    <a v-if="c.cliente">
                        <i class="fa fa-user"></i>
                        <span>{{c.cliente.nome}}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- FIM CLIENTES ENCONTRADOS  -->

        <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form" style="margin-top:20px">
            <div class="second-row">
                <div class="tabbable">
                    <div class="tab-content profile-edit-tab-content">
                        <div id="dados_fornecedor" class="tab-pane in active" style="">
                            <!-- INICIO  -->
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="controlo_stock">Cliente</label>
                                    <div class="input-group">
                                        <input type="text" disabled="disabled" v-model="dataRecibo.cliente.nome" id="referencia" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="controlo_stock">Saldo Actual</label>
                                    <div class="input-group">
                                        <input type="text" disabled="disabled" v-model="dataRecibo.cliente.limite_de_credito" id="referencia" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="controlo_stock">Conta Corrente</label>
                                    <div class="input-group">
                                        <input type="text" disabled="disabled" id="referencia" v-model="dataRecibo.cliente.conta_corrente" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
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
                                        <input type="text" disabled="disabled" id="referencia" v-model="valor_a_pagar" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Total Débito</label>
                                    <div class="input-group">
                                        <input type="text" id="referencia" disabled="disabled" v-model="totalDebito" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Valor Entregue<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" id="referencia" v-model="valor_entregue" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">

                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Forma de Pagamento<b class="red fa fa-question-circle"></b></label>
                                    <Select2 :options="pagamentos" v-model="formaPagamento" placeholder="Selecione a forma de Pagamento">
                                    </Select2>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Valor Retenção</label>
                                    <div class="input-group">
                                        <input type="text" id="referencia" v-model="retencao" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Borderoux</label>
                                    <div class="input-group">
                                        <input type="text" id="referencia" v-model="borderoux" class="col-md-12 col-xs-12 col-sm-3" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="controlo_stock">Data Operação</label>
                                    <div class="input-group">

                                        <date-pick v-model="data_operacao" :format="'DD-MM-YYYY'"></date-pick>

                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">

                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="controlo_stock">Observação</label>
                                    <div class="input-group">
                                        <textarea class="form-control" style="font-size:16px;z-index:1" name="" id="" v-model="dataRecibo.observacao" cols="200" rows="3"></textarea>

                                    </div>
                                </div>
                            </div>

                            <button @click.prevent="addCarrinho" class="btn btn-sm btn-success">
                                <i class="glyphicon glyphicon-plus bigger-110"></i>
                                <span class="bigger-110 no-text-shadow">Adicionar</span>
                            </button>

                            <!-- tabela do carrinho  -->

                            <div class="widget-box widget-color-green" style="left: 0%">
                                <div class="table-header widget-header">
                                    Todos produtos do Sistema
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
                                            <td>{{c.factura_numeracao}}</td>
                                            <td>Liquidação da factura {{c.factura_numeracao}}</td>
                                            <td>{{c.factura_valor_entregue | currency}}</td>
                                            <td colspan="1">
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="red" @click="delItemCar(i,c)">
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
                            <div class="clearfix form-actions" v-if="dataRecibo.reciboItem.length">
                                <button class="search-btn" type="submit" style="border-radius: 10px; float:right" @click.prevent="salvar">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </button>
                            </div>

                            <!-- FIM -->
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <!-- /.row -->
    </div>
</section>
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import DatePick from 'vue-date-pick';
import {
    showError,
    baseUrl
} from "./../../../config/global";

export default {
    components: {
        Select2,
        DatePick
    },

    data() {
        return {
            query: "",
            facturas: [], //variavel para pegar o cliente apartir da factura
            facturaCarrinho: [], //variavel usado para for do carrinho
            OptionsFacturas: [],
            pagamentos: [], //array de todos as formas de pagamentos

            dataRecibo: {

                cliente: {},
                valor_total_entregue: 0,
                observacao: "",
                total_retencao: 0,
                formaPagamento: "",
                reciboItem: []
            },
            factura_id: "",
            numeracaoFactura: "",
            valor_a_pagar: "",
            valor_entregue: "",
            retencao: 0,
            borderoux: "",
            data_operacao: this.dateNow(),
            formaPagamento: "",
            totalDebito: ""

            //cliente: {},
            // carrinho: []
        };
    },

    mounted() {

        this.listarFormaPagamentos()

    },

    methods: {

        async changeName() {
            if (this.query) {

                try {
                    let response = await axios.get(window.location.origin + `/empresa/clientes/${this.query}`);

                    if (response.status === 200) {
                        this.facturas = response.data;
                    }
                } catch (error) {
                    this.clientes = []
                    console.log("erro na requisição ou sem dados");
                }

            }

        },
        dateNow() {
            const o_date = new Intl.DateTimeFormat;
            const f_date = (m_ca, m_it) => Object({
                ...m_ca,
                [m_it.type]: m_it.value
            });
            const m_date = o_date.formatToParts().reduce(f_date, {});

            return m_date.day + '-' + m_date.month + '-' + m_date.year
        },

        //Metodo que retorna valores ao actualizar o select da factura liquidar
        async facturaChange(id) {

            try {
                let response = await axios.get(window.location.origin + `/empresa/factura/${id}`)

                if (response.status === 200) {

                    let idFactura = response.data.factura.id;

                    //Pega o total de valor entregue desta factura
                    this.valor_a_pagar = parseFloat(response.data.factura.valor_a_pagar);
                    this.numeracaoFactura = response.data.factura.numeracaoFactura;
                    this.factura_id = idFactura;
                    this.totalDebito = this.valor_a_pagar - response.data.totalEntregue;
                }
            } catch (error) {

            }

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

            try {
                let response = await axios.get(
                    window.location.origin + `/empresa/facturacao/formaPagamentos`
                );

                if (response.status === 200) {

                    response.data.formasPagamento.forEach(element => {
                        this.pagamentos.push({
                            id: element.id,
                            text: element.designacao
                        })
                    })
                }
            } catch (error) {
                console.log("erro na requisição");
            }

        },
        async addCliente(cliente) {

            try {
                let response = await axios.get(window.location.origin + `/empresa/facturasCliente/${cliente.id}`);

                if (response.status === 200) {

                    this.OptionsFacturas = [];
                    this.resetInput()

                    response.data.forEach(element => {
                        this.OptionsFacturas.push({
                            id: element.id,
                            text: element.numeracaoFactura,
                            valor_a_pagar: element.valor_a_pagar
                        });

                    });

                    this.dataRecibo.cliente = {
                        id: cliente.id,
                        conta_corrente: cliente.conta_corrente,
                        limite_de_credito: cliente.limite_de_credito,
                        nome: cliente.nome
                    }

                    this.facturas = []
                    this.formaPagamento = []
                    this.dataRecibo.observacao = "";
                    this.facturaCarrinho = response.data; //preenche o array da factura
                    this.query = ""

                }
            } catch (error) {
                console.log(error)
            }

        },
        delItemCar(index, element) {
            this.dataRecibo.reciboItem.splice(index, 1);
            //recalcula o valor do recibo,retencao principal;
            this.dataRecibo.valor_total_entregue -= parseFloat(element.valor_entregue);
            this.dataRecibo.total_retencao -= parseFloat(element.retencao);
        },
        resetInput() {
            this.facturas = []
            this.dataRecibo.cliente = {}
            this.valor_a_pagar = ""
        },
        addCarrinho() {

            if (!this.factura_id) {

                this.$toasted.global.defaultError({
                    msg: "Selecione a factura a liquidar"
                });
                return
            } else if (!this.valor_entregue) {
                this.$toasted.global.defaultError({
                    msg: "Informe o valor entregue"
                });
                return
            } else if (!this.data_operacao) {

                this.$toasted.global.defaultError({
                    msg: "Informe o data da operação"
                });
                return
            } else if (!this.formaPagamento) {

                this.$toasted.global.defaultError({
                    msg: "Informe a forma de pagamento"
                });
                return
            }

            //retorna os dados da factura selecionado
            const item = this.facturaCarrinho.find((element) => {
                if (element.id == this.factura_id) {
                    return element
                }
            });

            if (this.dataRecibo.reciboItem.length > 0) {
                let result = this.dataRecibo.reciboItem.find(element => {
                    if (element.factura_id == item.id) {
                        return true
                    } else {
                        return false
                    }

                });

                if (result) {
                    this.$toasted.global.defaultError({
                        msg: "Esta factura já está no carrinho"
                    });
                } else {
                    this.pushCarrinho(item)
                    return
                }
            } else {

                this.pushCarrinho(item)
                return
            }

        },
        pushCarrinho(item) {

            this.dataRecibo.reciboItem.push({
                factura_id: item.id,
                factura_numeracao: item.numeracaoFactura,
                factura_valor_entregue: parseFloat(this.valor_entregue),
              //  forma_pagamento_id: this.formaPagamento,
                valor_entregue: parseFloat(this.valor_entregue),
                retencao: parseFloat(this.retencao),
                borderoux: this.borderoux
            })

            //recalcula o valor do recibo,retencao principal;
            this.dataRecibo.valor_total_entregue += parseFloat(this.valor_entregue);
            this.dataRecibo.total_retencao += parseFloat(this.retencao);

            // this.dataRecibo.reciboItem.push({
            //     factura_id: item.id,
            //     factura_numeracao: item.numeracaoFactura,
            //     factura_valor_a_pagar: item.valor_a_pagar,
            //     factura_valor_entregue: this.valor_entregue,
            //    // cliente_id: this.cliente.id,
            //     forma_pagamento_id: this.formaPagamento,
            //     valor_entregue: this.valor_entregue,
            //     observacao: this.observacao,
            //     retencao: this.retencao,
            //     borderoux: this.borderoux,
            //    // cliente_nome: this.cliente.nome,
            //     cliente_conta_corrente: this.cliente.conta_corrente,
            //     cliente_limite_de_credito: this.cliente.limite_de_credito,
            // })

        },

        async salvar() {

            try {
                let response = await axios.post(window.location.origin + `/empresa/recibo/salvar`, this.dataRecibo, {
                    responseType: "arraybuffer"
                });

                if (response.status === 200) {

                    this.$loading(false)
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");

                }

            } catch (error) {
                console.log("Erro Api")
            }
        }

    },

};
</script>

<style scoped>
#result-search {
    position: relative;
}

.has-error {
    border-color: #f2a696 !important;
}

/* FIM */
.user-dropdown-content {
    position: absolute;
    left: 0px;
    background-color: #f9f9f9;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    padding: 10px;
    z-index: 1;
    width: 100%;
    display: flex;
    flex-direction: column;
    transition: visibility 0s, opacity 0.5s linear;
}

.user-dropdown-content-item {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #ccc;
}

.user-dropdown-content-item span {
    font-weight: bold;
}

.user-dropdown-content a {
    text-decoration: none;
    color: #000;
    padding: 7px;
}

.user-dropdown-content-item:hover {
    background-color: #ededed;
    cursor: pointer;
}

.search-query {
    border: 1px solid #6fb3e0;
    border-radius: 4px !important;
    padding-left: 24px;
}

.search-query:focus {
    border: 1px solid #6fb3e0;
}

span.input-form-icon {
    position: relative;
}

span.input-form-icon .ace-icon {
    padding: 0 3px;
    z-index: 2;
    position: absolute;
    top: 1px;
    bottom: 1px;
    left: 3px;
    line-height: 30px;
    display: inline-block;
    color: #6fb3e0 !important;
    font-size: 16px;
}

#not-client {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#btn-create-cliente:hover {
    border-radius: 5px;
    background-color: #ccc;
}

#add-new-searchList {
    text-align: center;
    display: block;
}

.vdpComponent.vdpWithInput>input {
    /* padding: 8px !important; */
    width: 195px !important;
}

#area-result-pesquisa {
    z-index: 999;
}
</style>
