

export default {
    state: {
        produto:{}
    },
    mutations: {

        setProdutos(state, produto) {
            state.produto = produto
        }
    },
    actions: {
    },
    getters: {
        produto(state) {
            return state.produto
        }
    }
}