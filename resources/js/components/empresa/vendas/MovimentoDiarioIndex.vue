<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Movimentos diário
        </h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                <div class="second-row">
                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            <form action="/action_page.php">
                                <fieldset>
                                    <legend>Periodo em Análise:</legend>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-3">
                                            <label class="control-label bold label-select2" for="designacao">Data de inicio<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="datetime-local" v-model="filter.data_inicio" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label bold label-select2" for="designacao">Data de fim<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="datetime-local" v-model="filter.data_fim" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend style="margin-bottom:10px">Filtrar movimentos</legend>
                                    <div class="form-group has-info bold">
                                        <div class="col-md-4">
                                            <label for="armazem">Armazém</label>
                                            <Select2 id="armazem" :options="optionsArmazens" v-model="filter.armazem_id" style="width: 100%" placeholder="Escolha o armazém">
                                            </Select2>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="armazem">Clientes</label>
                                            <Select2 id="clientes2" :options="optionsClientes" v-model="filter.cliente_id" style="width: 100%" placeholder="Escolha o cliente">
                                            </Select2>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="armazem">Tipo factura</label>
                                            <Select2 id="clientes3" :options="tipoDocumentos" v-model="filter.tipoDocumento" style="width: 100%" placeholder="Escolha o cliente">
                                            </Select2>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Tipo de Factura:</legend>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-3">
                                            <label>
                                                <input name="form-field-radio1" type="radio" class="ace" :value="1" v-model="filter.factura_impressao" />
                                                <span class="lbl">Sintéctica</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label>
                                                <input name="form-field-radio2" type="radio" class="ace" :value="2" v-model="filter.factura_impressao" />
                                                <span class="lbl">Detalhada</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- <fieldset>
                                    <legend>Ver dados do utilizador:</legend>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative" id="radioUtilizador">
                                        <div class="col-md-4">

                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" @click="checkRadio($event)" :value="false" id="all" v-model="filter.all" type="radio" class="ace" />
                                                    <span class="lbl">Todos</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label>
                                                Buscar por clientes
                                            </label>
                                            <Select2 id="clientes" :options="optionsClientes" @select="selecionarCliente" v-model="filter.cliente_id" style="width: 100%" placeholder="Escolha o cliente">
                                            </Select2>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Incluir:</legend>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="formaPagamento">
                                                Forma Pagamento
                                            </label>
                                            <Select2 id="formaPagamento" :options="optionsFormaPgt" v-model="filter.formas_pagamento_id" style="width: 100%" placeholder="Escolha forma de pagamento">
                                            </Select2>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="facturas">
                                                Facturas
                                            </label>
                                            <Select2 id="facturas" :options="optionsTipoFactura" v-model="filter.tipo_factura" style="width: 100%" placeholder="Escolha a factura">
                                            </Select2>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="armazem">
                                                Escolha o armazém
                                            </label>
                                            <Select2 id="armazem" :options="optionsArmazens" v-model="filter.armazem_id" style="width: 100%" placeholder="Escolha o armazém">
                                            </Select2>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Tipo de Factura:</legend>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-3">
                                            <label>
                                                <input name="form-field-radio1" type="radio" v-model="filter.factura_impressao" class="ace" :value="1" />
                                                <span class="lbl">Sintéctica</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label>
                                                <input name="form-field-radio2" type="radio" v-model="filter.factura_impressao" class="ace" :value="2" />
                                                <span class="lbl">Detalhada</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset> -->
                                <div class="clearfix form-actions">
                                    <div class="col-md-9">
                                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="imprimirMovimento">
                                            <i class="ace-icon fa fa-print bigger-110"></i>
                                            Imprimir
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import moment from 'moment'

import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Select2 from "v-select2-component";

