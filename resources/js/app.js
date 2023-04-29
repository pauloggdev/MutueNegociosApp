/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';



//ADMIN
import DashboardAdminComponent from './components/admin/dashboard/Dashboard'
import ConfigurarAdminComponent from './components/admin/configuracao/EmpresaEditar'


import FuncoesAdminComponent from './components/admin/permissao/FuncoesAdminComponent'
import PermissoesAdminComponent from './components/admin/permissao/PermissoesAdminComponent'

import LicencaAdminComponent from './components/admin/licenca/LicencaIndex'
import ClienteAdminComponent from './components/admin/cliente/ClienteIndex'

import LicencaEmpresaComponent from './components/admin/licenca/LicencaEmpresaComponent'
//Bancos
import BancoAdminComponent from './components/admin/Banco/BancoAdminComponent'
import CoordernadaBancariaAdminComponent from './components/admin/CoordernadaBancaria/CoordernadaBancariaAdminComponent'

import UtilizadoresAdmin from './components/admin/utilizadores/UtilizadoresIndex'


import PedidoActivacaoLicencaIndex from './components/admin/licenca/PedidoActivacaoLicencaIndex'



//Notificações

import NotificacaoIndexComponent from './components/empresa/notificacao/NotificacaoIndexComponent'
import NotificacaoAdminIndexComponent from './components/admin/notificacao/NotificacaoAdminIndexComponent'



//DASHBOARD 
import DashboardComponent from './components/empresa/dashboard/Dashboard'

//CONFIGURAÇÕES
import ParametrosComponent from './components/empresa/configuracoes/ParametrosComponent'

import ModeloDocumentoComponent from './components/empresa/configuracoes/ModeloDocumentoComponent'

//GESTORES
import GestoresComponent from './components/empresa/gestores/Gestores'


//BANCOS
import BancosComponent from './components/empresa/bancos/Bancos'

//ARMAZÉNS
import ArmazensComponent from './components/empresa/armazens/Armazens'

//Taxa empresa

import TaxasEmpresaComponent from './components/empresa/taxaiva/Taxas'

//TAXAS
import TaxasComponent from './components/admin/taxaiva/Taxas'

//MOTIVOS empresa
import MotivosEmpresaComponent from './components/empresa/motivoiva/Motivos'

//Motivos
import MotivosComponent from './components/admin/motivoiva/Motivos'

//SAFT
import GerarSaftComponent from './components/admin/gerarSaft/GerarSaft'


//Categorias
import CategoriasComponent from './components/empresa/categorias/Categorias'

//Marcas
import MarcasComponent from './components/empresa/marcas/Marcas'

//Unidades de Medida 
import UnidadesComponent from './components/empresa/unidades/Unidades'

//Classes de Bem
import ClassesComponent from './components/empresa/classes/Classes'

//ASSINATURAS
import AssinaturaComponent from './components/empresa/assinaturas/Assinatura'

//CLIENTES
import ClientesComponent from './components/empresa/clientes/Clientes'


import FornecedoresComponent from './components/empresa/fornecedores/Fornecedores'
import PagamentoFornecedorComponent from './components/empresa/fornecedores/PagamentoFornecedorComponent'
import InventariosComponent from './components/empresa/inventarios/Inventarios'

//FORMA DE PAGAMENTO
import FormaPagamentoComponent from './components/empresa/formapagamento/FormaPagamento'


//PRODUTOS
import ProdutoCreateComponent from './components/empresa/produtos/ProdutoCreateComponent'
import ProdutoEditarComponent from './components/empresa/produtos/ProdutoEditarComponent'
import ProdutoIndexComponent from './components/empresa/produtos/ProdutoIndexComponent'

//LISTA PRODUTOS EM ESTOQUE
import ProdutoStockIndexComponent from './components/empresa/produtos/ProdutoStockIndexComponent'

import ProdutoMaisVendidosComponent from './components/empresa/produtos/ProdutoMaisVendidosComponent'


//FACTURAÇÃO
import FacturacaoIndexComponent from './components/empresa/facturacoes/FacturacaoIndexComponent'
import FacturacaoCreateComponent from './components/empresa/facturacoes/FacturacaoCreateComponent'
//import AppComponent from './components/App'

