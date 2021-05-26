<template>
<div>
    <div class="loader" v-if="BanderaAxios"></div>
    <div class="row">
        <div class="col-md-6">
            <p>1 - ¿Vendes productos IUSA?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta1" id="pregunta1a" v-model="pregunta1" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta1" id="pregunta1b" v-model="pregunta1" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>2 - ¿Te atiende un distribuidor IUSA?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta2" id="pregunta2a" value="SI" v-model="pregunta2"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta2" id="pregunta2b" value="NO" v-model="pregunta2"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row" v-if="pregunta2 == 'SI'">
        <span>Agrege a la lista:</span>
        <br>
        <div class="col-md-8" style="margin-bottom:10px;">
            <dealer-component @DealerValue="distribuidor_iusa = $event"></dealer-component>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info" @click="addIusa()"><span class="fa fa-plus"></span></button>
        </div> 
    </div>
    <div class="row" v-if="pregunta2 == 'NO'">
        <div class="col-md-8" style="margin-bottom:10px;">
            <input type="text" class="form-control" v-model="distribuidor" placeholder="Nombre Distribuidor"/>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info" @click="add()"><span class="fa fa-plus"></span></button>
        </div>
    </div>
    <div class="row" v-if="pregunta2">
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col" style="font-weight: 400;color:#4c5667;">DISTRIBUIDOR</th>
              <th scope="col" style="font-weight: 400;color:#4c5667;">TIPO</th>
              <th scope="col" style="font-weight: 400;color:#4c5667;">DIRECCIÓN</th>
              <th scope="col" style="font-weight: 400;color:#4c5667;">TELEFONO</th>
              <th scope="col" style="font-weight: 400;color:#4c5667;">CORREO</th>
              <th scope="col" style="font-weight: 400;color:#4c5667;">CP</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody v-for="(info, index) in distribuidores" :key="index" >
            <tr>
              <td>{{info.idIusa}} {{info.nombre.toUpperCase() }}</td>
              <td>{{info.tipo}}</td>
              <td><input type="text" class="form-control" v-model="info.direccion" placeholder="Opcional" v-if="info.tipo != 'IUSA'"/></td>
              <td><input type="text" class="form-control" v-model="info.telefono" placeholder="Opcional" v-if="info.tipo != 'IUSA'"/></td>
              <td><input type="text" class="form-control" v-model="info.correo" placeholder="Opcional" v-if="info.tipo != 'IUSA'"/></td>
              <td><input type="text" class="form-control" v-model="info.cp" placeholder="Opcional" v-if="info.tipo != 'IUSA'"/></td>
              <td>
                  <star-rating :star-size="20" v-model="info.calificacion" :show-rating="false"></star-rating>
              </td>
              <td>
                <span @click="eliminarItem(index)"><i class="fa fa-trash" style="color:#FF0000"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
        <p></p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>3 - ¿Estás satisfecho con este producto?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta3" id="pregunta3a" v-model="pregunta3" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta3" id="pregunta3b" v-model="pregunta3" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>4 - ¿Te parece correcto su precio?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta4" id="pregunta4a" v-model="pregunta4" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta4" id="pregunta4b" v-model="pregunta4" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <section class="row">
            <div class="col-md-6">
                <p>5 - ¿Qué te parece la calidad del producto?</p>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="pregunta14" v-model="pregunta5">
                <option value="5">Muy Bueno</option>
                <option value="4">Bueno</option>
                <option value="3">Regular</option>
                <option value="2">Malo</option>
                <option value="1">Muy Malo</option>
                <option value="0">No Responde</option>
            </select>
            </div>
            <div class="col-md-2 text-center">
            </div>
            </section>
        </div>
    </div>
    <p></p>
    <div class="row">
        <div class="col-md-12">
            <section class="row">
            <div class="col-md-6">
                <p>6 - ¿Qué opinión tienes de estas marcas?</p>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="pregunta14" v-model="pregunta6">
                <option value="5">Muy Bueno</option>
                <option value="4">Bueno</option>
                <option value="3">Regular</option>
                <option value="2">Malo</option>
                <option value="1">Muy Malo</option>
                <option value="0">No Responde</option>
            </select>
            </div>
            <div class="col-md-2 text-center">
            </div>
            </section>
        </div>
    </div>
    <p></p>
    <div class="row">
        <div class="col-md-12">
            <section class="row">
            <div class="col-md-6">
                <p>7 - ¿Qué te parece el empaque del producto?</p>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="pregunta14" v-model="pregunta7">
                <option value="5">Muy Bueno</option>
                <option value="4">Bueno</option>
                <option value="3">Regular</option>
                <option value="2">Malo</option>
                <option value="1">Muy Malo</option>
                <option value="0">No Responde</option>
            </select>
            </div>
            <div class="col-md-2 text-center">
            </div>
            </section>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <p>8 - ¿Vendes producto eléctrico?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta8" id="pregunta8a" v-model="pregunta8" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta8" id="pregunta8b" v-model="pregunta8" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>9 - ¿Quieres que te haga un sugerido eléctrico?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta9" id="pregunta9a" v-model="pregunta9" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta9" id="pregunta9b" v-model="pregunta9" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>10 - ¿Vendes producto gas?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta10" id="pregunta10a" v-model="pregunta10" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta10" id="pregunta10b" v-model="pregunta10" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <button class="btn btn-primary btn-block"  @click="guardarEncuesta()">
            <i class="fa fa-check" aria-hidden="true"></i>
            ENVIAR ENCUESTA
        </button>
    </div>
