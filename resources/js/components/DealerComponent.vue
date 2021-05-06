<!-- Some component.vue -->
<template>
  <vue-simple-suggest
    v-model="chosen"
    :list="listaDistribuidor"
    value-attribute="KUNNR"
    display-attribute="NOMBRELIST"
    @select="onSuggestSelect"
    :filter-by-query="true">
<!-- Filter by input text to only show the matching results -->
  </vue-simple-suggest>
</template>
 
<script>
  import VueSimpleSuggest from 'vue-simple-suggest'
  import 'vue-simple-suggest/dist/styles.css' // Optional CSS
 
  export default {
    components: {
      VueSimpleSuggest
    },    
    data() {
      return {
        chosen:'',
        listaDistribuidor:{}
      }
    },
    mounted() {
            this.cargarDistribuidor()
        },
    methods: {
      onSuggestSelect (suggest) {
        //this.addToLog('select', suggest)
        console.log(suggest)
        this.$emit('DealerValue',suggest);
      },
      cargarDistribuidor (){
          let me=this;         
          axios.post('./obtenerDistribuidores',{
              id: me.initialDistribuidor,
          })
          .then(function (response) {
              // handle success             
            console.log(response);                  
            me.listaDistribuidor = response.data             
          })
          .catch(function (error) {
              // handle error
              console.log(error);              
          });
      }
    }
  }
</script> 

<style lang="scss">
.z-1000 {
  z-index: 1000;
}
.hover {
  background-color: #007bff;
  color: #fff;
}
</style> 