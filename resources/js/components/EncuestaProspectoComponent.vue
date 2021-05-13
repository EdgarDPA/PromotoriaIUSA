<template>
<div>
    <br>
    <div class="container-fluid">
          <!-- Page-Title -->
          <div class="row">
              <div class="col-sm-12">                                       
                  <span><h4><i class="ti-user" aria-hidden="true"></i><b>Registro de Prospecto</b> </h4></span>                       
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
            <center><h4 class="header-title m-t-0">Datos principales</h4></center>
            <br>
           
              <div class="row">
                  <div class="col-sm-5">
                      <div class="form-group">                                  
                      <label class="pull-left">Nombre <span class="text-danger">*</span></label>                                
                          <input type="text" class="form-control" v-model="preNombre">                   
                      </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">                                  
                    <label class="pull-left">RFC del cliente <span class="text-danger">*</span></label>                                
                    <input type="text" class="form-control" v-model="rfc">                  
                    </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">                                  
                  <label class="pull-left">Contacto <span class="text-danger">*</span></label>                                
                  <input type="text" class="form-control" v-model="contacto">                 
                  </div>
              </div>
              <div class="col-sm-8">
                <div class="form-group">                                  
                <label class="pull-left">Dirección <span class="text-danger">*</span></label>                                
                <input type="text" class="form-control" v-model="preUbicacion">                 
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">                                  
              <label class="pull-left">Teléfono <span class="text-danger">*</span></label>                                
              <input type="text" class="form-control" v-model="telefono">                 
              </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">                                  
            <label class="pull-left">Correo <span class="text-danger">*</span></label>                                
            <input type="text" class="form-control" v-model="correo">                 
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Referencia de prospección <span class="text-danger">*</span></label>                                
              <select class="form-control" v-model="referencia">
                <option>Sección Amarilla</option>
                <option>Directorio de Industria Eléctrica</option>
                <option>En Ruta</option>
                <option>Internet</option>
              </select>                 
            </div>
          </div>
        </div>
        <br>
        <center><h4 class="header-title m-t-0">Información comercial</h4></center>
        <br>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Antiguedad (año-mes)<span class="text-danger">*</span></label>                                
              <input type="text" class="form-control" v-model="antiguedad">                 
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Ramo <span class="text-danger">*</span></label>                                
              <input type="text" class="form-control" v-model="ramo">                 
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Facturación Mensual</label>                                
              <input type="text" class="form-control" v-model="mensualidad">                 
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Equipo de transporte <span class="text-danger">*</span></label>                                
              <input type="text" class="form-control" v-model="transporte">                 
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">                                  
            <label class="pull-left">Tamaño de mostrador</label>                                
              <input type="text" class="form-control" v-model="mostrador">                 
            </div>
          </div>
        </div>
        <br>
        
        <div class="row">
          <div class="col-sm-6 col-lg-6">
            <center><h4 class="header-title m-t-0">Notas</h4></center>
            <br>
            <div class="form-group" style="width: 100%;">                                                              
              <textarea v-model="notas" style="height: ; width: 100%;" rows="6">  </textarea>               
            </div>
          </div>
          <div class="col-sm-6">
            <center><h4 class="header-title m-t-0">Documentos Fisicos</h4></center>
            <br>
            <label>Recuerde recabar los siguientes documentos</label>
            <ul>
              <li>Copia de RFC</li>
              <li>Copia de Comprobante de Domicilio</li>
              <li>Compra del formato R1</li>
              <li>Copia de acta constitutiva(Personas Morales)</li>
            </ul>
            <!--<label>Adjuntar Archivo</label><br>
              <input type="file" id="fileInput" file-model="archivos.archivo1">-->
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-12">
            <center>
            <button @click="enviarFormulario()" class="btn btn-primary">Guardar nuevo prospecto </button>
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
    'preUbicacion',
    'preId',
    'preIdDistribuidor',
    'preNombreDistribuidor',
    'preLatitud',
    'preLongitud'],
  data: () => ({
      BanderaAxios: false,
      rfc:'',
      contacto:'',
      telefono:'',
      correo:'',
      referencia:'',
      antiguedad:'',
      ramo:'',
      mensualidad:'',
      transporte:'',
      mostrador: '',
      notas:'',
      alerta:''
  }),
  methods: {
    validacionFormulario(){
      let me=this;
       me.alerta = '';
      if( me.preId == null || me.preId == undefined || me.preId == ''){
        me.alerta = "Falta uno o mas campos"
      }else if( me.preNombre == null || me.preNombre == undefined || me.preNombre == ''){
        me.alerta = "Falta uno o mas campos"
      }else if( me.rfc == null || me.rfc == undefined || me.rfc == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.contacto == null ||me.contacto == undefined ||me.contacto == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.preUbicacion == null ||me.preUbicacion == undefined ||me.preUbicacion == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.telefono == null ||me.telefono == undefined ||me.telefono == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.correo == null ||me.correo == undefined ||me.correo == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.referencia == null ||me.referencia == undefined ||me.referencia == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.antiguedad == null ||me.antiguedad == undefined ||me.antiguedad == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.ramo == null ||me.ramo == undefined ||me.ramo == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.mensualidad == null ||me.mensualidad == undefined ||me.mensualidad == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.transporte == null ||me.transporte == undefined ||me.transporte == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.mostrador == null ||me.mostrador == undefined ||me.mostrador == ''){
        me.alerta = "Falta uno o mas campos"
      }else if(me.notas == null ||me.notas == undefined ||me.notas == ''){
        me.alerta = "Falta uno o mas campos"
      }else{
        me.enviarFormulario()
      }
    },
      enviarFormulario(){
        let me=this;
        me.BanderaAxios = true;
        axios.post('./guardarNuevoProspecto',{
            idOportunidad: me.preId,
            idPromotor: '3',
            nombre: me.preNombre,
            rfc: me.rfc,
            contacto: me.contacto,
            direccion: me.preUbicacion,
            telefono: me.telefono,
            correo:me.correo,
            referencia:me.referencia,
            antiguedad:me.antiguedad,
            ramo: me.ramo,
            mensualidad:me.mensualidad,
            transporte:me.transporte,
            mostrador:me.mostrador,
            notas:me.notas,
            idDistribuidor: me.preIdDistribuidor,
            nombreDistribuidor: me.preNombreDistribuidor,
            lat: me.preLatitud,
            lon: me.preLongitud
        })
        .then(function (response) {
            // handle success
            me.BanderaAxios = false;
            // alert("Se a guardado la orden de compra")                    
            swal("Registro Completado!", "Se a generado nuevo Prospecto", "success"); 
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