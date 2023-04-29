import Vue from 'vue'
import Vuex from 'vuex'
import notificacoes from './modulos/notificacoes'
// import clientes from './modulos/clientes'
// import facturacao from './modulos/facturacao'
// import clientes_funcionario from './modulos/clientes_funcionario'
// import facturacao_funcionario from './modulos/facturacao_funcionario'
// import produtos from './modulos/produtos'


Vue.use(Vuex)

export default new Vuex.Store({
    modules:{
        notificacoes,
        // facturacao,
        // clientes,
        // clientes_funcionario,
        // facturacao_funcionario,
        // produtos
    }

})