
import axios from 'axios'
import {baseUrl } from '../../config/global'
export default {
    state: {
        clientes: []
    },
    mutations: {

        SET_CLIENTES(state, clientes) {
            state.clientes = clientes
        }
    },
    actions: {

        LISTAR_CLIENTES({ commit }) {

            axios
                .get(`${baseUrl}/empresa/listarClienteFacturacao`)
                .then(res => {
                    console.log(res.data)
                    commit('SET_CLIENTES', res.data)
                })
                .catch(error => {
                    console.log("Erro API");
                });

        },
        SET_CLIENTE_FACTURACAO({commit}, order){

            //CHAMA A MUTATION DA FACTURAÇÃO
            commit('SET_CLIENTE_FACTURACAO', order)
        }
    },
    getters: {
        clientes(state) {
            return state.clientes
        }
    }
}