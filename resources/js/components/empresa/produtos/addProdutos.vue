<template>
  <section class="content">

    <div class="row">
        <div class="space-6"></div>
            <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
            CADASTRO DE PRODUTOS
                <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Cadastro
                </small>
            </h1>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <!-- AVISO -->
                <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b> são de preenchimento obrigatório.
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">
                        <i class="fa fa-product-hunt"></i>
                        Dados Referentes ao Produto
                    </div>
                </div>

                <form method = 'POST' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">

                                <div id="dados_fornecedor" class="tab-pane in active" style="">
                                    <h4 class="header bolder smaller" style="color: #3d5476">Geral</h4>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="designacao">Nome do Produto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="input-group">
                                                <input type="text" id="designacao" required class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="col-md-3">
                                                <label class="control-label bold" for="referencia">Referência<b class="red bolder">*</b></label>
                                                <div class="input-group">
                                                    <input type="text" id="referencia" class="col-md-12 col-xs-12 col-sm-3" required=""/>
                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-qrcode bigger-110 text-info"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="control-label bold" for="total">Código de Barras<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="input-group">
                                                    <input type="text" id="total" class="col-md-12 col-xs-12 col-sm-3" required=""/>
                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-barcode bigger-110 text-info"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">O Fabricante<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select name="status_id" style="height: 34px" class="col-md-12 col-xs-12  col-sm-4 select2" data-placeholder="Selecione o Fabricante" id="status_id">
                                                    <option value=""></option>
                                                    <option value="">A</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="id-input-file-3" class="text-info">Imagem do Produto</label>
                                            <div class="file-upload-wrapper" id="imagem">
                                                <input type="file" accept="application/pdf,image/*" id="id-input-file-2" class="imagem" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label bold" for="status_id">Status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione o status">
                                                    <option value=""></option>
                                                    <option value="1">Activo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="id-date-picker-1">Data de Expiração</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control date-picker"  style="height: 35px;" autocomplete="off" id="id-date-picker-1" data-date-format="yyyy-mm-dd" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label bold" for="observacao">Descrição<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="input-icon">
                                                <i class="ace-icon fa fa-comment"></i>
                                                <textarea type="text" name="observacao" id="observacao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="header bolder smaller" style="color: #3d5476">Vendas</h4>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Imposto/Taxas<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Categoria">
                                                    <option value="1">IVA-Isento(0%)</option>
                                                    <option value="1">IVA-Taxa Reduzida(0%)</option>
                                                    <option value="1">IVA-Taxa Reduzida(14%)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Motivo de Isenção<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Marca">
                                                    <option value="M00" >Regime Transitório</option>
                                                    <option value="M02" >Transmissão de bens e serviços não sujeita</option>
                                                    <option value="M04" >Regime de não sujeição</option>
                                                    <option value="M10" >Isento - Artigo 12.º a) do CIVA</option>
                                                    <option value="M11" >Isento - Artigo 12.º b) do CIVA</option>
                                                    <option value="M12" >Isento - Artigo 12.º c) do CIVA</option>
                                                    <option value="M13" >Isento - Artigo 12.º d) do CIVA</option>
                                                    <option value="M14" >Isento - Artigo 12.º e) do CIVA</option>
                                                    <option value="M15" >Isento - Artigo 12.º, f) do CIVA</option>
                                                    <option value="M16" >Isento - Artigo 12.º, g) do CIVA</option>
                                                    <option value="M17" >Isento - Artigo 12.º, h) do CIVA</option>
                                                    <option value="M18" >Isento - Artigo 12.º, i) do CIVA</option>
                                                    <option value="M19" >Isento - Artigo 12.º, j) do CIVA</option>
                                                    <option value="M20" >Isento - Artigo 12.º, k) do CIVA</option>
                                                    <option value="M30" >Isento - Artigo 15.º, 1º, a) do CIVA</option>
                                                    <option value="M31" >Isento - Artigo 15.º, 1º, b) do CIVA</option>
                                                    <option value="M32" >Isento - Artigo 15.º, 1º, c) do CIVA</option>
                                                    <option value="M33" >Isento - Artigo 15.º, 1º, d) do CIVA</option>
                                                    <option value="M34" >Isento - Artigo 15.º, 1º, e) do CIVA</option>
                                                    <option value="M35" >Isento - Artigo 15.º, 1º, f) do CIVA</option>
                                                    <option value="M36" >Isento - Artigo 15.º, 1º, g) do CIVA</option>
                                                    <option value="M37" >Isento - Artigo 15.º, 1º, h) do CIVA</option>
                                                    <option value="M38" >Isento - Artigo 15.º, 1º, i) do CIVA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div class="form-group has-info">
                                         <div class="col-md-3">
                                            <label class="control-label bold" for="armazem">Armazén <b class="red fa fa-question-circle"></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="controlo_stock" style="height: 35px" data-placeholder="Selecione o Armazén">
                                                    <option value=""></option>
                                                    <option value="1">Kafulama</option>
                                                    <option value="1">Distrigood</option>
                                                    <option value="1">Inovia LTDA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group has-info bold">
                                        <div class="col-sm-6">
                                            <table id="smart-prices" class="table table-striped" style="margin:0">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="" title="Preço que custou o produto.">Preço de compra <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span></th>
                                                        <th colspan="" ><span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></th>
                                                        <th colspan=""><span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></th>
                                                    </tr>
                                                    
                                                    <tr class="smart-price-produto">
                                                        <td width="100%" >
                                                            <div class="input-group">
                                                                <div class="input-group-addon">Kz</div>
                                                                <input class="form-control" data-target="form_supply_price" style="height: 35px; font-size: 13pt">
                                                                <span class="input-group-addon" id="basic-addon1">
                                                                    <i class="fa fa-calculator price-popup-icon" data-target="form_supply_price_smartprice"></i>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <table id="smart-prices" class="table table-striped" data-list="[{&quot;ukey_id&quot;:48822116,&quot;saas_id_join&quot;:36403,&quot;title&quot;:&quot;Normal&quot;,&quot;is_default&quot;:&quot;yes&quot;,&quot;group_title&quot;:&quot;Normal&quot;}]" style="margin:0">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="" title="Margem de lucro que pretende ter na venda do produto.">Margem <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span></th>
                                                        <th colspan="" title="Preço de venda ao público calculado com imposto.">Preço de Venda <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span></th>
                                                        <th colspan="" title="Preço normal ou calculado sem o IVA">Preço Normal <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></th>
                                                    </tr>
                                                    <tr class="smart-price-produto">
                                                        <td width="34%">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">%</div>
                                                                <input class="markup form-control" title="Margem de lucro que pretende ter na venda do produto." style="height: 35px; font-size: 13pt">
                                                            </div>
                                                        </td>

                                                        <td width="34%">
                                                            <span class="input-group">
                                                                <div class="input-group-addon">Kz</div>
                                                                <input value="0" class="price_with_tax form-control" title="Preço de venda ao público calculado com imposto." style="height: 35px; font-size: 13pt">
                                                            </span>            
                                                        </td>
                                                        <td width="20%" nowrap="">
                                                            <span class="price-tax-note text-muted">
                                                                <span class="price_without_tax_html">Kz 0,00</span>
                                                            </span>
                                                            <input class="price_without_tax" placeholder="" type="hidden" value="0" title="Preço normal ou calculado sem o IVA">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <hr style="margin-top: -1%">
                                    
                                    <div class="form-group has-info bold">
                                        <div style="margin-top: -1%;">
                                            <div class="col-md-3">
                                                <label class="control-label bold" for="controlo_stock">Controlar Stock <b class="red fa fa-question-circle"></b></label>
                                                <div class="">
                                                    <select class="col-md-12 col-xs-12 col-sm-4 select2" id="controlo_stock" style="height: 35px" data-placeholder="Sim / Não">
                                                        <option value=""></option>
                                                        <option value="Sim">Sim</option>
                                                        <option value="Não">Não</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="control-label bold" for="tipo_stock">Tipo de Stock <b class="red fa fa-question-circle"></b></label>
                                                <div class="">
                                                    <select class="col-md-12 col-xs-12 col-sm-4 select2" id="tipo_stock" style="height: 35px" data-placeholder="Selecione o Stock">
                                                        <option value=""></option>
                                                        <option value="1">Matérias Primas</option>
                                                        <option value="1">Mercadoria</option>
                                                        <option value="1">Subsidiária ou de consumo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="col-md-3">
                                                <label class="control-label bold" for="quantidade">Quantidade mínima</label>
                                                <div class="input-icon" >
                                                    <input type="number" class="form-control col-md-12 col-xs-12 col-sm-4" id="spinner3" min="1" style="height: 35px;" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="control-label bold" for="quantidade">Quantidade crítica</label>
                                                <div class="input-icon">
                                                    <input type="number" class="form-control col-md-12 col-xs-12 col-sm-4"  id="spinner4" min="1" style="height: 35px;" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <br/>

                                    <h4 class="header bolder smaller" style="color: #3d5476">Características</h4>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Classe de Bem<b class="red"></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Classe">
                                                    <option value=""></option>
                                                    <option value="1">Alimentar</option>
                                                    <option value="1">Álcool tabaco</option>
                                                    <option value="1">Produtos Culturais</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Unidade<b class="red"></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Unidade">
                                                    <option value=""></option>
                                                    <option value="1">Kg</option>
                                                    <option value="1">Litro</option>
                                                    <option value="1">Grama</option>
                                                    <option value="1">Diversos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Categoria<b class="red"></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Categoria">
                                                    <option value=""></option>
                                                    <option value="1">Alimentar</option>
                                                    <option value="1">Álcool e tabaco</option>
                                                    <option value="1">Produtos Culturais</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label bold" for="status_id">Marca<b class="red"></b></label>
                                            <div class="">
                                                <select class="col-md-12 col-xs-12 col-sm-4 select2" id="status_id" style="height: 35px" data-placeholder="Selecione a Marca">
                                                    <option value=""></option>
                                                    <option value="1">Kg</option>
                                                    <option value="1">Litro</option>
                                                    <option value="1">Grama</option>
                                                    <option value="1">Diversos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="search-btn" type="submit" style="border-radius: 10px">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </button>

                                &nbsp; &nbsp;
                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
    </div>
  </section>
</template>

<script>
  import axios from "axios";
  import { showError } from "./../../../config/global";
  import { mapState } from "vuex";

  export default {
    props: ["prdutos", "status"],
    data() {
      return {
        produto: {}
      };
    },

    methods: {
      salvar() {
        if (!this.produto.designacao) {
          this.$toasted.global.defaultError({
            msg: "O campo produto é obrigatorio"
          });
          return;
        } else if (!this.produto.statuId) {
          this.$toasted.global.defaultError({
            msg: "O campo status é obrigatorio"
          });
          return;
        } else {
          axios
            .post(`${baseUrl}/empresa/produtos/adicionar`, this.produto)
            .then(res => {
              this.$toasted.global.defaultSuccess();

              setTimeout(function() {
                document.location.reload(true);
              }, 2000);
              this.reset();
            })
            .catch(showError);
        }
      },
      reset() {
        this.produto = {};
      }
    }
  };
</script>

<style scoped>
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
