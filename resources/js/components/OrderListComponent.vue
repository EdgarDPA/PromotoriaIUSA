<template>
<div class="col-lg-12">
    <div class="card-box">
        <h4 class="text-dark  header-title m-t-0 m-b-30"><i class="fa fa-file-text-o" aria-hidden="true"></i> Seguimiento de Pedidos Sugeridos</h4>
        <div class="loader" v-if="BanderaAxios"></div>
        <table class="table table-sm ">
            <thead class="thead-dark">
                <tr>
                    <th>FOLIO</th>                    
                    <th>FECHA</th>
                    <th>TIPO</th>
                    <th>NOMBRE</th>
                    <th>DISTRIBUIDOR</th>
                    <th>ORDEN DE COMPRA</th>
                    <th>ESTATUS</th>
                    <th colspan="3">OPCIONES</th>
                    <!-- <th></th>
                    <th></th> -->
                </tr>
            </thead>
            <tbody v-for="orden in orders" :key="orden.id" class="table-striped">
                <tr>
                    <td>{{orden.folio}}</td>                    
                    <td>{{orden.fecha}} - {{orden.hora}}</td>
                    <td>
                        <strong class="text-success"  v-if="orden.tipoUsuario == 1">Oportunidad</strong>
                        <strong class="text-warning"  v-if="orden.tipoUsuario == 2">Prospecto</strong>
                    </td>
                    <td>{{orden.nombreUsuario}}</td>
                    <td>{{orden.nombreDistribuidor}}</td>
                    <td>{{orden.orden_compra}}</td>
                    <td>                        
                            <strong class="text-warning"  v-if="orden.estatus == 'Pendiente'">{{orden.estatus}}</strong>
                            <strong class="text-primary"  v-if="orden.estatus == 'Enviado'">{{orden.estatus}}</strong>  
                    </td>
                    <td class="text-center" data-toggle="tooltip" data-placement="left" title="Detalle"><a class="btn btn-primary waves-effect" data-toggle="modal" data-target="#exampleModal" @click="detalleOrden(orden)"><i class="fa fa-search" style="color:#fff;font-size:18px;"></i></a></td>
                     <td class="text-center" data-toggle="tooltip" data-placement="left" title="Enviar"><a class="btn btn-success waves-effect" data-toggle="modal" data-target="#envioOrden" @click="cargarDistribuidor(orden)"><i class="fa fa-paper-plane" style="color:#fff;font-size:18px;"></i></a></td>
                    
                </tr>
            </tbody>
        </table>
    </div>
            
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-search" style="font-size:18px;"></i> Folio: {{nombre}}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>UNIDADES</th>
                        </tr>
                    </thead>
                    <tbody v-for="ordenDeta in ordenDetalle" :key="ordenDeta.id">
                        <tr>
                            <td>{{ordenDeta.codigo_material}}</td>
                            <td>{{ordenDeta.nombre_material}}</td>
                            <td>{{ordenDeta.unidades_confirmadas}}</td>                                    
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="envioOrden" tabindex="-1" role="dialog" aria-labelledby="envioOrdenLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="envioOrdenLabel">Enviar Orden por Email</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Correo electrónico</label>
                <br>
                <input type="text" class="form-control" v-model="emailEnvio">
                <br>
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="enviarOrden()">Enviar correo</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</div>  
</template>
<style>
    td {
        padding: 15px;
        text-align: left;
        font-size: 14px;
    }
    th{
        padding: 15px;
        text-align: center;
        font-size: 10px;
    }
    tr:hover {background-color: #f5f5f5;}
</style>
<script>
    import Vue from 'vue'    
    import axios from 'axios'  


    export default {
        data(){
            return{                
                orders: [],
                nombre: '',
                ordenDetalle: [],
                BanderaAxios: false,
                emailEnvio:'',
                idOrden:''
            }  
        },
        mounted() {
            this.cargarOrdenes()
        },
        methods: {            
            cargarOrdenes (){
                let me=this;
                me.BanderaAxios = true;            
                axios.post('./obtenerOC',{
                    id: '1',
                })
                .then(function (response) {
                    // handle success             
                    me.BanderaAxios = false;                  
                    me.orders = response.data;                   
                })
                .catch(function (error) {
                    // handle error
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            detalleOrden (lista){
                let me=this;
                me.nombre= lista.folio;
                me.ordenDetalle = []; 
                me.BanderaAxios = true;            
                axios.post('./obtenerDetalleOC',{
                    id: lista.id,
                })
                .then(function (response) {
                    // handle success             
                    me.BanderaAxios = false;                
                    me.ordenDetalle = response.data                   
                })
                .catch(function (error) {
                    // handle error
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            cargarDistribuidor (lista){
                console.log(lista);
                let me=this;
                me.emailEnvio = '';
                me.idOrden = lista.id
                me.BanderaAxios = true;            
                axios.post('./cargarCorreoDistribuidor',{
                    id: lista.idDistribuidor,
                    tipo: lista.tipoDistribuidor,
                })
                .then(function (response) {
                    // handle success             
                    me.BanderaAxios = false;                
                    me.emailEnvio = response.data;              
                })
                .catch(function (error) {
                    // handle error
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            enviarOrden (){
                let me=this;
                me.BanderaAxios = true;            
                axios.post('./enviarDetalleOC',{
                    id: me.idOrden,
                    correo: me.emailEnvio
                })
                .then(function (response) {
                    // handle success             
                    me.BanderaAxios = false;   
                    alert(response.data);            
                    me.cargarOrdenes();               
                })
                .catch(function (error) {
                    // handle error
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            }
        }
    }
</script>