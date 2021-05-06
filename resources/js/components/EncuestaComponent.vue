<template>
<div>
    <div class="row">
        <div class="col-md-6">
            <p>1 - ¿Vendes productos IUSA?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta1" id="pregunta1b" value="NO"> No
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
        <div class="col-md-10" style="margin-bottom:10px;">
            <span>Seleccione:</span>
            <p></p>
            <dealer-component></dealer-component>
        </div>
    </div>
    <div class="row" v-if="pregunta2 == 'NO'">
        <div class="col-md-8" style="margin-bottom:10px;">
            <input type="text" class="form-control" v-model="distribuidor" />
        </div>
        <div class="col-md-2">
            <button class="btn btn-info" @click="add()"><span class="fa fa-plus"></span></button>
        </div>
    </div>
    <div class="row" v-if="pregunta2 == 'NO'">
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col" style="font-weight: 400;color:#4c5667;">DISTRIBUIDOR</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody v-for="(info, index) in distribuidores" :key="index" >
            <tr>
              <td>{{info.toUpperCase() }}</td>
              <td>
                  <span class="fa fa-star star" id="1" @click="qualify(id)"></span>
                  <span class="fa fa-star star" id="2"></span>
                  <span class="fa fa-star star" id="3"></span>
                  <span class="fa fa-star star" id="4"></span>
                  <span class="fa fa-star star" id="5"></span>
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
            <input type="radio" name="pregunta3" id="pregunta3a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta3" id="pregunta3b" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>4 - ¿Te parece correcto su precio?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta4" id="pregunta4a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta4" id="pregunta4b" value="NO"> No
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
                <select class="form-control" id="pregunta14">
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
                <select class="form-control" id="pregunta14">
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
                <select class="form-control" id="pregunta14">
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
            <input type="radio" name="pregunta8" id="pregunta8a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta8" id="pregunta8b" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>9 - ¿Quieres que te haga un sugerido eléctrico?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta9" id="pregunta9a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta9" id="pregunta9b" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>10 - ¿Vendes producto gas?</p>
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta10" id="pregunta10a" value="SI"> Si
        </div>
        <div class="col-md-2">
            <input type="radio" name="pregunta10" id="pregunta10b" value="NO"> No
        </div>
        <div class="col-md-2 text-center">
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

export default {
  components: { },
  data: () => ({
      pregunta2:null,
      distribuidores:[],
      distribuidor: null,
  }),
  methods: {
      add(){
         if(this.distribuidor != null){
             this.distribuidores.push(this.distribuidor);
             this.distribuidor = null;
            console.log(this.distribuidores);
         }
      },
      eliminarItem (index, count){
        this.distribuidores.splice(index, 1);
      },
      qualify(id){
          alert(id);
      }
  },
}
</script>