<template>
<div id="info-cliente">
    <div class="col-md-12" style="padding:0">
        <div class="row">
            <div class="col-md-12">
                <span class="input-form-icon">
                    <form action id="search-form">
                        <input type="text" class="col-md-12 search-query" placeholder="Buscar cliente..." autocomplete="off" v-model="searchQuery" autofocus />

                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                        <!-- <i class="fa fa-remove nav-search-icon" id="icon-remove" @click="clearInput"></i> -->
                    </form>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="area-result-pesquisa" v-if="searchQuery">
        <div class="user-dropdown-content">
            <div v-for="c in resultQuery" :key="c.id" class="user-dropdown-content-item" @click="adicionaCliente(c)">
                <a>
                    <i class="fa fa-user"></i>
                    <span>{{c.nome}}</span>
                </a>
                <!-- <a>
                    <span>NIF:</span>
                    {{c.nif}}
                </a> -->
            </div>

            <div v-if="resultQuery.length == 0" id="not-client">
                <div>
                    <b>Cliente não encontrado</b>
                </div>
                <div id="btn-create-cliente">
                    <a href="#criar_cliente" data-toggle="modal" id="add-new-searchList">
                        <i class="fa fa-plus-circle fa-lg text-success"></i>
                        <br />Criar Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CRIAR CLIENTE -->
    <div id="criar_cliente" class="modal fade criar_cliente">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar cliente
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do cliente
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_cliente">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do cliente
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_cliente" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nome
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.nome" id="nome" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nome?'has-error':''" />
                                                            <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Email
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                            </span> </label>
                                                        <div class>
                                                            <input type="email" v-model="cliente.email" value id="email" class="col-md-12 col-xs-12 col-sm-4" :class="errors.email?'has-error':''" />
                                                            <span v-if="errors.email" class="error">{{errors.email[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Telefone
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.telefone_cliente" value id="pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoa_contacto?'has-error':''" />
                                                            <span v-if="errors.telefone_cliente" class="error">{{errors.telefone_cliente[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Web Site
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.website" value id="website" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Endereço
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.endereco" value id="endereco" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nacionalidade
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="paises" v-model="cliente.pais_id">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            NIF
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.nif" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" />
                                                            <span v-if="errors.nif" class="error">{{errors.nif[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="tipocliente">
                                                            Tipo Cliente
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="tipoCliente" v-model="cliente.tipo_cliente_id">
                                                            </Select2>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="gestor">
                                                            Gestor
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="gestores" v-model="cliente.gestor_id">
                                                            </Select2>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Pessoa de Contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="tipocliente">
                                                            Número de Contracto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.numero_contrato" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="gestor">
                                                            Data Contracto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <date-pick v-model="cliente.data_contrato" :format="'YYYY-MM-DD'"></date-pick>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="gestor">
                                                            Tipo Conta Corrente
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="tipo_conta_corrente" v-model="tipoContaCorrente">
                                                            </Select2>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="saldo">
                                                            Conta Corrente
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <input type="text" v-model="cliente.conta_corrente" disabled readonly id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="saldo">
                                                            Taxa de Desconto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                            </span> </label>
                                                        <div class>
                                                            <input type="number" v-model.number="cliente.taxa_de_desconto" id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="saldo">
                                                            Limite de Crédito
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                            </span> </label>
                                                        <div class>
                                                            <input type="number" v-model.number="cliente.limite_de_credito" id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="cadastrarCliente">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--/ MODAL DE CRIAR fornecedorS-->
    <!-- FIM MODAL CRIAR CLIENTE -->
</div>
</template>

<script>
import {
    baseUrl,
    showError
} from "../../../config/global";
import Select2 from 'v-select2-component';
import DatePick from 'vue-date-pick';

export default {
    components: {
        Select2,
        DatePick

    },

    data() {
        return {
            searchQuery: null,
            paises: [],
            tipoCliente: [],
            gestores: [],
            cliente: {
                status_id: 1, //inicia com status do select2 ativo
                saldo: 0,
                data_contrato: this.formatDate(),
                conta_corrente: "31.1.2.1.***",
                limite_de_credito: 0,
                taxa_de_desconto: 0,
                tipo_conta_corrente: null
            },
            errors: [],
            tipo_conta_corrente: [ //array do option do select tipo conta corrente
                {
                    id: "Nacional",
                    text: "Nacional"
                },
                {
                    id: "Estrangeiro",
                    text: "Estrangeiro"
                },

            ],
            tipoContaCorrente: "Nacional",
        };
    },
    computed: {
        clientes() {
            return this.$store.getters.clientes;
        },
        resultQuery() {
            if (this.searchQuery) {
                return this.clientes.filter(item => {
                    return item.nome.toLowerCase().match(this.searchQuery)
                           || item.nome.toUpperCase().match(this.searchQuery)
                        //    || item.email.toLowerCase().match(this.searchQuery)
                        //    || item.email.toUpperCase().match(this.searchQuery)
                        //    || item.telefone_cliente.toLowerCase().match(this.searchQuery)
                        //    || item.conta_corrente.toLowerCase().match(this.searchQuery)
                        //    || item.id==this.searchQuery // quando o valor a pesquisar é um inteiro
                        //    || item.endereco.toLowerCase().match(this.searchQuery)
                        //    || item.endereco.toUpperCase().match(this.searchQuery)
                });
            }
        }
    },
    created() {
        this.$store.dispatch("LISTAR_CLIENTES");
        this.loadPais();
        this.loadTipoCliente();
        this.loadGestores();
    },
    methods: {
        adicionaCliente(cliente) {

            const order = {
                cliente_id: cliente.id,
                nif_cliente: cliente.nif,
                nome_do_cliente: cliente.nome,
                telefone_cliente: cliente.pessoa_contacto,
                email_cliente: cliente.email,
                endereco_cliente: cliente.endereco,
                conta_corrente_cliente: cliente.conta_corrente
            };

            this.$store.dispatch("SET_CLIENTE_FACTURACAO", order);
            this.searchQuery = null;
        },
        loadPais() {
            axios.get(`${baseUrl}/paises`).then(res => {

                res.data.forEach(item => {

                    this.paises.push({
                        id: item.id,
                        text: item.designacao
                    })

                });
            });
        },

        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            return today;
        },
        loadTipoCliente() {
            axios.get(`${baseUrl}/tipoCliente`).then(res => {

                res.data.forEach(item => {

                    this.tipoCliente.push({
                        id: item.id,
                        text: item.designacao
                    })

                });
            });
        },
        loadGestores() {
            axios.get(`${baseUrl}/empresa/clientes/pegar-dependecias`).then(res => {

                res.data.forEach(item => {

                    this.gestores.push({
                        id: item.id,
                        text: item.nome
                    })

                });
            });
        },
        cadastrarCliente() {
            this.errors = [];

            this.cliente.tipo_conta_corrente = this.tipoContaCorrente;

            axios
                .post(`${baseUrl}/empresa/clientes/adicionar`, this.cliente)
                .then(res => {
                    if (res.data) {
                        this.$toasted.global.defaultSuccess();
                        this.searchQuery = null;
                        this.reset()
                        this.$store.dispatch("LISTAR_CLIENTES");
                    }
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.$toasted.global.defaultError({
                            msg: "Erro ao cadastrar"
                        });
                        this.errors = error.response.data.errors;
                    }
                });
        },
        reset() {
            this.cliente = {
                status_id: 1, //inicia com status do select2 ativo
                saldo: 0,
                data_contrato: this.formatDate(),
                conta_corrente: "31.1.2.1.***",
                limite_de_credito: 0,
                taxa_de_desconto: 0,
                tipo_conta_corrente: null
            }
        },
        clearInput() {
            this.searchQuery = null
        }
    },
    watch: {
        tipoContaCorrente() {

            if (this.tipoContaCorrente == "Nacional") {
                this.cliente.conta_corrente = "31.1.2.1.***";
            } else {
                this.cliente.conta_corrente = "31.1.2.2.***";
            }
        }
    }
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

#area-result-pesquisa {
    z-index: 999;
}
</style>
