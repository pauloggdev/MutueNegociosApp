<template>
<div class="form-group has-info bold" style="left: 0%; position: relative">
    <div class="col-md-6">
        <label class="control-label bold label-select2">Armazém/Loja<b class="red fa fa-question-circle"></b></label>
        <Select2 :options="armazens" v-model="existencia.armazem_id" placeholder="Selecione o status">
        </Select2>
    </div>

    <div class="col-md-4">
        <label class="control-label bold label-select2" for="spinner3">Quantidade</label>
        <div class="input-icon">
            <vue-numeric-input v-model="existencia.quantidade" :min="0" :step="1"></vue-numeric-input>
            <!-- <span v-if="errors.stocavel" class="error">{{errors.stocavel[0]}}</span> -->
        </div>
    </div>
    <div class="col-md-2">
        <label class="control-label bold label-select2" for="spinner3"></label>
        <div class="input-icon">

            <button style="padding:6px; margin-top:7px" @click="removerArmazem">
                <i class="ace-icon fa fa-times  bigger-50 icon-only"></i>
            </button>
        </div>

    </div>
</div>
</template>

<script>
import VueNumericInput from "vue-numeric-input";
import Select2 from 'v-select2-component';

export default {

    components: {
        VueNumericInput,
        Select2
    },

    data() {

        return {
            armazens: [],
            existencia: {
                armazem_id: '',
                quantidade: ''
            }
        }
    },
    methods: {

        removerArmazem() {

        }

    }

}
</script>

<style>

</style>
