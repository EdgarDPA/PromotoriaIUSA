<template>
<div>
    <br>
    <div class="container-fluid">
          <!-- Page-Title -->
          <div class="row">
              <div class="col-sm-12">                                       
                  <span><h4><i class="ti-user" aria-hidden="true"></i><b>Reportar Oportunidad</b> </h4></span>                       
              </div>
          </div>
          <br>
          <div class="col-lg-12">
           <div class="col-md-12" v-show="alerta">
              <div class="alert alert-warning">
                <li>{{alerta}}</li>
              </div>
            </div>
            <div class="loader" v-if="BanderaAxios"></div>
            <div class="card-box">              
            <center><h4 class="header-title m-t-0">Motivo de baja</h4></center>
            <label>Nombre: {{preNombre}}</label>
            <br>
           <div class="form-group" style="width: 100%;">                                                              
              <textarea v-model="motivo" style="height: ; width: 100%;" rows="6">  </textarea>               
            </div>
            
              
        <div class="row">
          <div class="col-sm-12">
            <center>
            <button @click="enviarFormulario()" class="btn btn-danger">Reportar Oportunidad</button>
            </center>
          </div>
        </div>

            </div>
          </div>

                            

        </div><!-- fin container-fluid-->
</div>
</template>
<script>

export default {
  components: { },
  props:[
    'preNombre',    
    'preId'],
  data: () => ({
      BanderaAxios: false,
      motivo:''
  }),
  methods: {
      enviarFormulario(){
        let me=this;
        me.BanderaAxios = true;
        axios.post('./darBajaOportunidad',{
            idOportunidad: me.preId,
            idPromotor: '3',
            motivo: me.motivo
        })
        .then(function (response) {
            // handle success
            me.BanderaAxios = false;
            // alert("Se a guardado la orden de compra")                    
            swal("Reporte Completado!", "Se a reportado la oportunidad", "success"); 
            me.$emit('Volver','ok');                  
        })
        .catch(function (error) {
            // handle error
            console.log(error);
            me.BanderaAxios = false;
        });
      }
  },
}
</script>