export default {
    components: {
        Select2,
        DatePicker,
    },
    props: ["formapagamento", "clientes", "armazens", "tipofactura", "guard"],
    data() {
        return {

            filter: {
                data_inicio: this.dateNow(),
                data_fim: this.dateNow1(),
                factura_impressao: 1,
                tipoDocumento: 1,
                // all: "",
                // cliente_id: "",
                // formas_pagamento_id: null,
                // // operador: "",
                // tipo_factura: 1
            },
            USUARIO_EMPRESA: 2,
            router: "",
            optionsFormaPgt: [],
            optionsTipoFactura: [],
            optionsClientes: [],
            optionsArmazens: [],
            tipoDocumentos:[
                {id: 1, text:"Factura recibo"},
                {id: 2, text:"Factura"}
            ]

        };
    },
    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },
    mounted() {
        this.listarClientes()
        this.listarArmazens();
        // this.listarFormaPagamentos();
        // this.listarTipoFactura()

        // this.checkedBtnAll();

    },
    methods: {

        // checkImpressao(doc_impressao){
        //     this.filter.factura_impressao = doc_impressao.target.value
        // },

        selecionarCliente(cliente) {
            if (cliente.selected) {
                document.getElementById("all").checked = false;
            }
        },

        checkedBtnAll() {
            document.getElementById("all").checked = true;
            this.filter.all = true;

        },

        checkRadio(radioChecked) {
            this.filter.cliente_id = null;
            this.listarClientes()
        },

        async imprimirMovimento() {

            this.filter.data_fim = moment(String(this.filter.data_fim)).format('YYYY-MM-DD HH:mm:ss')
            this.filter.data_inicio = moment(String(this.filter.data_inicio)).format('YYYY-MM-DD HH:mm:ss')

            this.$loading(true);
            try {

                let response = await axios.post(`${this.router}/imprimirMovimentoDiario`, this.filter, {
                    responseType: "arraybuffer",
                });
               
                if (response.status === 200) {
                    this.$loading(false);
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                    document.location.reload(true)
                }
    
            } catch (error) {
                this.$toasted.global.defaultError({
                    msg: "Sem movimentos para está filtragem"
                });
                this.$loading(false);
                console.log("Erro API");
            }
        },
        listarFormaPagamentos() {

            this.formapagamento.forEach(formaPgt => {
                this.optionsFormaPgt.push({
                    id: formaPgt.id,
                    text: formaPgt.descricao
                })
            });
        },
        listarTipoFactura() {
            this.tipofactura.forEach(tipoFactura => {
                this.optionsTipoFactura.push({
                    id: tipoFactura.id,
                    text: tipoFactura.designacao
                })
            });
            this.filter.tipo_factura = this.optionsTipoFactura[0].id
        },
        listarClientes() {
            this.optionsClientes = [];
            this.clientes.forEach(cliente => {
                this.optionsClientes.push({
                    id: cliente.id,
                    text: cliente.nome
                })
            });
             this.filter.cliente_id = this.clientes[0].id
        },
        listarArmazens() {
            this.armazens.forEach(armazem => {
                this.optionsArmazens.push({
                    id: armazem.id,
                    text: armazem.designacao
                })
            });
            this.filter.armazem_id = this.armazens[0].id
        },

        dateNow1() {

            var today = new Date();

            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            var hours = today.getHours();
            var minutes = today.getMinutes();
            today = yyyy + '-' + mm + '-' + dd + 'T' + this.addDecimal(hours) + ':' + this.addDecimal(minutes);
            return today;
        },

        addDecimal(value) {
            if (value < 10) {
                return '0' + value;
            }
            return value
        },
        dateNow() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd + 'T' + '00:00';
            return today;
        }
    }

}
</script>

<style scoped>
fieldset legend {
    font-size: 15px;
    margin-bottom: 0px;
    font-weight: 600;
}

#filter {
    margin-bottom: 15px;
}

.box-content {
    background: rgb(236, 241, 247);
    padding: 20px;
    height: 100%;
}

#botoes {
    left: 0%;
    border-radius: 15px;
    margin-top: 0.1%;
    padding: 6px 12px 6px 12px;
    position: relative;
    text-transform: uppercase;
}

.is-invalid,
.invalid-feedback {
    border-color: red;
    color: red;
}
</style>
