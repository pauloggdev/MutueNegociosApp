<template>
  <div class="row">
    <div class="col-xs-12">
      <!-- PAGE CONTENT BEGINS -->
      <div class="hr dotted"></div>

      <div>
        <div class="row search-page" id="search-page-1">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12 col-sm-9">
                <div class="row">
                  <div class="search-area well col-xs-12">informação aqui</div>
                </div>

                <div class="row search-area well">
                  <div class="col-md-4">
                    <div class="thumbnail search-thumbnail">
                      <div class="caption">
                        <h4 class="search-title">
                          <a href="#" class="blue">Thumbnail label</a>
                        </h4>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
                        <a
                          href="/empresa/facturacao/criar"
                          class="btn btn-primary button"
                        >Factura recibo</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="thumbnail search-thumbnail">
                      <div class="caption">
                        <h4 class="search-title">
                          <a href="#" class="blue">Thumbnail label</a>
                        </h4>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>

                        <router-link
                          to="/empresa/facturacao/proforma"
                          class="btn btn-primary button"
                        >Factura proforma</router-link>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="thumbnail search-thumbnail">
                      <div class="caption">
                        <h4 class="search-title">
                          <a href="#" class="blue">Thumbnail label</a>
                        </h4>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>

                        <router-link
                          to="/empresa/facturacao/recibo"
                          class="btn btn-primary button"
                        >Factura proforma</router-link>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="space-12"></div>
              </div>

              <div class="col-xs-12 col-sm-3">
                <div class="search-area well well-sm">
                  <div class="search-filter-header bg-primary">
                    <h5 class="smaller no-margin-bottom">
                      <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Centro de Ajuda
                    </h5>
                  </div>

                  <div class="hr hr-dotted"></div>

                  <h4 class="blue smaller">
                    <i class="fa fa-tags"></i>
                    Category
                  </h4>

                  <div class="hr hr-dotted"></div>

                  <h4 class="blue smaller">
                    <i class="fa fa-location-arrow light-grey bigger-110"></i>
                    Distance
                  </h4>
                </div>
                <div class="search-area well well-sm">
                  <div class="search-filter-header bg-primary">
                    <h5 class="smaller no-margin-bottom">
                      <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Fale conosco
                    </h5>
                  </div>

                  <div class="hr hr-dotted"></div>

                  <h4 class="blue smaller">
                    <i class="fa fa-tags"></i>
                    Category
                  </h4>

                  <div class="hr hr-dotted"></div>

                  <h4 class="blue smaller">
                    <i class="fa fa-location-arrow light-grey bigger-110"></i>
                    Distance
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</template>

<script>
</script>

<style scoped>
.row .search-page {
  padding-left: 11px;
}

.thumbnail.search-thumbnail {
  display: flex;
  border-radius: 8px;
  margin-right: 20px;
  margin-bottom: 20px;
  background-color: #fff;
  padding: 20px;
  border: 1px solid rgba(0, 0, 0, 0.2);
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
}

.btn-primary,
.btn-primary.focus,
.btn-primary:focus {
  border: 0;
  border-radius: 5px;
}
</style>
