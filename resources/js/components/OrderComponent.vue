<template>
<div>
<div class="card-box">
    <h3 class="text-dark  header-title m-t-0 m-b-20">Generar Orden de Compra</h3>
    <!--<div class="form-row align-items-center">         
        <div class="col-auto">
            <input type="radio" id="Oportunidad" value="Oportunidad" v-model="tipo_orden">
            <label for="Oportunidad"><strong>Oportunidad</strong></label>
        </div>
        <div class="col-auto">
            <input type="radio" id="Prospecto" value="Prospecto" v-model="tipo_orden">
            <label for="Prospecto"><strong>Prospecto</strong></label>
        </div>
    </div>
    <div v-show ="tipo_orden == 'Oportunidad'">
        <h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-user"></span> Oportunidad a Orden de Compra</h4>
        <opportunity-list-component @DealerValue="obtenerDistribuidor($event)"></opportunity-list-component>
    </div>-->
    <div v-show ="tipo_orden == 'Prospecto'">
        <h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-user"></span> Prospecto a Orden de Compra</h4>
        <prospecto-list-component @DealerValue="obtenerDistribuidorProspecto($event)"></prospecto-list-component>
    </div>

<br>
<div v-show ="tipo_orden">
<h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-plus-circle"></span> Agregar Producto</h4>    
    <div class="row container">
        <div class="loader" v-if="BanderaAxios"></div>
        <form>
            <div class="form-row align-items-center">
                <div class="col-auto">
                <label class="sr-only" for="inlineFormInput">Name</label>
                <input type="text" class="form-control mb-2" id="inlineFormInput1" v-model="codigo" placeholder="Código de material">
                </div>
                <div class="col-auto">
                <label class="sr-only" for="inlineFormInput">Name</label>
                <input type="text" class="form-control mb-2" id="inlineFormInput2" v-model="unidades" placeholder="Unidades">
                </div>
                <div class="col-auto">
                    <button class="btn btn-success mb-2" @click.prevent="buscarMaterialCarrito()">
                        <i class="fa fa-cart-plus" aria-hidden="true"></i> AGREGAR
                    </button>                
                </div>
                <div class="col-auto">
                     <button type="button" class="btn btn-primary justify-content-center shadow-box font-size-standard"
                      data-toggle="modal" data-target="#myModal" @click="CatalogoGeneral()"> Catálogo de productos
                    </button>               
                </div>
            </div>
        </form>
        <div class="col-lg-12 alert alert-warning" v-if="errorMaterial">
            <li>{{errorMaterial}}</li>
        </div>
        <table class="table table-sm" style="text-align:left;margin-top:15px;" v-if="listaCarrito.length != 0">
        <thead class="thead-light">
            <tr>
            <th scope="col">CÓDIGO</th>
            <th scope="col">DESCRIPCIÓN</th>
            <th scope="col">UNIDADES SOLICITADAS</th>
            <th scope="col">U. MED</th>
            <th scope="col">EMPAQUE</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(listaCarrito, index) in listaCarrito" :key="index">
            <td>{{ listaCarrito.codigo_material}}</td>
            <td>{{ listaCarrito.nombre_material}}</td> 
            <td class="col-sm-12 row">
                <div class="form-check-inline">
                <input type="text" class="form-control mb-2" v-model="listaCarrito.u_confirm" @keyup.enter="actualizarUnidades(listaCarrito)">
                <center>
                    <button @click="sumarUnidades(listaCarrito)">
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </button>
                    <button @click="restarUnidades(listaCarrito)">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </button>
                </center>
                </div>
            </td>
            <td>{{ listaCarrito.unidad_medida}}</td>
            <td>{{ listaCarrito.empaque}}</td>
            <td><span class="fa fa-times-circle" style="color:#c71612;" @click="eliminarItem(index)"></span></td>
            </tr>
        
        </tbody>
        </table>
    </div>