</div>
</template>
<style>
    .star{
        cursor:pointer;
    }
</style>
<script>
import StarRating from 'vue-star-rating'
export default {
  components: {StarRating},
  props:[
    'idOportunidad',
    ],
  data: () => ({
      BanderaAxios: null,
      pregunta1:null,
      pregunta2:null,
      pregunta3:null,
      pregunta4:null,
      pregunta5:null,
      pregunta6:null,
      pregunta7:null,
      pregunta8:null,
      pregunta9:null,
      pregunta10:null,
      distribuidores:[],
      distribuidor: null,
      distribuidor_iusa: null,
      objeto_default: {}
  }),
  methods: {
      add(){
         if(this.distribuidor != null){
             this.objeto_default={
                 nombre:"",
                 idIusa:"",
                 tipo:"Otro",
                 direccion:"",
                 telefono:"",
                 correo: "",
                 cp:"",
                 calificacion:""
             };
             this.objeto_default.nombre = this.distribuidor;
             this.distribuidores.push(this.objeto_default);
             this.distribuidor = null;
             this.objeto_default = {};
            console.log(this.distribuidores);
         }
      },
      addIusa(){
         if(this.distribuidor_iusa != null){
             this.objeto_default={
                 nombre:"",
                 idIusa:"",
                 tipo:"IUSA",
                 direccion:"",
                 telefono:"",
                 correo: "",
                 cp:"",
                 calificacion:""
             };
             this.objeto_default.nombre = this.distribuidor_iusa.NAME1;
             this.objeto_default.idIusa = this.distribuidor_iusa.KUNNR;
             this.distribuidores.push(this.objeto_default);
             this.distribuidor_iusa = null;
             this.objeto_default = {};
            console.log(this.distribuidor_iusa);
         }
      },
      eliminarItem (index, count){
        this.distribuidores.splice(index, 1);
      },
      qualify(id){
          alert(id);
      },
      guardarEncuesta(){
          let me=this;
        me.BanderaAxios = true;
        axios.post('./guardarEncuesta',{
            idOportunidad: me.idOportunidad,
            pregunta1: me.pregunta1,
            pregunta2: me.pregunta2,
            pregunta3: me.pregunta3,
            pregunta4: me.pregunta4,
            pregunta5: me.pregunta5,
            pregunta6: me.pregunta6,
            pregunta7: me.pregunta7,
            pregunta8: me.pregunta8,
            pregunta9: me.pregunta9,
            pregunta10: me.pregunta10,
            distribuidores: me.distribuidores
        })
        .then(function (response) {
            // handle success
            me.BanderaAxios = false;       
            me.distribuidores = null;  
            me.distribuidor_iusa = null;  
            me.distribuidor = null;         
            swal("Encuesta Finalizada!", "Se a enviado la encuesta", "success");  
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