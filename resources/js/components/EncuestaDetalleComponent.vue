<template>
<div>
    <div class="container-fluid">
        <div class="card-box"> 
            <h4>Resultado de Encuesta</h4>
            <br>
        <label>Nombre: {{preNombre}}</label><br>
        <label>Fecha: {{respuestas.fecha}}</label><br>
        <label>Hora: {{respuestas.hora}}</label><br>
        <div class="loader" v-if="BanderaAxios"></div>
        <div class="row">
            <div class="col-md-6">
                <p>1 - ¿Vendes productos IUSA?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta1}}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>2 - ¿Te atiende un distribuidor IUSA?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta2}}
            </div>
        </div>        
        
        <div class="row">
            <div class="col-md-6">
                <p>3 - ¿Estás satisfecho con este producto?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta3}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>4 - ¿Te parece correcto su precio?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta4}}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <section class="row">
                <div class="col-md-6">
                    <p>5 - ¿Qué te parece la calidad del producto?</p>
                </div>
                <div class="col-md-6">
                    <p v-if="respuestas.pregunta5 == 5">Muy Bueno</p>
                    <p v-if="respuestas.pregunta5 == 4">Bueno</p>
                    <p v-if="respuestas.pregunta5 == 3">Regular</p>
                    <p v-if="respuestas.pregunta5 == 2">Malo</p>
                    <p v-if="respuestas.pregunta5 == 1">Muy Malo</p>
                    <p v-if="respuestas.pregunta5 == 0">No Responde</p>                    
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
                <div class="col-md-6">
                    <p v-if="respuestas.pregunta6 == 5">Muy Bueno</p>
                    <p v-if="respuestas.pregunta6 == 4">Bueno</p>
                    <p v-if="respuestas.pregunta6 == 3">Regular</p>
                    <p v-if="respuestas.pregunta6 == 2">Malo</p>
                    <p v-if="respuestas.pregunta6 == 1">Muy Malo</p>
                    <p v-if="respuestas.pregunta6 == 0">No Responde</p>                    
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
                <div class="col-md-6">
                    <p v-if="respuestas.pregunta7 == 5">Muy Bueno</p>
                    <p v-if="respuestas.pregunta7 == 4">Bueno</p>
                    <p v-if="respuestas.pregunta7 == 3">Regular</p>
                    <p v-if="respuestas.pregunta7 == 2">Malo</p>
                    <p v-if="respuestas.pregunta7 == 1">Muy Malo</p>
                    <p v-if="respuestas.pregunta7 == 0">No Responde</p>                    
                </div>
                </section>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p>8 - ¿Vendes producto eléctrico?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta8}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>9 - ¿Quieres que te haga un sugerido eléctrico?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta9}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>10 - ¿Vendes producto gas?</p>
            </div>
            <div class="col-md-6">
                {{respuestas.pregunta10}}
            </div>
        </div>

        <div class="row" v-if="distribuidores.length != 0">
            <h4>Distribuidores Registrados</h4>
            <br>
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
                
                </tr>
            </thead>
            <tbody v-for="(info, index) in distribuidores" :key="index" >
                <tr>
                <td>{{info.idIusa}} {{info.nombre.toUpperCase() }}</td>
                <td>{{info.tipo}}</td>
                <td>{{info.direccion}}</td>
                <td>{{info.telefono}}</td>
                <td>{{info.correo}}</td>
                <td>{{info.cp}}</td>
                <td>
                    <star-rating :star-size="20" v-model="info.calificacion" :show-rating="false" :read-only="true"></star-rating>
                </td>
                
                </tr>
            </tbody>
            </table>
            <p></p>
        </div>
        
        </div>
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
    'preNombre'
    ],
  data: () => ({
      BanderaAxios: null,    
      distribuidores:[],
      respuestas:{},
      
  }),
  created() {
            console.log('OpportunityComponent')
            this.buscarResultadosEncuesta()
        },
  methods: {
      buscarResultadosEncuesta(){
          let me=this;
        me.BanderaAxios = true;
        axios.post('./obtenerResultadosEncuesta',{
            id: me.idOportunidad,
        })
        .then(function (response) {
            // handle success             
            me.BanderaAxios = false; 
            me.distribuidores =response.data.distribuidores;
            me.respuestas =response.data.respuestas;
        })
        .catch(function (error) {
            me.BanderaAxios = false;
            console.log(error);              
        });
      }
      
  },
}
</script>