</div>

    <div class="col-lg-12" v-if="listaCarrito.length != 0"> 
        <div class="col-lg-12" style="margin-bottom:10px;" v-if="Bandera_Distribuidor_precargado == false">
            <h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-user-plus"></span> Seleccione Distribuidor</h4>
            <p></p>
            <dealer-component @DealerValue="id_distribuidor = $event"></dealer-component>
        </div>
        <div class="col-lg-12" style="margin-bottom:10px;" v-if="Bandera_Distribuidor_precargado == true">
            <h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-user-plus"></span>Seleccionar Distribuidor</h4>
            <div class="row">
                <div class="col-lg-6">
                    <label><strong>IUSA</strong></label><br>
                    <div class="col-auto" v-for="(listaDistribuidoresIusa, index) in listaDistribuidoresIusa" :key="index">
                        <input type="radio" id="Oportunidad" :value="listaDistribuidoresIusa" v-model="distri_select" >
                        <label for="Oportunidad"><strong>{{listaDistribuidoresIusa.idIusa}} - {{listaDistribuidoresIusa.nombre}}</strong></label>                
                    </div>
                </div>
                <div class="col-lg-6">
                    <label><strong>Otros</strong></label><br>
                    <div class="col-auto" v-for="(listaDistribuidoresOtros, index) in listaDistribuidoresOtros" :key="index">
                        <input type="radio" id="Oportunidad" :value="listaDistribuidoresOtros" v-model="distri_select" >
                        <label for="Oportunidad"><strong>{{listaDistribuidoresOtros.nombre}}</strong></label>                
                    </div>
                </div>   
            </div>         
        </div>
    </div>

    <div class="col-lg-12" v-if="listaCarrito.length != 0"> 
        <div class="col-lg-12" style="margin-bottom:10px;">
            <h4 class="text-dark  header-title m-t-0 m-b-20"><span class="fa fa-info-circle"></span>Orden de Compra</h4>
            <p></p>
            <input type="text" class="form-control mb-2" id="inlineFormInput1" v-model="orden_compra">
        </div>
    </div>
            
    <div class="col-lg-12">
        <div class="row">
            <button class="btn btn-primary btn-block"  @click="guardarOrden()" v-if="listaCarrito.length != 0">
                <i class="fa fa-check" aria-hidden="true"></i>
                GENERAR ORDEN DE COMPRA
            </button>
        </div>
    </div>
</div>
    <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" id="catalogo_inicio">
              <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
              <h4 class="modal-title text-dark1"><span class="glyphicon glyphicon-plus-sign"></span> <i
                  class="ti-book icon"></i> &nbsp;Catálogo de productos</h4>
            </div>
            <div class="modal-body">
              <!--MENU GENERAL -->
              <div class="col-md-12">
                <div class="table-responsive " v-if="bandera_tabla == 0">
                  <table class="table mb-0 table-hover">
                    <thead>
                      <tr colspan="2">
                        <th class="text-dark1">
                          <center>Familia</center>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-dark1">Buscar: <input type="text" class="form-control" v-model="buscarFamilia"
                            placeholder="Buscar Familia"></th>
                      </tr>

                    </thead>
                    <tbody v-if="listaCatalogo.length != 0">
                      <tr v-for="(listaCatalogo, index) in filteredCatalogo" :key="index">
                        <td><a  @click="catalogoGPOM41(listaCatalogo)">{{listaCatalogo.LABEL}}</a></td>
                      </tr>
                    </tbody>
                  </table>
       
                </div>
                <!--MENU GENERAL -->
                <!--MENU Grupo material 4 -->
                <div class="table-responsive" v-if="bandera_tabla == 1">
                  <table class="table mb-0 table-hover">
                    <thead>
                        <tr>
                            <th class="text-dark1" colspan="2">GPO.MAT.4: {{gpo4.LABEL}}</th>
                        </tr>
                        <tr>
                            <th>
                            <button class="btn-primary" @click="regresarTablaCatalogo()">Regresar</button>
                            </th>                      
                        </tr>
                        <tr>
                            <th class="text-dark1">Buscar: <input type="text" class="form-control" v-model="buscarMaterial"
                                placeholder="Buscar Familia">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-dark1" colspan="2">
                            <center> MATERIALES</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="listaCatalogo.length != 0">
                      <tr v-for="(listaCatalogo, index) in filteredCatalogoG4" :key="index">
                        <td data-dismiss="modal" ><a @click="catalogoGPOM41_Se(listaCatalogo)">{{listaCatalogo.ID}} -  {{listaCatalogo.LABEL}}</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer" style="background-color: #ecf0f5;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <span
                    class="glyphicon glyphicon-remove"></span> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>

</div> 
           
</template>

