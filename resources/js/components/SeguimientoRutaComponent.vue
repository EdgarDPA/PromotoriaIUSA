<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="!ocultar_tabla">
                <div class="card-box">
                    <div class="loader" v-if="BanderaAxios"></div>                    
                        <h3 class="text-dark text-center header-title m-t-0 m-b-30">Ruta {{idRuta.numero_ruta}} Iniciada</h3>
                        <button type="button" class="btn btn-warning" @click="pausarRuta()">Pausar Ruta</button>                    
                    <div id="mapa1" style="width: 100%; height: 300px"></div>    
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th style="text-align:left;font-size:12px;">ID</th>
                                <th style="text-align:left;font-size:12px;">NOMBRE</th>
                                <th style="text-align:left;font-size:12px;">UBICACIÓN</th>
                                <th style="text-align:left;font-size:12px;" colspan="4">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody v-for="opportunity in opportunities" :key="opportunity.id">
                            <tr v-bind:class="{ realizado: opportunity.bandera_encuesta == 1, cancelado: opportunity.bandera_cancelada == 1 }">
                                <td>{{opportunity.ruta_id}}</td>
                                <td>{{opportunity.nombre}}</td>
                                <td>{{opportunity.direccion}}</td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Mapa"><a class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal" @click="GMaps(opportunity.latitud, opportunity.longitud, opportunity.nombre, opportunity.direccion)"><i class="fa fa-map-marker" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Encuesta" v-show="opportunity.bandera_encuesta != 1 && opportunity.bandera_cancelada != 1"><a class="btn btn-success waves-effect" @click="obtenerEncuesta(opportunity)" ><i class="fa fa-check-circle" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Ver Distriuidores" v-show="opportunity.bandera_encuesta == 1 && opportunity.bandera_cancelada != 1"><a class="btn waves-effect" style="background:#ff5f3d;" @click="obtenerDetalleEncuesta(opportunity)" ><i class="fa fa-search" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Reportar Oportunidad" v-show="opportunity.bandera_encuesta != 1 && opportunity.bandera_cancelada != 1"><a class="btn btn-warning waves-effect" @click="obtenerFormulario(opportunity)"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Archivos" v-show="opportunity.bandera_cancelada != 1"><a href="files_upload" class="btn btn-primary waves-effect"><i class="fa fa-file-import"></i></a></td> 
                                <td class="text-center" v-show="opportunity.bandera_encuesta == 1"></td>
                                <td class="text-center" colspan="4" v-show="opportunity.bandera_cancelada == 1"></td>                           
                            </tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
           <div class="col-md-12" v-if="bandera_convertir"> 
                <div class="card-box">                
                 <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>
                 <br>
                <baja-oportunidad-component 
                :preNombre="oportunidadSelect.nombre"                
                :preId="oportunidadSelect.id"                
                @Volver="volverFormulario()">
                </baja-oportunidad-component>
                </div>
            </div>
            <div class="col-md-12" v-if="bandera_encuesta"> 
                <div class="card-box">
                    <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>                    
                    <encuesta-component 
                    :idOportunidad="oportunidadSelect.id"
                    :preNombre="oportunidadSelect.nombre"
                    @Volver="volverFormulario()"></encuesta-component>                            
                </div>
            </div>
            <div class="col-md-12" v-if="bandera_detalle_encuesta"> 
                <div class="card-box">
                    <button type="button" class="btn btn-primary" @click="volverFormulario()">Volver a lista</button>                    
                    <encuesta-detalle-component 
                    :idOportunidad="oportunidadSelect.id"
                    :preNombre="oportunidadSelect.nombre"
                    @Volver="volverFormulario()"></encuesta-detalle-component>                            
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
<style>
.realizado{
    background:#86c7a1;
}
.cancelado{
    background:#ee4242;
}
</style>
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
                bandera_detalle_encuesta: false,
                oportunidadSelect:[],
                BanderaAxios : false,
                idRuta:''
            }  
        },
        created() {
            console.log('OpportunityComponent')
            this.buscarRutaInicio()
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
            buscarRutaInicio(){
                let me=this;
                me.BanderaAxios = true;
                axios.post('./buscarRutaIniciada',{
                    id: 1,
                })
                .then(function (response) {
                    // handle success             
                 me.BanderaAxios = false;
                 me.idRuta = response.data;  
                 me.buscarRuta();                               
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            buscarRuta(){
                let me=this;               
                me.BanderaAxios = true;
                axios.post('./obtenerRuta',{
                    id_ruta: me.idRuta.numero_ruta,
                })
                .then(function (response) {
                    // handle success
                    me.opportunities = response.data.registro_gps;             
                    me.BanderaAxios = false;
                    me.registro_rutas = response.data.registro_rutas
                    me.origen = response.data.origen
                    me.destino = response.data.destino

                    var origenG_Parts = me.origen.split(",")
                    me.coords = {
                    lat: parseFloat(origenG_Parts[0]),
                    lng: parseFloat(origenG_Parts[1])
                    }

                    var destinoG_Parts = me.destino.split(",")
                    me.destination = {
                    lat: parseFloat(destinoG_Parts[0]),
                    lng: parseFloat(destinoG_Parts[1])
                    }
                    
                    me.formarRuta1();

                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            formarRuta1 () {
                this.$gmapApiPromiseLazy().then(() => { var bounds = new google.maps.LatLngBounds() /* etc */ 
                var directionsService = new google.maps.DirectionsService()
                var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true})

                this.map = new google.maps.Map(document.getElementById('mapa1'), {
                    center: this.destinationG,
                    scrollwheel: false,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    })
                    console.log('llego aqui al mapa manual');
                directionsDisplay.setMap(this.map)

                //google maps API's direction service
                function calculateAndDisplayRoute(directionsService, directionsDisplay, start, destination,waypoints) {
                directionsService.route({
                    origin: start,
                    destination: destination,
                    waypoints: waypoints,
                    travelMode: 'DRIVING'
                }, function(response, status) {
                    if (status === 'OK') {
                    console.log(response)            
                    directionsDisplay.setDirections(response)                               
                    } else {
                    
                    }
                });
                }

                 function ponerMarcadores(infoRuta,map){
                   const infoWindow = new google.maps.InfoWindow();
                     for (let i = 0; i < infoRuta.length; i++) {
                        const ruta = infoRuta[i];
                    
                        if(ruta.bandera_encuesta == 1){
                            const marker = new google.maps.Marker({
                            position: { lat: parseFloat(ruta.latitud), lng: parseFloat(ruta.longitud)},
                            map: map,
                            title: ruta.nombre,
                            label: {text: ruta.orden_ruta, color: "black"},
                            icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                            }
                            });
                            //agregar click listener
                            marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(marker.getTitle());
                            infoWindow.open(marker.getMap(), marker);
                            });
                        }else{
                            const marker = new google.maps.Marker({
                            position: { lat: parseFloat(ruta.latitud), lng: parseFloat(ruta.longitud)},
                            map: map,
                            title: ruta.nombre,
                            label: {text: ruta.orden_ruta, color: "white"},
                            });
                            //agregar click listener
                            marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(marker.getTitle());
                            infoWindow.open(marker.getMap(), marker);
                            });
                        }
                    }
                 }
                
                console.log(this.coords)
                console.log(this.destination)
                console.log(this.registro_rutas)
                console.log('hmmm yha')
                calculateAndDisplayRoute(directionsService, directionsDisplay, this.coords, this.destination,this.registro_rutas)
                ponerMarcadores(this.opportunities,this.map) 
                })
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
            obtenerDetalleEncuesta(datos){
                let me= this;
                me.ocultar_tabla=true;
                me.bandera_detalle_encuesta=true;
                me.oportunidadSelect = datos
            },
            volverFormulario(){
                 let me= this;
                 me.ocultar_tabla=false;
                me.bandera_convertir=false;
                me.bandera_encuesta=false;
                me.bandera_detalle_encuesta = false;
                me.buscarRuta()
            },
            pausarRuta(){
                let me= this;
                me.BanderaAxios = true;
                axios.post('./pausarRuta',{
                    id_ruta: me.idRuta.id,
                })
                .then(function (response) {
                    // handle success            
                    me.BanderaAxios = false;
                    me.$emit('Volver','ok');
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
                
            }
        }
    }
</script>