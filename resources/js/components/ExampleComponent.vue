<template>
  <div>
      <button @click="buscar">Listar</button>
  </div>
</template>

<script>

import axios from 'axios'


export default {


  mounted() {
    console.log("Component mounted.");
  },
  methods:{
      buscar(){

          axios.get(`${baseUrl}/admin/user`).then((res)=>{
              
              console.log(res)
          });
      }
  }
};
</script>
