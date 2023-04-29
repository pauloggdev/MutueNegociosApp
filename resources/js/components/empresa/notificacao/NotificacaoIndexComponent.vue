<template>
<div>
    <div class="page-header">
        <h1>
            Entradas
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Notificações
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabbable">
                        <div class="tab-content no-border no-padding">
                            <div id="inbox" class="tab-pane in active">
                                <div class="message-container">
                                    <div id="id-message-list-navbar" class="message-navbar clearfix">
                                        <div class="message-bar">
                                            <div class="message-toolbar hide">
                                                <button type="button" class="btn btn-xs btn-white btn-primary" @click.prevent="deletarNotificacoes">
                                                    <i class="ace-icon fa fa-trash-o bigger-125 orange"></i>
                                                    <span class="bigger-110">Delete</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="messagebar-item-left">
                                                <label class="inline middle">
                                                    <input type="checkbox" id="id-toggle-all" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                                &nbsp;
                                                <div class="inline position-relative">
                                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                                        <i class="ace-icon fa fa-caret-down bigger-125 middle"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="nav-search minimized">
                                                <form class="form-search">
                                                    <span class="input-icon">
                                                        <input type="text" autocomplete="off" class="input-small nav-search-input" placeholder="Search inbox ..." />
                                                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                                                    </span>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="message-list-container">
                                        <div class="message-list" id="message-list">

                                            <div class="row" v-if="notificacoesData.length <= 0">
                                                <div class="panel-body">
                                                    <h5>Não existe nenhuma notificação de entrada</h5>
                                                </div>
                                            </div>

                                            <div v-for="(notificacao, index) in notificacoesData" :key="notificacao.id" :id="notificacao.id" class="message-item" :class="notificacao.read_at?'':'message-unread'">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                                <span>{{notificacao.data.empresa}}</span>
                                                <span class="sender">{{notificacao.created_at | formatDateTime}}</span>

                                                <a class="accordion-toggle" @click.prevent="notificationRead(notificacao)" data-toggle="collapse" :data-parent="'#'+index" :href="'#'+index">
                                                    <span class="summary">
                                                        <span class="text">
                                                            {{notificacao.data.descricao}}
                                                        </span>
                                                    </span>
                                                </a>
                                                <div class="panel-collapse collapse" :id="index">
                                                    <div class="panel-body">
                                                        {{notificacao.data.descricao}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!-- /.tab-content -->
                    </div><!-- /.tabbable -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
</template>

<script>
import Swal from "sweetalert2";
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";
export default {

    props: ["router"],
    data() {
        return {
            notificacoesData: [],

        }
    },
    mounted() {
        this.listarNotificacoes();
        console.log(this.notificacoesData.length);
    },

    computed: {
        notificacoes() {
            return this.notificacoesData
        }
    },
    methods: {
        notificationRead(notification) {


           // console.log(notification.id);return;

            if (notification.read_at == null) {

                axios.put(`/empresa/notificationsRead`, {
                        id: notification.id
                    }).then((response) => {
                        if (response.status == 200) {
                            this.listarNotificacoes()
                        }
                    })
                    .catch((error) => {
                        console.log("Erro API")
                    });

            }

        },

        listarNotificacoes() {
            axios.get(`/empresa/notificationsAll`).then((response) => {
                    console.log(response.data)
                    if (response.status == 200) {
                        this.notificacoesData = response.data.notifications;
                    }
                })
                .catch((error) => {
                    console.log("Erro API")
                });
        },
        deletarNotificacoes() {

            const notifications = document.querySelectorAll(".message-list .selected");
            Array.from(notifications).forEach(function (notification) {
                const notificationId = notification.getAttribute("id");

                axios.get(`/empresa/notifications/deletar/${notificationId}`).then((response) => {
                    if (response.status == 200) {
                        result = true;
                    }
                })
            })
            Swal.fire({
                title: 'Sucesso',
                text: `Operação realizada com sucesso`,
                icon: 'success',
                confirmButtonColor: '#3d5476',
                confirmButtonText: 'Ok',
                onClose: () => {
                    document.location.reload(true)
                }
            });
        }
    }

}
</script>

<style>

</style>
