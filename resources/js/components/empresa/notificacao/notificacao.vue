<template>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav">
        <li class="purple dropdown-modal">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                <span class="badge badge-important">{{notificacoesData.length}}</span>
            </a>

            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">

                <li class="dropdown-header" v-for="notificacao in notificacoesData" :key="notificacao.id">
                    <a href="/empresa/listar-notificacoes">
                        <i class="ace-icon fa fa-exclamation-triangle"></i>
                        {{notificacao.data.mensagem}}...
                    </a>
                </li>
                <li class="dropdown-header">
                    <a href='/empresa/listar-notificacoes'>
                        <i class="ace-icon fa fa-exclamation-triangle"></i>
                        Todas notificações
                    </a>
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
            axios.get(`${this.router}/notifications`).then((response) => {
                    if (response.status == 200) {
                        this.notificacoesData = response.data.notifications;
                        console.log(this.notificacoesData);
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
