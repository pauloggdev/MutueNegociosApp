<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Facturas

            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Dépositos de valores
            </small>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Recibos
            </small>
        </h1>
    </div>

   
</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";


export default {
    
       
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

.is-invalid,
.invalid-feedback {
    border-color: red;
    color: red;
}
</style>