<script>
    import axios from 'axios'
    import swal from 'sweetalert';
    export default {
        data(){
            return{
                BanderaAxios: null,
                codigo:null,
                unidades: null,
                errorMaterial: null,
                bandera_repetido: 0,
                id_distribuidor: {},
                orden_compra: '',
                id_Usuario: '',
                listaCarrito: [],
                listaDistribuidoresIusa: [],
                listaDistribuidoresOtros:[],
                distri_select: '',
                tipo_orden: 'Prospecto',
                Bandera_Distribuidor_precargado: false,
                bandera_tabla:0,
                listaCatalogo:[],
                buscarFamilia:'',
                buscarMaterial:'',
                gpo4:[]           
            }  
        },
        mounted() {
            console.log('OrderComponent')
        },
        computed: {
            filteredCatalogo: function () {
                var self = this;
                return this.listaCatalogo.filter(function (person) {
                    return person.LABEL.toLowerCase().indexOf(self.buscarFamilia.toLowerCase()) >= 0
                    || person.ID.toLowerCase().indexOf(self.buscarFamilia.toLowerCase()) >= 0;
                });
            },
            filteredCatalogoG4: function () {
                var self = this;
                return this.listaCatalogo.filter(function (person) {
                    return person.LABEL.toLowerCase().indexOf(self.buscarMaterial.toLowerCase()) >= 0
                    || person.ID.toLowerCase().indexOf(self.buscarMaterial.toLowerCase()) >= 0;
                });
            }
        },
        methods: {
            obtenerDistribuidor(data){
                console.log(data.idDistribuidor);
                let me=this;
                me.Bandera_Distribuidor_precargado = false;
                me.id_distribuidor={};
                me.id_Usuario = {};

                me.BanderaAxios = true;
                    axios.post('./buscarDistribuidores',{
                        id_oportunidad:data.id,
                    })
                    .then(function (response) {
                        // handle success
                        me.BanderaAxios = false;
                        me.listaDistribuidoresIusa = response.data.iusa;
                        me.listaDistribuidoresOtros = response.data.otros;              
                        if(me.listaDistribuidoresIusa.length != 0){                    
                           me.Bandera_Distribuidor_precargado = true;
                        } 
                        me.id_Usuario = data  
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        me.BanderaAxios = false;
                    });
            },
            obtenerDistribuidorProspecto(data){
                console.log(data.idDistribuidor);
                let me=this;
                me.Bandera_Distribuidor_precargado = false;
                me.id_distribuidor={};
                me.id_Usuario= {};
                 me.BanderaAxios = true;
                    axios.post('./buscarDistribuidores',{
                        id_oportunidad:data.id,
                    })
                    .then(function (response) {
                        // handle success
                        me.BanderaAxios = false;
                        me.listaDistribuidoresIusa = response.data.iusa;
                        me.listaDistribuidoresOtros = response.data.otros;                   
                        if(me.listaDistribuidoresIusa.length != 0){                    
                           me.Bandera_Distribuidor_precargado = true;
                        } 
                        me.id_Usuario = data  
                        //me.id_Usuario.id = data.id
                        //me.id_Usuario.Nombre = data.nombre
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        me.BanderaAxios = false;
                    });
                
            },
             buscarMaterialCarrito(){
               let me=this;
               let dato=[];
               me.bandera_repetido = 0;
               me.errorMaterial = null;
               if(me.codigo == '' || me.codigo == null){
                   me.errorMaterial = 'Codigo Vacios' 
               }else if(me.unidades == '' || me.unidades == null){
                    me.errorMaterial = 'Unidades Vacios' 
               }else{
                   for(i=0;i< me.listaCarrito.length;i++){
                       dato=me.listaCarrito[i];
                       if(dato.codigo_material == me.codigo){
                           me.bandera_repetido++;
                       }
                   }
                   if(me.bandera_repetido != 0){
                        me.errorMaterial = 'Material ya esta en el carrito'
                   }else{ 
                    me.BanderaAxios = true;
                    axios.post('./buscarMaterial',{
                        id_material: me.codigo,
                        num_unidades: me.unidades,
                        idCliente: "0000001068",
                        vendedor: "02542156",
                        puesto:"V"
                    })
                    .then(function (response) {
                        // handle success
                        me.BanderaAxios = false;
                        me.errorMaterial = response.data.mensaje_error                    
                        if(me.errorMaterial == ''){                    
                            me.listaCarrito.push(response.data.cadena_result)
                            me.codigo = null;
                            me.unidades = null;
                        }   
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        me.BanderaAxios = false;
                    });
                   }
                    
               }
               
            },
            eliminarItem (index, count){
                this.listaCarrito.splice(index, 1);
            },
            guardarOrden (){
                let me=this;
                if (me.Bandera_Distribuidor_precargado == false){
                    me.id_distribuidor.tipo = 'IUSA';
                }
                me.BanderaAxios = true;
                axios.post('./guardarOC',{
                    idUsuario: me.id_Usuario.id,
                    nombreUsuario: me.id_Usuario.nombre,
                    tipoDistribuidor: me.id_distribuidor.tipo,
                    idDistribuidor: me.id_distribuidor.KUNNR,
                    nombreDistribuidor: me.id_distribuidor.NAME1,
                    orden_compra: me.orden_compra,
                    tipo_orden: me.tipo_orden,
                    lista: me.listaCarrito
                })
                .then(function (response) {
                    // handle success
                    me.BanderaAxios = false;
                    me.listaCarrito = [];
                    me.id_Usuario = null;
                    me.id_distribuidor = '';
                    me.orden_compra = '';
                    me.tipo_orden = null;
                   // alert("Se a guardado la orden de compra")                    
                    swal("Generación Exitosa!", "Se a guardado la orden de compra", "success");                   
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    me.BanderaAxios = false;
                });
            },
            actualizarUnidades (lista){
                let me=this;
                let dato=[];
                let aux=0;
                let aux_2=0;
                if (lista.u_confirm <= 0 || lista.u_confirm == undefined || lista.u_confirm == 0) {
                    lista.u_confirm = 1;
                }
                aux = lista.u_confirm/lista.empaque;
                aux_2 = Math.ceil(aux);
                lista.u_confirm = aux_2*lista.empaque;

                for(i=0;i< me.listaCarrito.length;i++){
                    dato=me.listaCarrito[i];
                    if(dato.codigo_material == lista.codigo){
                        me.listaCarrito[i] = lista;
                    }
                }
            },
            sumarUnidades (lista){
                let me=this;
                let dato=[];
                let aux=0;
                let aux_2=0;
                let sumaU = 0;
                 let u_confirm = parseInt(lista.u_confirm);
                let empaque = parseInt(lista.empaque);
                //aumentar unidades 
                sumaU = u_confirm+empaque;
                if (sumaU <= 0 || sumaU == undefined || sumaU == 0) {
                    sumaU = 1;
                }
                aux = sumaU/lista.empaque;
                aux_2 = Math.ceil(aux);
                lista.u_confirm = aux_2*lista.empaque;

                for(i=0;i< me.listaCarrito.length;i++){
                    dato=me.listaCarrito[i];
                    if(dato.codigo_material == lista.codigo){
                        me.listaCarrito[i] = lista;
                    }
                }
            },
            restarUnidades (lista){
                let me=this;
                let dato=[];
                let aux=0;
                let aux_2=0;
                let sumaU = 0;
                 let u_confirm = parseInt(lista.u_confirm);
                let empaque = parseInt(lista.empaque);
                //aumentar unidades 
                sumaU = u_confirm-empaque;
                if (sumaU <= 0 || sumaU == undefined || sumaU == 0) {
                    sumaU = 1;
                }
                aux = sumaU/lista.empaque;
                aux_2 = Math.ceil(aux);
                lista.u_confirm = aux_2*lista.empaque;

                for(i=0;i< me.listaCarrito.length;i++){
                    dato=me.listaCarrito[i];
                    if(dato.codigo_material == lista.codigo){
                        me.listaCarrito[i] = lista;
                    }
                }
            },
            CatalogoGeneral(){
               let me=this;
                me.bandera_tabla=0;                
                me.buscarFamilia='';
                me.buscarMaterial='';
                me.gpo4=[]; 
                me.BanderaAxios = true;
                axios.post('./obtenerCatalogoPGC',{
                    gpom4: ''
                })
                .then(function (response) {
                    // handle success
                    console.log(response.data);
                    me.BanderaAxios = false;
                    me.listaCatalogo = response.data;  
                    me.listaCatalogo.pop();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    me.BanderaAxios = false;
                });

            },
            regresarTablaCatalogo(){
            this.bandera_tabla=0;
            this.CatalogoGeneral();
            },
            catalogoGPOM41(lista){
                let me=this;
                me.bandera_tabla=1;
                me.gpo4=lista;
                me.BanderaAxios = true;
                axios.post('./obtenerCatalogoPGC',{
                    gpom4: me.gpo4.ID
                })
                .then(function (response) {
                    // handle success
                    console.log(response.data);
                    me.BanderaAxios = false;
                    me.listaCatalogo = response.data;  
                    me.listaCatalogo.pop();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    me.BanderaAxios = false;
                });
            },
            catalogoGPOM41_Se(lista){
                let me= this;
                me.codigo = lista.ID
            }
        },
        watch: {
        distri_select: function(newRole)
        {
             let me=this;
             me.id_distribuidor={};
             if(me.distri_select.tipo == 'IUSA'){
                me.id_distribuidor = {
                    KUNNR:me.distri_select.idIusa,
                    NAME1:me.distri_select.nombre,
                    tipo:me.distri_select.tipo
                }
             }
             if(me.distri_select.tipo == 'Otro'){
                me.id_distribuidor = {
                    KUNNR:me.distri_select.id,
                    NAME1:me.distri_select.nombre,
                    tipo:me.distri_select.tipo
                }
             }
             
            console.log(me.id_distribuidor);
        }
        }
    }
</script>
