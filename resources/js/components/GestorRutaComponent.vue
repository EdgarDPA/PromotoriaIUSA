<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="loader" v-if="BanderaAxios"></div>
                        <div class="col-md-6">
                            <div class="card-box">                    
                                <h6 class="font-size-standard">Numero de Rutas</h6>
                                <div class="widget-chart text-center">
                                    <select class="form-control" id="ListaRutas" name="ListaRutas"
                                    v-model="rutaSelect">
                                        <option disabled selected>Selecciona una Ruta</option>
                                        <option v-for="(ListaRutas, index) in ListaRutas" :key="index"
                                        :value="ListaRutas.numero_ruta">{{ ListaRutas.numero_ruta}}
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-success waves-effect" @click="buscarRuta()">Buscar Ruta</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-box">
                                <div id="mapa1" style="width: 100%; height: 300px">
                                </div>
                            </div>
                        </div>
                    </div><!-- fin row-->
                </div>
            </div>        
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'
import {gmapApi} from 'vue2-google-maps'

    Vue.use(VueGoogleMaps, {
        load: {
            key: "AIzaSyBwsTOgSJoyp56mJoj-zJAF80LC2DUDH7w",
            libraries: "places"
        }
    });

    Vue.component('google-map', VueGoogleMaps.Map);
    Vue.component('google-marker', VueGoogleMaps.Marker);
    export default {
        data(){
            return{
                BanderaAxios : false,
                rutaSelect: null,
                ListaRutas: [],
                infoRuta: [],
                registro_rutas :[],
                origen : "",
                destino  : "",
                coords : {},
                destination : {}
            }  
        },        
        mounted() {
            console.log('RutaComponent');
            this.buscarRutaLista();
        },
        methods: {
            buscarRutaLista(){
                let me=this;
                me.BanderaAxios = true;
                axios.post('./obtenerRutaLista',{
                    id_promotor: 1,
                })
                .then(function (response) {
                    // handle success
                    me.ListaRutas = response.data;             
                    me.BanderaAxios = false;
                
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
                    id_ruta: me.rutaSelect,
                })
                .then(function (response) {
                    // handle success
                    me.infoRuta = response.data.registro_gps;             
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
                var directionsDisplay = new google.maps.DirectionsRenderer()
                
                directionsDisplay.addListener('directions_changed', function() {
                    //computeTotalDistance(directionsDisplay.getDirections());
                })


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
                
                console.log(this.coords)
                console.log(this.destination)
                console.log(this.registro_rutas)
                console.log('hmmm yha')
                calculateAndDisplayRoute(directionsService, directionsDisplay, this.coords, this.destination,this.registro_rutas)
                })
            }
        }
    }
</script>