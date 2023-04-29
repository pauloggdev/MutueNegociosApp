<template>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav">
        <li class="purple dropdown-modal">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                <span class="badge badge-important">{{notificacoesData.length}}</span>
                <!-- <span class="badge badge-important">10</span> -->
            </a>

            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                <li class="dropdown-header" v-for="(notificacao, i) in notificacoesData" :key="i">
                    <a href="/admin/listar-notificacoes">
                        <i class="ace-icon fa fa-exclamation-triangle"></i>
                        {{JSON.parse(notificacao.data).mensagem}}...
                    </a>
                </li>
                <li class="dropdown-header">
                    <a href="/admin/listar-notificacoes">
                        <i class="ace-icon fa fa-exclamation-triangle"></i>
                        Todas notificações
                    </a>
                    <!-- <a href="">
                        <i class="ace-icon fa fa-exclamation-triangle"></i>
                        Todas notificações
                    </a> -->
                </li>
            </ul>
        </li>
    </ul>
</div>
</template>

<script>
export default {

    props: ["router"],
    data() {
        return {
            notificacoesData: [],

        }
    },
    mounted() {
        this.listarNotificacoes();
    },

    computed: {
        notificacoes() {
            return this.notificacoesData
        }
    },
    methods: {

        listarNotificacoes() {

            axios.get(`/admin/notifications`).then((response) => {
                    if (response.status == 200) {
                        this.notificacoesData = response.data.notifications;

                    }
                })
                .catch((error) => {
                    console.log("Erro API")
                });
        }
    }
}
</script>

<style>

</style>
