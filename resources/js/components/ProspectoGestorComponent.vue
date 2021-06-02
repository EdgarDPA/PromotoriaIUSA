<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="!ocultar_tabla">
                <div class="card-box">
                    <div class="loader" v-if="BanderaAxios"></div>
                    <h4 class="text-dark  header-title m-t-0 m-b-30">Prospectos </h4>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th style="text-align:left;font-size:12px;">NOMBRE</th>
                                <th style="text-align:left;font-size:12px;">UBICACIÓN</th>
                                <th style="text-align:left;font-size:12px;" colspan="4">OPCIONES</th>
                                <!-- <th></th>
                                <th></th> -->
                            </tr>
                        </thead>
                        <tbody v-for="opportunity in opportunities" :key="opportunity.id">
                            <tr>
                                <td>{{opportunity.nombre}}</td>
                                <td>{{opportunity.direccion}}</td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Mapa"><a class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal" @click="GMaps(opportunity.latitud, opportunity.longitud, opportunity.nombre, opportunity.direccion)"><i class="fa fa-map-marker" style="color:#fff;font-size:18px;"></i></a></td>
                                <!--<td class="text-center" data-toggle="tooltip" data-placement="left" title="Encuesta" v-if="opportunity.bandera_prospecto != 1"><a class="btn btn-success waves-effect" @click="obtenerEncuesta(opportunity)" ><i class="fa fa-check-circle" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Convertir Prospecto" v-if="opportunity.bandera_prospecto != 1"><a class="btn btn-warning waves-effect" @click="obtenerFormulario(opportunity)"><i class="fa fa-hand-peace-o" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Archivos" v-if="opportunity.bandera_prospecto != 1"><a href="files_upload" class="btn btn-primary waves-effect"><i class="fa fa-file-import"></i></a></td> -->                              
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <div class="col-md-12" v-if="bandera_convertir"> 
                <div class="card-box">                
                 <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>
                 <br>
                <encuesta-prospecto-component 
                :preNombre="oportunidadSelect.nombre"
                :preUbicacion="oportunidadSelect.direccion"
                :preId="oportunidadSelect.id"
                :preIdDistribuidor="oportunidadSelect.idDistribuidor"
                :preNombreDistribuidor="oportunidadSelect.nombreDistribuidor"
                :preLatitud="oportunidadSelect.latitud"
                :preLongitud="oportunidadSelect.longitud"
                @Volver="volverFormulario()">
                </encuesta-prospecto-component>
                </div>
            </div>
            <div class="col-md-12" v-if="bandera_encuesta"> 
                <div class="card-box">
                    <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>
                    <div class="row">  
                        <div class="col-lg-12">                            
                            <h4 class="text-dark  header-title m-t-0 m-b-30">ENCUESTA</h4>
                            <div id="app">
                                <encuesta-component 
                                :idOportunidad="oportunidadSelect.id"
                                :preNombre="oportunidadSelect.nombre"
                                @Volver="volverFormulario()"></encuesta-component>
                            </div>                            
                        </div>           
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">{{nombre}}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <GmapMap
                        :center="center"
                        :zoom="17"
                        style="width: 100%; height: 300px"
                        >
                        <GmapMarker                                           
                        :position="marker"
                        :icon="markerOptions"
                        :draggable="false"
                        />
                        </GmapMap>
                        <p></p>
                        <p style="font-size:14px;">{{ubicacion}}</p>
                 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import * as VueGoogleMaps from 'vue2-google-maps'
    import axios from 'axios'   
    Vue.use(VueGoogleMaps, {
        load: {
            key: "AIzaSyBwsTOgSJoyp56mJoj-zJAF80LC2DUDH7w",
            libraries: "places"
        }
    });

    const mapMarker = require('../../../public/placeholder.svg');

    export default {
        data(){
            return{
                markerOptions: {
                labelOrigin: { x: 45, y: 15},
                url: mapMarker,
                size: {width: 45, height: 45, f: 'px', b: 'px',},
                scaledSize: {width: 45, height: 45, f: 'px', b: 'px',},
                },
                ubicacion:null,
                nombre: null,
                marker: {},
                center: { lat: 19.4243408, lng: -99.1774841 },
                opportunities: [],
                ocultar_tabla: false,
                bandera_convertir: false,
                bandera_encuesta: false,
                oportunidadSelect:[],
                BanderaAxios : false
            }  
        },
        mounted() {
            console.log('OpportunityComponent')
            this.cargarOportunidad()
        },
        methods: {
            GMaps(latitud, longitud, nombre, direccion){
                this.center = { lat: parseFloat(latitud), lng: parseFloat(longitud) }
                this.marker = { lat: parseFloat(latitud), lng: parseFloat(longitud) }
                this.nombre = nombre;
                this.ubicacion = direccion;
            },
            guardarOportunidad (){
                let me=this;
                me.BanderaAxios = true;
                axios.post('./guardarOportunidad',{
                    lista: me.opportunities,
                })
                .then(function (response) {
                    // handle success             
                 me.BanderaAxios = false;                                 
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            cargarOportunidad (){
                let me=this;
                me.BanderaAxios = true;
                axios.post('./obtenerProspectos',{
                    id: '1',
                })
                .then(function (response) {
                    // handle success             
                 me.BanderaAxios = false;                 
                me.opportunities = response.data                   
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            obtenerFormulario(datos){
                let me= this;
                me.ocultar_tabla=true;
                me.bandera_convertir=true;
                me.oportunidadSelect = datos
            },
            obtenerEncuesta(datos){
                let me= this;
                me.ocultar_tabla=true;
                me.bandera_encuesta=true;
                me.oportunidadSelect = datos
            },
            volverFormulario(){
                 let me= this;
                 me.ocultar_tabla=false;
                me.bandera_convertir=false;
                me.bandera_encuesta=false;
                me.cargarOportunidad()
            }
        }
    }
</script>