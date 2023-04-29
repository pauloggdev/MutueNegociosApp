export default {
    state: {
        items: []
    },
    mutations: {
        LISTAR_NOTIFICACOES(state, notificacao) {
            state.items = notificacao
        }
    },
    actions: {
        listarNotificacoes(context) {
            // axios.get(`/empresa/notifications`).then((response) =>
            //     context.commit('LISTAR_NOTIFICACOES', response.data.notifications)

            // );
        }
    },

}
