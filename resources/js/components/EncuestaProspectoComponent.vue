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
                <li v-bind="alerta"></li>
              </div>
            </div>
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
        <!--<div class="row">
          <div class="col-sm-6">
            <center><h4 class="header-title m-t-0">Documentos Fisicos</h4></center>
            <br>
            <label>Recuerde recabar los siguientes documentos</label>
            <br>
              <label>Copia de RFC</label><br>
              <input type="file" id="fileInput" file-model="archivos.rfc"><br> 
              <label>Copia de Comprobante de Domicilio</label><br>
              <input type="file" id="fileInput" file-model="archivos.domicilo"><br>
              <label>Compra del formato R1</label><br>
              <input type="file" id="fileInput" file-model="archivos.fr1"><br>
              <label>Copia de acta constitutiva(Personas Morales)</label><br>
              <input type="file" id="fileInput" file-model="archivos.acta">
  
          </div>

          <div class="col-sm-6">
            <center><h4 class="header-title m-t-0">Imagenes del negocio</h4></center>
            <br>
            <label>Recuerde recabar fotografias del negocio del prospecto</label>
            <br>
              <label>Foto 1</label><br>
              <input type="file" id="fileInput" file-model="foto.foto1"><br> 
              <label>Foto 2</label><br>
              <input type="file" id="fileInput" file-model="foto.foto2"><br>
              <label>Foto 3</label><br>
              <input type="file" id="fileInput" file-model="foto.foto3"><br>
              <label>Foto 4</label><br>
              <input type="file" id="fileInput" file-model="foto.foto4">
  
          </div>

        </div>-->
        <!--<div class="row">
          <div class="col-sm-6">
            <center><h4 class="header-title m-t-0">GPS</h4></center>
            <br>
            <a href="" ng-click="actualizargps()" class="btn btn-primary">Obtener gps </a>
          </div>
          <div class="col-sm-6">
           
          </div>
        </div>-->
        <div class="row">
          <div class="col-sm-12">
            <center>
            <a href="" @click="enviarFormulario()" class="btn btn-primary">Guardar nuevo prospecto </a>
            </center>
          </div>
        </div>

            </div>
          </div>

                            

        </div><!-- fin container-fluid-->
</div>
</template>
<style>
    .star{
        cursor:pointer;
    }
</style>
<script>

export default {
  components: { },
  props:['preNombre','preUbicacion'],
  data: () => ({
      nombre:this.preNombre,
      contacto:this.preUbicacion
  }),
  methods: {
      enviarFormulario(){
        
      }
  },
}
</script>