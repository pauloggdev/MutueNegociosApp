<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Utilizadores
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
              <div
                class="input-group input-group-sm"
                style="margin-bottom: 10px"
              >
                <span class="input-group-addon">
                  <i class="ace-icon fa fa-search"></i>
                </span>

                <input
                  type="text"
                  v-model="searchQuery"
                  required
                  autocomplete="on"
                  class="form-control search-query"
                  placeholder="Buscar Por nome,email..."
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
                <a v-if="window.user.can['gerir utilizadores'] || window.isSuperAdmin"
                  href="#criarUtilizador"
                  data-toggle="modal"
                  title="Adicionar novo banco"
                  class="btn btn-success widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-banco-plus"></i> Novo utilizador
                </a>
                <!-- <a href="/empresa/imprimir/bancos" data-toggle="modal" href="#modalClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                </a>-->
                <a
                  data-toggle="modal"
                  href="#modalFiltrarBancos"
                  title="Lista de bancos"
                  target="_blanck"
                  class="btn btn-primary widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-print text-default"></i> Imprimir
                </a>
                <div class="pull-right tableTools-container"></div>
              </div>

              <div class="table-header widget-header">
                Todos utilizadores do Sistema
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th class="center">Código</th>
                      <th>Nome de Utilizador</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th class="center">Status</th>
                      <th>Opções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="user in buscarUtilizadores" :key="user.id">
                      <td class="center">{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.telefone }}</td>
                      <td class="hidden-480" style="text-align: center">
                        <span
                          v-if="user.statu_geral.id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ user.statu_geral.designacao }}</span
                        >
                        <span
                          v-else
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ user.statu_geral.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons" v-if="window.user.can['gerir utilizadores'] || window.isSuperAdmin">
                          <a
                            href="#editarUtilizador"
                            data-toggle="modal"
                            @click.prevent="mostrarModalEditar(user)"
                            class="pink"
                            title="Editar este registo">
                            <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                          </a>

                          <a
                            href="#adicionarFuncaoPermissao"
                            data-toggle="modal"
                            title="Eliminar este Registro"
                            @click.prevent="modarAdicionarFuncoesPermissoes(user)"
                            style="cursor: pointer">
                            <i
                              class="ace-icon fa fa-unlock bigger-150 bolder success text-danger"
                            ></i>
                          </a>
                          <a
                            data-toggle="modal"
                            title="Eliminar este Registro"
                            @click.prevent="deletar(user)"
                            style="cursor: pointer"
                          >
                            <i
                              class="ace-icon fa fa-trash-o bigger-150 bolder danger red"
                            ></i>
                          </a>
                          <!-- <a data-toggle="modal" title="Configurações do utilizador" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-cogs bigger-150 bolder text-primary"></i>
                                                </a> -->
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
    <!-- MODAL DE CRIAR USERS -->
    <div id="criarUtilizador" class="modal fade criarUtilizador">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
              Adicionar Utilizador
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
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
                  method="POST"
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal"
                  id="validation-form"
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#dados_user">
                            <i
                              class="green ace-icon fa fa-pencil-square bigger-125"
                            ></i>
                            Dados do Utilizador
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
                        <div
                          id="dados_user"
                          class="tab-pane in active"
                          style="left: 12%; position: relative"
                        >
                          <div class="form-group has-info">
                            <div class="col-md-5">
                              <label class="control-label" for="nome"
                                >Nome<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="utilizador.name"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.name ? 'has-error' : ''"
                                  required
                                />
                                <span v-if="errors.name" class="error">{{
                                  errors.name[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <label class="control-label" for="username"
                                >Username<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="utilizador.username"
                                  id="username"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  required
                                />
                                <span v-if="errors.username" class="error">{{
                                  errors.username[0]
                                }}</span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group has-info">
                            <div class="col-md-5">
                              <label class="control-label" for="email_empresa"
                                >Email<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="email"
                                  v-model="utilizador.email"
                                  id="email"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  required=""
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.email[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <label
                                class="control-label"
                                for="telefone_empresa"
                                >Telefone<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="utilizador.telefone"
                                  id="phone"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  maxlength="9"
                                  :class="errors.telefone ? 'has-error' : ''"
                                  required=""
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.telefone[0]
                                }}</span>
                              </div>
                            </div>
                            
                          </div>
                        </div>

                        <div id="foto_user" class="tab-pane">
                          <div
                            class="row"
                            style="left: 18%; position: relative"
                          >
                            <div class="form-group has-info">
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
                                            type="file"
                                            name="foto"
                                            v-on:change="onFoto"
                                            accept="application/pdf,image/jpeg,image/png"
                                            id="id-input-file-3"
                                            :class="
                                              errors.comprovativo_bancario
                                                ? 'has-error'
                                                : ''
                                            "
                                            required
                                          />
                                        </div>
                                      </div>

                                      <label>
                                        <input
                                          type="checkbox"
                                          value="Sim"
                                          name="file-format"
                                          id="id-file-format"
                                          class="ace"
                                          hidden=""
                                        />
                                        <span class="lbl"></span>
                                      </label>
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
                          type="submit"
                          @click.prevent="cadastrarUtilizador"
                          style="border-radius: 10px"
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
    <!--/ MODAL DE CRIAR USERS-->

    <!-- adicionarFuncaoPermissao -->

    <!-- MODAL ADICIONAR FUNÇOES E PERMISSÕES -->
    <div id="adicionarFuncaoPermissao" class="modal fade criarUtilizador">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar Funções e Permissões
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                

                <form
                  method="POST"
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal"
                  id="validation-form"
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#funcaoUtilizador">
                            <i
                              class="green ace-icon fa fa-pencil-square bigger-125"
                            ></i>
                            Funções
                          </a>
                        </li>

                        <li>
                          <a data-toggle="tab" href="#permissao">
                            <i class="red ace-icon fa fa-photo bigger-125"></i>
                            Permissões
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div id="funcaoUtilizador"  class="tab-pane in active">

                         <table class="table table-bordered">
                            <tbody>
                                <tr v-for="role in roles" :key="role.id">
                                    <th scope="row">{{ role.name}}</th>
                                    <td>
                                      <th class="center">
                                        <label class="pos-rel">
                                          <input  v-model="user_roles" :value="role.id" @change="checkedRole($event,user_roles)"  type="checkbox" class="ace" />
                                          <span class="lbl"></span>
                                        </label>
                                      </th>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>

                        <div id="permissao" class="tab-pane">
                          <table class="table table-bordered">
                            <tbody>
                                <tr v-for="permission in permissions" :key="permission.id">
                                    <th scope="row">{{ permission.name}}</th>
                                    <td>
                                      <th class="center">
                                            <label class="pos-rel">
                                                <input v-model="user_permissions" :value="permission.id" @change="checkedPermission($event,user_permissions)" type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                      </th>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
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
    <!-- FIM MODAL ADICIONAR FUNÇOES E PERMISSÕES -->

    <!-- MODAL DE CRIAR USERS -->
    <div id="editarUtilizador" class="modal fade criarUtilizador">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
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
                  method="POST"
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal"
                  id="validation-form"
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#editar_usuario">
                            <i
                              class="green ace-icon fa fa-pencil-square bigger-125"
                            ></i>
                            Dados do Utilizador
                          </a>
                        </li>

                        <li>
                          <a data-toggle="tab" href="#trocar_foto">
                            <i class="red ace-icon fa fa-photo bigger-125"></i>
                            Foto do Utilizador
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div
                          id="editar_usuario"
                          class="tab-pane in active"
                          style="left: 12%; position: relative"
                        >
                          <div class="form-group has-info">
                            <div class="col-md-5">
                              <label class="control-label" for="nome"
                                >Nome<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="dataUserEdit.name"
                                  id="name"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.name ? 'has-error' : ''"
                                  required
                                />
                                <span v-if="errors.name" class="error">{{
                                  errors.name[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <label class="control-label" for="username"
                                >Username<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="dataUserEdit.username"
                                  id="username"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  required
                                />
                                <span v-if="errors.username" class="error">{{
                                  errors.username[0]
                                }}</span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group has-info">
                            <div class="col-md-5">
                              <label class="control-label" for="email_empresa"
                                >Email<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="email"
                                  v-model="dataUserEdit.email"
                                  id="email"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.username ? 'has-error' : ''"
                                  required=""
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.email[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <label
                                class="control-label"
                                for="telefone_empresa"
                                >Telefone<b class="red"
                                  ><i
                                    class="fa fa-question-circle bold text-danger"
                                  ></i></b
                              ></label>
                              <div class="">
                                <input
                                  type="text"
                                  v-model="dataUserEdit.telefone"
                                  id="phone"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  maxlength="9"
                                  :class="errors.telefone ? 'has-error' : ''"
                                  required=""
                                />
                                <span v-if="errors.email" class="error">{{
                                  errors.telefone[0]
                                }}</span>
                              </div>
                            </div>
                           
                          </div>
                        </div>

                        <div id="trocar_foto" class="tab-pane">
                          <div
                            class="row"
                            style="left: 18%; position: relative"
                          >
                            <div class="form-group has-info">
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
                                            type="file"
                                            name="foto"
                                            v-on:change="onFoto"
                                            accept="application/pdf,image/jpeg,image/png"
                                            id="id-input-file-3"
                                            :class="
                                              errors.comprovativo_bancario
                                                ? 'has-error'
                                                : ''
                                            "
                                            required
                                          />
                                        </div>
                                      </div>

                                      <label>
                                        <input
                                          type="checkbox"
                                          value="Sim"
                                          name="file-format"
                                          id="id-file-format"
                                          class="ace"
                                          hidden=""
                                        />
                                        <span class="lbl"></span>
                                      </label>
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
                          type="submit"
                          @click.prevent="editarUtilizador"
                          style="border-radius: 10px"
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
    <!--/ MODAL DE CRIAR USERS-->
  </div>
  <!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import { maska } from "maska";
import { showError } from "./../../../config/global";
import { mapState } from "vuex";
import Swal from "sweetalert2";

export default {
  directives: {
    maska,
  },
  components: {
    Select2,
  },
  props: ["users", "guard","roles", "permissions"],
  data() {
    return {
      searchQuery: null,
      errors: [],
      user_roles:[],
      user_permissions:[],
      userId:null,
      USUARIO_EMPRESA: 2,
      router: "",
      utilizador: {
        role_id: 3
      },
      dataUserEdit: {
        roles: [3],
      },
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
    };
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
  },

  mounted() {
    
  },

  computed: {
    window() {
      return window.Laravel;
    },
    buscarUtilizadores() {
      if (this.searchQuery) {
        let result = this.users.filter((item) => {
          return (
            item.name.toLowerCase().match(this.searchQuery.toLowerCase()) ||
            item.email.toLowerCase().match(this.searchQuery.toLowerCase())
          );
        });

        return result ? result : [];
      } else {
        return this.users;
      }
    },
  },

  methods: {
   async checkedRole(e, role){
    const user =  {roleId:Number(e.target.value), userId:this.userId};
    try {
      const response = await axios.post(`${this.router}/usuarios/checkedRole`, user);
      if(response.status == 200){
        this.$toasted.global.defaultSuccess();
      }
    } catch (error) {
      this.$toasted.global.defaultError({
        msg: error.response.data.message,
      });
    }
  },
  async checkedPermission(e, permission){
    const user =  {permissionId:Number(e.target.value), userId:this.userId};
    try {
      const response = await axios.post(`${this.router}/usuarios/checkedPermission`, user);
      if(response.status == 200){
        this.$toasted.global.defaultSuccess();
      }
    } catch (error) {
      this.$toasted.global.defaultError({
        msg: error.response.data.message,
      });
    }

  },
    onFoto(e) {
      this.foto = e.target.files[0];
    },
    modarAdicionarFuncoesPermissoes(user){

      this.user_roles = []
      this.user_permissions =  []

      user.roles.forEach(role => {
        this.user_roles.push(role.id)
      });

      user.permissions.forEach(permission => {
        this.user_permissions.push(permission.id)
      });
      this.userId = user.id

    },
    mostrarModalEditar(user) {
      this.dataUserEdit = {
        id: user.id,
        name: user.name,
        username: user.username,
        email: user.email,
        telefone: user.telefone,
        roles: [],
      };
      user.roles.forEach((role) => {
        if (role.id == 1) {
          this.dataUserEdit.roles[2] = role.id;
        }
        if (role.id == 2) {
          this.dataUserEdit.roles[1] = role.id;
        }
        if (role.id == 3) {
          this.dataUserEdit.roles[0] = role.id;
        }
      });
    },
    deletar(user) {
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
            .get(`${this.router}/usuarios/delete/${user.id}`)
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

    async cadastrarUtilizador() {
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };

      let formData = new FormData();
      var utilizador = JSON.stringify(this.utilizador);
      formData.append("utilizador", utilizador);
      formData.append("foto", this.foto);

      try {
        let response = await axios.post(
          `${this.router}/usuarios`,
          formData,
          config
        );
        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();

          Swal.fire({
            title: "Sucesso",
            text: "Utilizador cadastrado com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
        }
      } catch (error) {
        // console.log(error.response);return;
        this.$toasted.global.defaultError({
          msg: error.response.data.error,
        });
        this.errors = error.response.data;
      }
    },

    async editarUtilizador() {
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      let formData = new FormData();
      var utilizador = JSON.stringify(this.dataUserEdit);
      formData.append("utilizador", utilizador);
      formData.append("foto", this.foto);

      try {
        let response = await axios.post(
          `${this.router}/usuarios/update/${this.dataUserEdit.id}`,
          formData,
          config
        );
        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();

          Swal.fire({
            title: "Sucesso",
            text: "Utilizador actualizado com sucesso!",
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
          msg: error.response.data.error,
        });

        this.errors = error.response.data;
      }
    },
  },
};
</script>

<style scoped>
.has-error {
  border-color: #f2a696 !important;
}

#botoes {
  left: 0%;
  border-radius: 15px;
  margin-top: 0.1%;
  padding: 6px 12px 6px 12px;
  position: relative;
  text-transform: uppercase;
}

.checkbox label {
  /* margin-right: 20px; */
}

.is-invalid,
.invalid-feedback {
  border-color: red;
  color: red;
}
</style>