//Listar facturas
import FacturaIndexComponent from './components/empresa/facturacoes/FacturaIndexComponent'
import FacturaProformasIndex from './components/empresa/facturas/FacturaProformasIndex'


//Centro de custos
import CentroCustosIndexComponent from './components/empresa/centroCustos/CentroCustosIndexComponent'


//Fabricantes 
import FabricanteIndexComponent from './components/empresa/fabricantes/FabricanteIndexComponent'

//Operações 
import DepositoReciboIndexComponent from './components/empresa/operacao/DepositoReciboIndex'
import ReciboCreateComponent from './components/empresa/operacao/ReciboCreateComponent'
import RectificacaoCreateComponent from './components/empresa/operacao/RectificacaoCreateComponent'
import AnulacaoCreateComponent from './components/empresa/operacao/AnulacaoCreateComponent'

//transferencia produto
import transferenciaProdutoIndexComponent from './components/empresa/operacao/transferenciaProdutoIndexComponent'
import transferenciaProdutoNovoComponent from './components/empresa/operacao/transferenciaProdutoNovoComponent'


import ExistenciaStockIndexComponent from './components/empresa/operacao/ExistenciaStockIndex'

import NotaDebitoIndexComponent from './components/empresa/operacao/NotaDebitoIndex'
import NotaCreditoIndexComponent from './components/empresa/operacao/NotaCreditoIndex'
import RectificacaoFacturaIndexComponent from './components/empresa/operacao/RectificacaoFacturaIndex'
import AnulacaoFacturaIndexComponent from './components/empresa/operacao/AnulacaoFacturaIndex'


//Anulação recibos
import AnulacaoReciboCreateComponent from './components/empresa/operacao/AnulacaoReciboCreateComponent'



import EntradaEstoqueIndexComponent from './components/empresa/operacao/EntradaEstoqueIndexComponent'
import EntradaEstoqueNovoComponent from './components/empresa/operacao/EntradaEstoqueNovoComponent'
import ActualizarEstoqueNovoComponent from './components/empresa/operacao/ActualizarEstoqueNovoComponent'

//VENDAS
import vendasProdutosIndex from './components/empresa/vendas/vendasProdutosIndex'
import vendasDiariaIndex from './components/empresa/vendas/vendasDiariaIndex'
import relatorioVendas from './components/empresa/vendas/relatorioVendas'
import vendasMensalIndex from './components/empresa/vendas/vendasMensalIndex'

import MovimentoDiarioIndex from './components/empresa/vendas/MovimentoDiarioIndex'

// =======================================================================================================

//LICENCAS
import MinhaLicencaComponent from './components/empresa/licencas/MinhaLicencaComponent'

//LISTAGEM 
import FacturaLicencaIndexComponent from './components/empresa/facturas/FacturaLicencaIndexComponent'
import ReciboLicencaIndexComponent from './components/empresa/facturas/ReciboLicencaIndexComponent'


//FECHO CAIXA
import FechoCaixaComponent from './components/empresa/fechoCaixa/FechoCaixaIndexComponent'

import FuncoesComponent from './components/empresa/permissao/FuncoesComponent'
import PermissoesComponent from './components/empresa/permissao/PermissoesComponent'




import UtilizadorComponent from './components/empresa/utilizadores/UtilizadorComponent'


import PdvComponent from './components/empresa/pdvs/PdvComponent'



// //Fabricantes 

// //Operações 

import 'font-awesome/css/font-awesome.css'
import './../../public/assets/js/select_dinamico'
import './config/msg'

//import './config/global'
import store from './store/store'

import VModal from 'vue-js-modal'

import moment from 'moment'

import VueLoading from 'vuejs-loading-plugin'
import Loading from './components/Loading'

// using default options
Vue.use(VueLoading)


// overwrite defaults
Vue.use(VueLoading, {
    dark: true, // default false
    text: 'Ladataan', // default 'Loading'
    loading: true, // default false
    customLoader: Loading, // replaces the spinner and text with your own
    background: 'rgb(255,255,255)', // set custom background
    classes: ['myclass'] // array, object or string
})




Vue.use(VModal)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};

Vue.use(VueSweetalert2, options);

