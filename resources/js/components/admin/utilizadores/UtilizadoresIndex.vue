<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Utilizadores
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          listagem
        </small>
      </h1>
    </div>
    <!-- /.page-header -->

    <div class="col-xs-12">
      <div class>
        <form class="form-search" method="get" action>
          <div class="row">
            <div class>
              <div
                class="input-group input-group-sm"
                style="margin-bottom: 10px"
              >
                <span class="input-group-addon">
                  <i class="ace-icon fa fa-search"></i>
                </span>

                <input
                  type="text"
                  required
                  autocompletete="on"
                  v-model="searchQuery"
                  class="form-control search-query"
                  placeholder="Buscar Por utilizadores por nome e email..."
                />
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-lg upload">
                    <span
                      class="ace-icon fa fa-search icon-on-right bigger-130"
                    ></span>
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
            <input type="hidden" name="_token" value />

            <div
              class="col-xs-12 widget-box widget-color-green"
              style="left: 0%"
            >
              <div class="clearfix">
                <a
                  href="#criar_utilizador"
                  data-toggle="modal"
                  title="Adicionar nova licenca"
                  class="btn btn-success widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-plus"></i> Novo Utilizador
                </a>
                <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                <a
                  data-toggle="modal"
                  @click.prevent="imprimirUtilizador"
                  title="Lista de bancos"
                  target="_blanck"
                  class="btn btn-primary widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-print text-default"></i> Imprimir
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
                Todas Utilizadores do Sistema
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th class="center">
                        <label class="pos-rel" for="permissao">
                          <input
                            type="checkbox"
                            id="marcarTodos"
                            class="ace input-lg"
                          />
                          <span class="lbl text-info"></span>
                        </label>
                      </th>
                      <td>Código</td>
                      <th>Nome de Utilizador</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="utilizador in queryUtilizador"
                      :key="utilizador.id"
                    >
                      <td class="center">
                        <label class="pos-rel">
                          <input type="checkbox" class="ace" />
                          <span class="lbl"></span>
                        </label>
                      </td>
                      <td>{{ utilizador.id }}</td>
                      <td>{{ utilizador.name }}</td>
                      <td>{{ utilizador.email }}</td>
                      <td>{{ utilizador.telefone }}</td>
                      <td>
                        <span
                          v-if="utilizador.statu_geral.id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ utilizador.statu_geral.designacao }}</span
                        >
                        <span
                          v-else
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ utilizador.statu_geral.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <a
                            href="#editar_utilizador"
                            data-toggle="modal"
                            class="pink"
                            @click.prevent="mostrarModalEditar(utilizador)"
                            title="Editar este registo"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-pencil
                                bigger-150
                                bolder
                                success
                                text-success
                              "
                            ></i>
                          </a>

                          <a
                            data-toggle="modal"
                            title="Eliminar este Registro"
                            @click.prevent="deletarUtilizador(utilizador)"
                            style="cursor: pointer"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-trash-o
                                bigger-150
                                bolder
                                danger
                                red
                              "
                            ></i>
                          </a>
                          <a
                            data-toggle="modal"
                            title="Eliminar este Registro"
                            @click.prevent="
                              visualizarFuncoesUtilizador(utilizador)
                            "
                            style="cursor: pointer"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-unlock
                                bigger-150
                                bolder
                                success
                                text-danger
                              "
                            ></i>
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

    <!-- CRIAR UTILIZADOR -->
    <div id="criar_utilizador" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Novo
              Utilizador
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="row">
                <div class="col-xs-12">
                  <!-- AVISO -->
                  <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                      <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com
                    <span
                      class="tooltip-target"
                      data-toggle="tooltip"
                      data-placement="top"
                      ><i class="fa fa-question-circle bold text-danger"></i
                    ></span>
                    são de preenchimento obrigatório.
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Dados do Utilizador
                  </div>
                  <div class="home-text">
                    <i class="fa fa-photo"></i>
                    Foto do Utilizador
                  </div>
                </div>

                <form
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal validation-form"
                  id
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#dados_cliente">
                            <i
                              class="
                                green
                                ace-icon
                                fa fa-pencil-square
                                bigger-125
                              "
                            ></i>
                            Dados do utlizaodr
                          </a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#foto_user">
                            <i class="red ace-icon fa fa-photo bigger-125"></i>
                            Foto do Utilizador
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div id="dados_cliente" class="tab-pane in active">
                          <div class="form-group has-info">
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Nome
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizador.name"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.name ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.name" class="error">{{
                                  errors.name[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Username
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizador.username"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.username" class="error">{{
                                  errors.username[0]
                                }}</span>
                              </div>
                            </div>

                            <!-- <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Tipo Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipoLicencaOptions" v-model="licenca.tipo_licenca_id" placeholder="Selecione o tipo de licença">
                                                                </Select2>
                                                                <span v-if="errors.tipo_licenca_id" class="error">{{errors.tipo_licenca_id[0]}}</span>

                                                            </div>
                                                        </div> -->
                          </div>
                          <div class="form-group has-info">
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Email
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizador.email"
                                  autocompletete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.email ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.email[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Telefone
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizador.telefone"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.telefone ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.telefone" class="error">{{
                                  errors.telefone[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <label
                                class="control-label"
                                for="telefone_empresa"
                                style="font-weight: 600; color: #333"
                                >Função Utilizador</label
                              >
                              <div
                                class=""
                                style="display: flex; flex-direction: column"
                              >
                                <div>
                                  <input
                                    type="checkbox"
                                    value="3"
                                    v-model="utilizador.roles"
                                    id="Funcionario"
                                  />
                                  <label class="control-label" for="Funcionario"
                                    >Funcionário</label
                                  >
                                </div>
                                <div>
                                  <input
                                    type="checkbox"
                                    value="2"
                                    v-model="utilizador.roles"
                                    id="Admin"
                                  />
                                  <label class="control-label" for="Admin"
                                    >Admin</label
                                  >
                                </div>
                                <div>
                                  <input
                                    type="checkbox"
                                    value="1"
                                    v-model="utilizador.roles"
                                    id="super_admin"
                                  />
                                  <label class="control-label" for="super_admin"
                                    >Super-admin</label
                                  >
                                </div>

                                <!-- <Select2 :options="tiposUtilizadores" v-model="utilizador.role" placeholder="Escolha o Status">
                                                            </Select2> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="foto_user" class="tab-pane">
                          <div
                            class="row"
                            style="left: 18%; position: relative"
                          >
                            <div class="form-group has-info has-info">
                              <br />
                              <div class="col-sm-8">
                                <div class="widget-box">
                                  <div class="widget-header">
                                    <h4 class="widget-title">
                                      Carregamento da Foto
                                    </h4>

                                    <div class="widget-toolbar">
                                      <a href="#" data-action="collapse">
                                        <i
                                          class="ace-icon fa fa-chevron-up"
                                        ></i>
                                      </a>

                                      <a href="#" data-action="close">
                                        <i class="ace-icon fa fa-times"></i>
                                      </a>
                                    </div>
                                  </div>

                                  <div class="widget-body">
                                    <div class="widget-main">
                                      <div class="form-group has-info">
                                        <div class="col-xs-12">
                                          <input
                                            name="foto"
                                            v-on:change="onFotoChange"
                                            type="file"
                                            accept="image/*"
                                            id="id-input-file-3"
                                            value=""
                                          />
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--/.row -->
                        </div>
                      </div>
                    </div>
                    <div class="clearfix form-actions">
                      <div class="col-md-offset-3 col-md-9">
                        <button
                          class="search-btn"
                          style="border-radius: 10px"
                          @click.prevent="cadastrarUtilizador"
                        >
                          <i class="ace-icon fa fa-check bigger-110"></i>
                          Salvar
                        </button>
                        &nbsp; &nbsp;
                        <button
                          class="btn btn-danger"
                          type="reset"
                          style="border-radius: 10px"
                        >
                          <i class="ace-icon fa fa-undo bigger-110"></i>
                          Cancelar
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- EDITAR UTILIZADOR  -->
    <div id="editar_utilizador" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar
              Utilizador
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="row">
                <div class="col-xs-12">
                  <!-- AVISO -->
                  <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                      <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com
                    <span
                      class="tooltip-target"
                      data-toggle="tooltip"
                      data-placement="top"
                      ><i class="fa fa-question-circle bold text-danger"></i
                    ></span>
                    são de preenchimento obrigatório.
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Dados do Utilizador
                  </div>
                  <div class="home-text">
                    <i class="fa fa-photo"></i>
                    Foto do Utilizador
                  </div>
                </div>

                <form
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal validation-form"
                  id
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#editar_utilizador1">
                            <i
                              class="
                                green
                                ace-icon
                                fa fa-pencil-square
                                bigger-125
                              "
                            ></i>
                            Dados do utlizaodr
                          </a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#editar_utilizador2">
                            <i class="red ace-icon fa fa-photo bigger-125"></i>
                            Foto do Utilizador
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div id="editar_utilizador1" class="tab-pane in active">
                          <div class="form-group has-info">
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Nome
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizadorEdita.name"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.name ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.name" class="error">{{
                                  errors.name[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Username
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizadorEdita.username"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.username" class="error">{{
                                  errors.username[0]
                                }}</span>
                              </div>
                            </div>

                            <!-- <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Tipo Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipoLicencaOptions" v-model="licenca.tipo_licenca_id" placeholder="Selecione o tipo de licença">
                                                                </Select2>
                                                                <span v-if="errors.tipo_licenca_id" class="error">{{errors.tipo_licenca_id[0]}}</span>

                                                            </div>
                                                        </div> -->
                          </div>
                          <div class="form-group has-info">
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Email
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizadorEdita.email"
                                  autocompletete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.email ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.email[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="designacao">
                                Telefone
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="utilizadorEdita.telefone"
                                  autocomplete="off"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.telefone ? 'has-error' : ''"
                                  placeholder="Informe o nome"
                                />
                                <span v-if="errors.telefone" class="error">{{
                                  errors.telefone[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <label
                                class="control-label"
                                for="telefone_empresa"
                                style="font-weight: 600; color: #333"
                                >Tipo Utilizador</label
                              >
                              <div
                                class=""
                                style="display: flex; flex-direction: column"
                              >
                                <div>
                                  <input
                                    type="checkbox"
                                    value="3"
                                    v-model="utilizadorEdita.roles"
                                    id="FuncEdit"
                                  />
                                  <label class="control-label" for="FuncEdit"
                                    >Funcionário</label
                                  >
                                </div>
                                <div>
                                  <input
                                    type="checkbox"
                                    value="2"
                                    v-model="utilizadorEdita.roles"
                                    id="AdminEdit"
                                  />
                                  <label class="control-label" for="AdminEdit"
                                    >Admin</label
                                  >
                                </div>
                                <div>
                                  <input
                                    type="checkbox"
                                    value="1"
                                    v-model="utilizadorEdita.roles"
                                    id="superAdminEdit"
                                  />
                                  <label
                                    class="control-label"
                                    for="superAdminEdit"
                                    >Super-admin</label
                                  >
                                </div>

                                <!-- <Select2 :options="tiposUtilizadores" v-model="utilizador.role" placeholder="Escolha o Status">
                                                            </Select2> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="editar_utilizador2" class="tab-pane">
                          <div
                            class="row"
                            style="left: 18%; position: relative"
                          >
                            <div class="form-group has-info has-info">
                              <br />
                              <div class="col-sm-8">
                                <div class="widget-box">
                                  <div class="widget-header">
                                    <h4 class="widget-title">
                                      Carregamento da Foto
                                    </h4>

                                    <div class="widget-toolbar">
                                      <a href="#" data-action="collapse">
                                        <i
                                          class="ace-icon fa fa-chevron-up"
                                        ></i>
                                      </a>

                                      <a href="#" data-action="close">
                                        <i class="ace-icon fa fa-times"></i>
                                      </a>
                                    </div>
                                  </div>

                                  <div class="widget-body">
                                    <div class="widget-main">
                                      <div class="form-group has-info">
                                        <div class="col-xs-12">
                                          <input
                                            name="foto"
                                            v-on:change="onFotoChange"
                                            type="file"
                                            accept="image/*"
                                            id="id-input-file-3"
                                            value=""
                                          />
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--/.row -->
                        </div>
                      </div>
                    </div>
                    <div class="clearfix form-actions">
                      <div class="col-md-offset-3 col-md-9">
                        <button
                          class="search-btn"
                          style="border-radius: 10px"
                          @click.prevent="editarUtilizador"
                        >
                          <i class="ace-icon fa fa-check bigger-110"></i>
                          Salvar
                        </button>
                        &nbsp; &nbsp;
                        <button
                          class="btn btn-danger"
                          type="reset"
                          style="border-radius: 10px"
                        >
                          <i class="ace-icon fa fa-undo bigger-110"></i>
                          Cancelar
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  </div>
</template>

<script>
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import Swal from "sweetalert2";
import VueNumericInput from "vue-numeric-input";
export default {
  props: ["users"],
  components: {
    Select2,
    DatePick,
    VueNumericInput,
  },
  data() {
    return {
      searchQuery: "",
      utilizador: {
        roles: [3], //default funcionario
      },
      errors: [],
      foto: "",
      router: "",
      tiposUtilizadores: [
        {
          id: 1,
          text: "Super-Admin",
        },
        {
          id: 2,
          text: "Admin",
        },
        {
          id: 3,
          text: "Funcionario",
        },
      ],
      utilizadorEdita: {
        roles: [3],
      },
    };
  },
  created() {
    this.router = window.location.origin + `/admin`;
  },
  computed: {
    queryUtilizador() {
      if (this.searchQuery) {
        let searchQuery = this.searchQuery.toLowerCase();
        let result = this.users.filter((item) => {
          return (
            item.name.toLowerCase().match(searchQuery) ||
            item.email.toLowerCase().match(searchQuery)
          );
        });
        return result ? result : [];
      } else {
        return this.users;
      }
    },
  },
  methods: {
    visualizarFuncoesUtilizador(utilizador) {},

    deletarUtilizador(utilizador) {
      Swal.fire({
        title: "Deseja remover o item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`/admin/usuarios/delete/${utilizador.id}`)
            .then((response) => {
              if (response.status == 200) {
                this.$toasted.global.defaultSuccess();
                Swal.fire({
                  title: "Sucesso",
                  text: "Utilizador removido com sucesso!",
                  icon: "success",
                  confirmButtonColor: "#3d5476",
                  confirmButtonText: "Ok",
                  onClose: () => {
                    document.location.reload(true);
                  },
                });
              }
            })
            .catch((error) => {
              if (error.response.data.isValid == false) {
                this.$toasted.global.defaultError({
                  msg: error.response.data.errors,
                });
              } else {
                this.$toasted.global.defaultError({
                  msg: "Sem Permissão para eliminar o utilizador",
                });
              }
            });
        }
      });
    },
    onFotoChange(e) {
      this.foto = e.target.files[0];
    },
    mostrarModalEditar(utilizador) {
      this.utilizadorEdita = {};
      this.errors = [];
      this.utilizadorEdita = Object.assign({}, utilizador);

      utilizador.roles.forEach((role) => {
        if (role.id == 1) {
          this.utilizadorEdita.roles[2] = role.id;
        }
        if (role.id == 2) {
          this.utilizadorEdita.roles[1] = role.id;
        }
        if (role.id == 3) {
          this.utilizadorEdita.roles[0] = role.id;
        }
      });
    },
    async editarUtilizador() {
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      const portal_admin = 3;
      let formData = new FormData();
      let usuario = {
        canal_id: portal_admin,
        ...this.utilizadorEdita,
      };
      let utilizador = JSON.stringify(usuario);
      formData.append("utilizador", utilizador);
      formData.append("foto", this.foto);
      try {
        let response = await axios.post(
          `/admin/utilizador/${usuario.id}/update`,
          formData,
          config
        );
        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            text: "Operação realizada com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
        }
      } catch (error) {
        this.$toasted.global.defaultError({
          msg: "Erro ao editar",
        });
        this.errors = error.response.data.errors;
      }
    },
    async cadastrarUtilizador() {
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      const portal_admin = 3;
      let formData = new FormData();
      let usuario = {
        canal_id: portal_admin,
        ...this.utilizador,
      };
      var utilizador = JSON.stringify(usuario);
      formData.append("utilizador", utilizador);
      formData.append("foto", this.foto);
      try {
        let response = await axios.post(
          `/admin/utilizador/adicionar`,
          formData,
          config
        );
        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            text: "Cliente cadastrado com sucesso!...",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
        }
      } catch (error) {
        this.$toasted.global.defaultError({
          msg: "Erro ao Cadastrar",
        });
        this.errors = error.response.data.errors;
      }
    },
    async imprimirUtilizador() {
      this.$loading(true);
      try {
        let response = await axios
          .get(`${this.router}/imprimirUtilizador`, {
            responseType: "arraybuffer",
          })
          .then((response) => {
            if (response.status === 200) {
              this.$loading(false);
              var file = new Blob([response.data], {
                type: "application/pdf",
              });
              var fileURL = URL.createObjectURL(file);
              window.open(fileURL);
            } else {
              this.$loading(false);
              console.log("Erro ao carregar pdf");
            }
          });
      } catch (error) {
        this.$loading(false);
        console.log("Erro ao carregar pdf");
      }
    },
  },
};
</script>

<style>
</style>
