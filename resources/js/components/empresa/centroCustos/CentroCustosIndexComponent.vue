<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        CENTRO DE CUSTOS
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          Listagem
        </small>
      </h1>
    </div>
    <!-- /.page-header -->

    <div class="col-xs-12">
      <div class>
        <div class="row">
          <form id="adimitirCandidatos" method="POST" action>
            <input type="hidden" name="_token" value />

            <div
              class="col-xs-12 widget-box widget-color-green"
              style="left: 0%"
            >
              <div class="clearfix">
               <a href="/empresa/centro/custos/novo" title="adicionar centro de custos" class="btn btn-success widget-box widget-color-blue" id="botoes">
                <i class="fa fa-plus"></i> Centro de custos
            </a>
            <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                <i class="fa fa-plus"></i> Imprimir
            </a>

                <div class="dt-buttons btn-overlap btn-group pull-right">
                  <a
                    class="
                      dt-button
                      buttons-collection buttons-colvis
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i class="fa fa-search bigger-110 text-primary"></i>
                      <span class="hidden">Mostrar/Ocultar Colunas</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-copy buttons-html5
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i class="fa fa-copy bigger-110 text-pink"></i>
                      <span class="hidden">Copiar para uma tabela</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-csv buttons-html5
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i
                        class="fa fa-database bigger-110 text-orange"
                        style="color: orange"
                      ></i>
                      <span class="hidden">Exportar para CSV</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-print
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                    href="#modalFiltrarClientes"
                    data-toggle="modal"
                  >
                    <span
                      ><i class="fa fa-print bigger-110 text-default"></i>
                      <span class="hidden">Imprimir toda Tabela</span>
                    </span>
                  </a>
                </div>
                <!-- <div class="pull-right tableTools-container"></div> -->
              </div>

              <div class="table-header widget-header">
                Todos centro de custo
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>NIF</th>
                      <th>Telefone</th>
                      <th>Endereço</th>
                      <th style="text-align: center">Status</th>
                      <th>Opções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="(centrocusto, i) in centrocustos" :key="i">
                      <td>{{ centrocusto.nome.toUpperCase() }}</td>
                      <td>{{ centrocusto.email }}</td>
                      <td>{{ centrocusto.nif }}</td>
                      <td>{{ centrocusto.telefone }}</td>
                      <td>{{ centrocusto.endereco }}</td>
                      <td style="text-align: center">
                        <span
                          v-if="centrocusto.status_id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ centrocusto.statu.designacao }}</span
                        >

                        <span
                          v-else
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ centrocusto.statu.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                            <a :href="'/empresa/centro/custo/editar/'+centrocusto.uuid" class="pink" title="Editar centro de custo">
                                <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                            </a>
                        </div>
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
  </div>
</template>

<script>
export default {
  props: ["centrocustos"],

  data() {
    return {};
  },
};
</script>

<style>
.has-error {
  border-color: #f2a696 !important;
}

.vdpComponent.vdpWithInput > input {
  padding: 6px !important;
  width: 231px !important;
}
</style>