Vue.filter('currency', value => {
    return value.toLocaleString('de-DE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 3
    })
})
Vue.filter('formatQt', value => {
    return value.toLocaleString('de-DE', {
        minimumFractionDigits: 1,
        maximumFractionDigits: 1
    })
})

Vue.filter('formatDate', value => {

    if (value) {
        return moment(String(value)).format('DD-MM-YYYY')
    }

})
Vue.filter('formatDateTime', value => {

    if (value) {
        return moment(String(value)).format('DD-MM-YYYY H:m')
    }

})
Vue.filter('formatDateTime2', value => {

    if (value) {
        return moment(String(value)).format('DD-MM-YYYY H:m:s')
    }

})

var myMixin = {

    computed: {
        window() {
            return window.Laravel;
        },
        isAdmin() {

            const roles = window.Laravel.roles;
            return roles.find(role => {
                return role.name == "Super-Admin"
            });
        }
    }
}
 
new Vue({
    store,
    el: '#app',
   // mixins: [myMixin],
    components: {

        //admin
        DashboardAdminComponent,
        ConfigurarAdminComponent,
        LicencaAdminComponent,
        LicencaEmpresaComponent,
        FuncoesAdminComponent,
        PermissoesAdminComponent,
        BancoAdminComponent,
        CoordernadaBancariaAdminComponent,
        ClienteAdminComponent,
        PedidoActivacaoLicencaIndex,
        UtilizadoresAdmin,
        NotificacaoAdminIndexComponent,

        //fim

        UtilizadorComponent,
        ParametrosComponent,
        ModeloDocumentoComponent,
        NotificacaoIndexComponent,
        DashboardComponent,
        GestoresComponent,
        BancosComponent,
        ArmazensComponent,
        TaxasEmpresaComponent,
        TaxasComponent,
        MotivosEmpresaComponent,
        MotivosComponent,
        GerarSaftComponent,
        AssinaturaComponent,
        ProdutoCreateComponent,
        ProdutoEditarComponent,
        ProdutoIndexComponent,
        FacturacaoIndexComponent,
        FacturacaoCreateComponent,
        FabricanteIndexComponent,
        CategoriasComponent,
        MarcasComponent,
        UnidadesComponent,
        ClassesComponent,
        vendasProdutosIndex,
        vendasDiariaIndex,
        relatorioVendas,
        vendasMensalIndex,
        MovimentoDiarioIndex,

        //Lista estoque produto
        ProdutoStockIndexComponent,

        //lista produtos mais vendidos
        ProdutoMaisVendidosComponent,

        //Listar facturas
        FacturaIndexComponent,
        FacturaProformasIndex,

        //Centro de custos
        CentroCustosIndexComponent,
        //Operações
        DepositoReciboIndexComponent,
        ReciboCreateComponent,
        RectificacaoCreateComponent,
        AnulacaoCreateComponent,
        ExistenciaStockIndexComponent,
        AnulacaoReciboCreateComponent,
        NotaDebitoIndexComponent,
        NotaCreditoIndexComponent,
        RectificacaoFacturaIndexComponent,
        AnulacaoFacturaIndexComponent,
        EntradaEstoqueIndexComponent,
        EntradaEstoqueNovoComponent,
        ActualizarEstoqueNovoComponent,
        //transferencia produto
        transferenciaProdutoIndexComponent,
        transferenciaProdutoNovoComponent,

        FechoCaixaComponent,
        FuncoesComponent,
        PermissoesComponent,
        ClientesComponent,
        FormaPagamentoComponent,
        FornecedoresComponent,
        PagamentoFornecedorComponent,
        InventariosComponent,

        //licencas
        MinhaLicencaComponent,

        //LISTAGENS
        FacturaLicencaIndexComponent,
        ReciboLicencaIndexComponent,
        PdvComponent 


    }
    // components: { exampleComponent,ProdutoCreateComponent, UsuariosComponent, BancosComponent, FacturacaoComponent },
});

Vue.component('notificacao-component', require('./components/empresa/notificacao/notificacao.vue').default);
Vue.component('notificacao-admin-component', require('./components/admin/notificacao/notificacao.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));

new Vue({

    el: '#app_notification',
});
