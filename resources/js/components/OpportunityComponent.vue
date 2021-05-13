<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="!bandera_convertir">
                <div class="card-box">
                    <div class="loader" v-if="BanderaAxios"></div>
                    <h4 class="text-dark  header-title m-t-0 m-b-30">Directorio Estadístico Nacional de Unidades Económicas</h4>
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>NOMBRE</th>
                                <th>UBICACIÓN</th>
                                <th colspan="4">OPCIONES</th>
                                <!-- <th></th>
                                <th></th> -->
                            </tr>
                        </thead>
                        <tbody v-for="opportunity in opportunities" :key="opportunity.id">
                            <tr>
                                <td>{{opportunity.Nombre}}</td>
                                <td>{{opportunity.Ubicacion}}</td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Mapa"><a class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal" @click="GMaps(opportunity.Latitud, opportunity.Longitud, opportunity.Nombre, opportunity.Ubicacion)"><i class="fa fa-map-marker" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Encuesta" v-if="opportunity.bandera_prospecto != 1"><a href="encuesta" class="btn btn-success waves-effect"><i class="fa fa-check-circle"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Convertir Prospecto" v-if="opportunity.bandera_prospecto != 1"><a class="btn btn-warning waves-effect" @click="obtenerFormulario(opportunity)"><i class="fa fa-hand-peace-o" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Archivos" v-if="opportunity.bandera_prospecto != 1"><a href="files_upload" class="btn btn-primary waves-effect"><i class="fa fa-file-import"></i></a></td>                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <div class="col-md-12" v-if="bandera_convertir"> 
                <div class="card-box">                
                 <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>
                 
                <encuesta-prospecto-component 
                :preNombre="oportunidadSelect.Nombre"
                :preUbicacion="oportunidadSelect.Ubicacion"
                :preId="oportunidadSelect.id"
                :preIdDistribuidor="oportunidadSelect.idDistribuidor"
                :preNombreDistribuidor="oportunidadSelect.nombreDistribuidor"
                :preLatitud="oportunidadSelect.Latitud"
                :preLongitud="oportunidadSelect.Longitud"
                @Volver="volverFormulario()">
                </encuesta-prospecto-component>
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
                bandera_convertir: false,
                oportunidadSelect:[],
                BanderaAxios : false
            }  
        },
        mounted() {
            console.log('OpportunityComponent')
            this.cargarOportunidad()
        },
        methods: {
            GMaps(Latitud, Longitud, Nombre, Ubicacion){
                this.center = { lat: parseFloat(Latitud), lng: parseFloat(Longitud) }
                this.marker = { lat: parseFloat(Latitud), lng: parseFloat(Longitud) }
                this.nombre = Nombre;
                this.ubicacion = Ubicacion;
            },
            cargarOportunidad (){
                let me=this;
                me.BanderaAxios = true;
                axios.post('./obtenerOportunidades',{
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
                me.bandera_convertir=true;
                me.oportunidadSelect = datos
            },
            volverFormulario(){
                 let me= this;
                me.bandera_convertir=false;
                me.cargarOportunidad()
            }
        }
    }
</script>