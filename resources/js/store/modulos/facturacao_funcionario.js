import axios from 'axios'
import { baseUrl } from '../../config/global'




async function existenciaStockProduto(produto) {
    if (produto.stocavel == "Sim") {

        let response = await axios.get(`${baseUrl}/empresa/produtoQtdExistenciaStock/${produto.id}/${produto.quant}`)

        console.log(response)
        return response;
    }
}
export default {

    state: {
        stock: false,
        facturacao: {

            is_retencao: false,

            produtos: [],
            cliente: {},

            incidencia: 0,
            total_iva: 0,
            total_preco_factura: 0,
            desconto: 0,
            desconto_produto: 0,
            formas_pagamento_id: 1,
            tipo_documento: 1,
            tipoFolha: 1,
            troco: "",


            valor_entregue: null,
            valor_a_pagar: 0,
            codigo_moeda: 1,

            multa: 0,
            numeroItems: 0,
            observacao: "",
            retificado: "NÃO",
            retencao: 0,
            descricao: null,
            armazen_id: null,
            categoria_id: null
        },
        produtos: [],//listar produtos
    },
    mutations: {

        setFacturacao(state, order) {

            const prod = state.facturacao.produtos.find(element => element.id == order.id)

            let retencao = state.facturacao.is_retencao ? 0.065 : 0.0


            //Verifica se produto encontra no carrinho
            if (prod != undefined) {

                //  let result = existenciaStockProduto(prod);




                prod.quant += order.quant
                //aplica desconto cada haver
                let desconto_produto = (order.preco * prod.quant) * state.facturacao.desconto_produto / 100

                //calculo da incidencia de cada produto
                let incidencia = (order.preco * prod.quant) - desconto_produto;

                //calcula iva produto
                let iva_produto = (order.iva_produto / 100) * incidencia


                //calculo retencao de cada produto
                let retencao_produto = (order.preco * prod.quant) * retencao


                //aplica desconto cada haver
                prod.desconto_produto = desconto_produto
                prod.preco = order.preco
                prod.preco_compra = order.preco_compra
                prod.total = prod.quant * order.preco

                prod.designacao = order.designacao
                prod.retencao_produto = retencao_produto
                prod.incidencia_produto = incidencia
                prod.unidade = order.unidade
                prod.iva_produto = (order.iva_produto / 100) * incidencia
                prod.total_preco_produto = (order.preco * prod.quant)
                prod.valor_com_iva = (incidencia + iva_produto) - retencao_produto

            } else {

                //this.commit("existenciaStockProduto", order);



                //aplica desconto cada haver
                let desconto_produto = (order.preco * order.quant) * state.facturacao.desconto_produto / 100

                //calculo da incidencia de cada produto
                let incidencia = (order.preco * order.quant) - desconto_produto;


                //calcula iva produto
                let iva_produto = (order.iva_produto / 100) * incidencia


                //calculo retencao de cada produto
                let retencao_produto = (order.preco * order.quant) * retencao



                state.facturacao.produtos.push({
                    id: order.id,
                    quant: order.quant,
                    stocavel: order.stocavel,
                    desconto_produto: desconto_produto,
                    preco: order.preco,
                    preco_compra: order.preco_compra,
                    total: order.quant * order.preco,
                    designacao: order.designacao,
                    retencao_produto: retencao_produto,
                    incidencia_produto: incidencia,
                    unidade: order.unidade,
                    iva_produto: (order.iva_produto / 100) * incidencia,
                    taxa: order.taxa,
                    total_preco_produto: (order.preco * order.quant),
                    valor_com_iva: (incidencia + iva_produto) - retencao_produto,
                })
            }

            this.commit("SET_VALORES_TOTAL_FACTURACAO");

        },

        existenciaStockProduto(state, item) {


            return true
            // if(item.stocavel == "Sim"){

            //      axios.get(`${baseUrl}/empresa/facturacao/produtoQtdExistenciaStock/${item.id}`).then(res=>{

            //         if(item.quant > res.data[0].quantidade ){

            //             alert('Quantidade não existente no stock')

            //             return false
            //         }

            //     }).catch(error=>{
            //         console.log(error)
            //     })

            // }


        },
        SET_EDIT_FACTURACAO(state, order) {

            const prod = state.facturacao.produtos.find(element => element.id == order.id)

            let retencao = order.retencao_produto ? 0.065 : 0.0


            //Verifica se produto encontra no carrinho
            if (prod != undefined) {

                prod.quant = order.quantidade_produto;
                //aplica desconto cada haver
                let desconto_produto = (prod.preco * prod.quant) * order.desconto_produto / 100

                //calculo da incidencia de cada produto
                let incidencia = (prod.preco * prod.quant) - desconto_produto;

                //calculo retencao de cada produto
                let retencao_produto = (prod.preco * prod.quant) * retencao


                //aplica desconto cada haver
                prod.desconto_produto = desconto_produto
                prod.total = prod.quant * prod.preco

                prod.retencao_produto = retencao_produto
                prod.incidencia_produto = incidencia
                prod.iva_produto = prod.iva_produto
                prod.total_preco_produto = (prod.preco * prod.quant)
                prod.valor_com_iva = (incidencia + prod.iva_produto) - retencao_produto

            }

            this.commit("SET_VALORES_TOTAL_FACTURACAO");


        },
        ADD_RETENCAO_TODO_ITEM(state, value) {

            let retencao = value ? 0.065 : 0.00
            state.facturacao.is_retencao = !state.facturacao.is_retencao

            state.facturacao.produtos.map((item, index) => {

                //calculo da incidencia de cada produto
                let incidencia = item.incidencia_produto;

                //calcula iva produto
                let iva_produto = item.iva_produto

                //calculo retencao de cada produto
                let retencao_produto = (item.preco * item.quant) * retencao


                state.facturacao.produtos[index].retencao_produto = retencao_produto
                state.facturacao.produtos[index].valor_com_iva = (incidencia + iva_produto) - retencao_produto


            })

            this.commit("SET_VALORES_TOTAL_FACTURACAO");


        },
        ADD_DESCONTO_TODO_ITEM(state, value) {


            state.facturacao.desconto = value ? value : 0
            state.facturacao.desconto_produto = value ? value : 0


            let retencao = state.facturacao.is_retencao ? 0.065 : 0.0

            state.facturacao.produtos.map((item, index) => {


                //aplica desconto cada haver
                let desconto_produto = (item.preco * item.quant) * state.facturacao.desconto / 100
                //calculo da incidencia de cada produto
                let incidencia = (item.preco * item.quant) - desconto_produto;
                //calcula iva produto
                let iva_produto = (item.taxa / 100) * incidencia
                //calculo retencao de cada produto
                let retencao_produto = (item.preco * item.quant) * retencao


                state.facturacao.produtos[index].desconto_produto = desconto_produto
                state.facturacao.produtos[index].retencao_produto = retencao_produto
                state.facturacao.produtos[index].iva_produto = iva_produto
                state.facturacao.produtos[index].valor_com_iva = (incidencia + iva_produto) - retencao_produto
                state.facturacao.produtos[index].incidencia_produto = incidencia


            })

            this.commit("SET_VALORES_TOTAL_FACTURACAO");

        },
        SET_VALOR_ENTREGUE(state, value) {

            state.facturacao.valor_entregue = value


            if (value) {
                if (state.facturacao.valor_a_pagar) {
                    state.facturacao.troco = (value - state.facturacao.valor_a_pagar)
                }
            } else {
                state.facturacao.troco = 0
            }

        },
        SET_TIPO_FACTURA(state, value) {

            switch (value) {
                case 1:
                    state.facturacao.tipo_documento = "FACTURA RECIBO";
                    break;
                case 2:
                    state.facturacao.tipo_documento = "FACTURA";
                    break;

                case 3:
                    state.facturacao.tipo_documento = "FACTURA PROFORMA";
                    break;

            }
        },
        SET_TIPO_FOLHA(state, value) {
            state.facturacao.tipoFolha = value;
        },
        removeFacturacaoList(state, item) {


            state.facturacao.produtos.forEach((data, index) => {
                if (data.id == item) {

                    state.facturacao.desconto -= state.facturacao.produtos[index].desconto_produto
                    state.facturacao.numeroItems -= state.facturacao.produtos[index].quant
                    state.facturacao.retencao -= state.facturacao.produtos[index].retencao_produto
                    state.facturacao.incidencia -= state.facturacao.produtos[index].incidencia_produto
                    state.facturacao.total_iva -= state.facturacao.produtos[index].iva_produto
                    state.facturacao.total_preco_factura -= state.facturacao.produtos[index].total_preco_produto
                    state.facturacao.produtos.splice(index, 1); //remove um item no array pelo index
                }
            });

            this.commit("SET_VALORES_TOTAL_FACTURACAO");

        },
        SET_VALORES_TOTAL_FACTURACAO(state) {

            //state.facturacao.total += order.preco * order.quant
            state.facturacao.total_preco_factura = 0;
            state.facturacao.valor_a_pagar = 0;
            state.facturacao.desconto = 0
            state.facturacao.numeroItems = 0;
            state.facturacao.retencao = 0;
            state.facturacao.incidencia = 0;
            state.facturacao.total_iva = 0;


            state.facturacao.produtos.map((item, index) => {

                //state.facturacao.total_preco_factura = state.facturacao.total_preco_factura + item.incidencia_produto;
                state.facturacao.desconto += state.facturacao.produtos[index].desconto_produto
                state.facturacao.numeroItems += state.facturacao.produtos[index].quant
                state.facturacao.retencao += state.facturacao.produtos[index].retencao_produto
                state.facturacao.incidencia += state.facturacao.produtos[index].incidencia_produto
                state.facturacao.total_iva += state.facturacao.produtos[index].iva_produto
                state.facturacao.total_preco_factura += state.facturacao.produtos[index].total_preco_produto
            })


            state.facturacao.valor_a_pagar = (state.facturacao.total_preco_factura + state.facturacao.total_iva) - (state.facturacao.desconto + state.facturacao.retencao)


            //valor troco
            if (state.facturacao.valor_entregue) {
                if (state.facturacao.valor_a_pagar) {
                    state.facturacao.troco = (state.facturacao.valor_entregue - state.facturacao.valor_a_pagar)
                }
            } else {
                state.facturacao.troco = 0
            }



            //Formatação do valor extenso
            var extenso = require('extenso');
            let valor_pagar_toFixed = state.facturacao.valor_a_pagar.toFixed(2);
            let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

            state.facturacao.valor_extenso = extenso(valor_a_pagar, { number: { decimal: 'informal' } })



        },
        setProdutos(state, produtos) {
            state.produtos = produtos;
        },
        set_armazem(state, id) {
            state.facturacao.armazen_id = id;
        },
        set_categoria(state, id) {
            state.facturacao.categoria_id = id;
        },

        SET_CLIENTE_FACTURACAO(state, cliente) {
            state.facturacao.cliente = cliente
        },
        CLEAR_FACTURACAO_ITEM(state, order) {
            state.facturacao.produtos = order
        }
    },
    actions: {

        SET_EDIT_FACTURACAO({
            commit
        }, order) {
            commit('SET_EDIT_FACTURACAO', order)
        },
        addFacturacao({ commit }, order) {

            commit('setFacturacao', order)
        },
        removeFacturacaoList({
            commit
        }, item) {
            commit('removeFacturacaoList', item)
        },
        loadProdutos({ commit }, armazen_id) {

            axios
                .get(`${baseUrl}/empresa/facturacao/produtos/${armazen_id}`)
                .then(res => {

                    console.log(res.data)
                    commit('setProdutos', res.data.produtos)
                })
                .catch(error => {
                    console.log("Erro API");
                });
        }
    },
    getters: {
        produtos(state) {
            return state.produtos
        },
        facturacao(state) {
            return state.facturacao
        },
        total(state) {
            return state.facturacao.total_preco_factura
        },
        CLIENTE_FACTURACAO(state) {
            return state.facturacao.cliente
        },
        tipofactura(state) {
            return state.facturacao.tipofactura
        },
        is_retencao(state) {
            return state.facturacao.is_retencao
        },
        desconto_geral(state) {
            return state.facturacao.desconto_produto
        }

    },



}


