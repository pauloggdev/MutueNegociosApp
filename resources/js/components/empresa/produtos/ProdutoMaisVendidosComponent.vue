<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        PRODUTOS MAIS VENDIDOS
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          Listagem
        </small>
      </h1>
    </div>
    <div class="col-md-12">
         <div class>
            <form class="form-search" method="get" action>
                <div class="row">
                    <div class>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por nome de produto..." />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-lg upload">
                                    <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class>
            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token"/>
                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">
                        <div class="table-header widget-header">Todos estoques do Sistema</div>
                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>

                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th style="text-align:right">Preço Venda</th>
                                        <th style="text-align:right">Preço Compra</th>
                                        <th style="text-align:center">Qtd vendida</th>
                                        <th style="text-align:center">Stocavel</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="(produto, i) in queryprodutos" :key="i">
                                       <td style="text-transform:uppercase">{{produto.id}}</td>
                                       <td style="text-transform:uppercase">{{produto.designacao}}</td>
                                        <td style="text-align:right">{{produto.preco_venda | currency}}</td>
                                        <td style="text-align:right">{{(produto.preco_compra?produto.preco_compra:0) | currency}}</td>
                                        <td class="hidden-480" style="text-align:center">{{ (produto.qtVendidos) | formatQt }}</td>
                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm label-success" v-if="produto.stocavel =='Sim'">{{produto.stocavel}}</span>
                                            <span class="label label-sm label-warning" v-else>{{produto.stocavel}}</span>
                                        </td>
                                       

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col-xs-12 -->
                </form>
            </div>
        </div>
    </div>

    <!-- /MODAL LISTAR produtos -->
  </div>
  <!-- /.row -->
</template>
<script>
export default {
  components: {},
  props: ["guard", "produtomaisvendido"],

  data() {
    return {
      searchQuery: null,
      USUARIO_EMPRESA: 2,
      router: "",
    };
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;

        console.log(this.produtomaisvendido);
  },
  computed: {
    window() {
      return window.Laravel;
    },
    queryprodutos() {
      if (this.searchQuery) {
        let result = this.produtomaisvendido.filter((item) => {
          return (
            item.armazens.designacao
              .toLowerCase()
              .match(this.searchQuery.toLowerCase()) ||
            item.produtos.designacao
              .toLowerCase()
              .match(this.searchQuery.toLowerCase())
          );
        });

        return result ? result : [];
      } else {
        return this.produtomaisvendido;
      }
    },
  },

  methods: {},
};
</script>

<style scoped>
#filter {
  margin-bottom: 15px;
}

.box-content {
  background: rgb(236, 241, 247);
  padding: 20px;
  height: 100%;
}

#botoes {
  left: 0%;
  border-radius: 15px;
  margin-top: 0.1%;
  padding: 6px 12px 6px 12px;
  position: relative;
  text-transform: uppercase;
}

.is-invalid,
.invalid-feedback {
  border-color: red;
  color: red;
}
</style>
