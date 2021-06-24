<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="!banderaRutaIniciada">
                <div class="card-box">
                    <div class="row">
                        <div class="loader" v-if="BanderaAxios"></div>
                        <div class="col-md-4"> 

                            <div class="table-responsive" style="width: auto;height: 400px;" v-if="infoRuta.length == 0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Rutas</th>
                                        </tr>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Estatus</th>
                                        <th scope="col" colspan="2">Opciones</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ListaRutas, index) in ListaRutas" :key="index">
                                            <th scope="row">{{ ListaRutas.numero_ruta}}</th>
                                            <td>{{ ListaRutas.estatus}}</td>
                                            <td class="align-middle" title="Ver Mapa"><i class="fa fa-location-arrow" aria-hidden="true" @click="buscarRuta(ListaRutas.numero_ruta)" ></i></td>
                                            <td class="align-middle" title="Iniciar Ruta"><i class="fa fa-play-circle" aria-hidden="true" @click="iniciarRuta(ListaRutas)" ></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive" style="width: auto;height: 400px;" v-if="infoRuta.length != 0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <button class="btn btn-danger waves-effect" @click="borrarInfoRuta()">
                                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                                </button>
                                            </th>
                                            <th>Detalle Ruta {{rutaSelect}}</th>
                                        </tr>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Oportunidad</th>                                                                                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(infoRuta, index) in infoRuta" :key="index">
                                            <th scope="row">{{ infoRuta.ruta_id}}</th>
                                            <td @click="selecionarMarcador(infoRuta)">{{ infoRuta.nombre}}</td>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                                                        
                        </div>

                        <div class="col-md-8">
                            <h4>Ruta {{rutaSelect}}</h4>
                                <div id="mapa1" style="width: 100%; height: 300px">
                                
                            </div>
                        </div>
                    </div><!-- fin row-->
                </div><!-- fin card rutas -->                
            </div><!-- fin col-lg-12 -->

            <div class="col-md-12" v-if="banderaRutaIniciada">                
                <seguimiento-ruta-component
                v-if="id_ruta_iniciada"
                @Volver="volverGestor()">
                </seguimiento-ruta-component>              
            </div><!-- fin col-lg-12 -->

        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'

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
                destination : {},
                banderaRutaIniciada : false,
                id_ruta_iniciada : null
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
                    for (let i = 0; i < me.ListaRutas.length; i++) {
                        const ruta = me.ListaRutas[i];
                        if(ruta.estatus == 'En proceso'){
                           me.banderaRutaIniciada = true;
                            me.id_ruta_iniciada = ruta; 
                        }
                    }
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            borrarInfoRuta(){
                let me=this;
                me.infoRuta = [];
            },
            buscarRuta(id){
                let me=this;
                me.rutaSelect = id;
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
                ponerMarcadores(this.infoRuta,this.map) 
                })
            },
            selecionarMarcador(infoRuta){
                console.log(infoRuta);

                this.coords = {
                    lat: parseFloat(infoRuta.latitud),
                    lng: parseFloat(infoRuta.longitud)
                    }
                    this.map.setZoom(19);
                    this.map.setCenter(this.coords);
            },
            iniciarRuta(rutaSelec){
                let me=this;
                me.banderaRutaIniciada = true;
                me.BanderaAxios = true;
                axios.post('./iniciarRuta',{
                    id_ruta: rutaSelec.id,
                })
                .then(function (response) {
                    // handle success            
                    me.BanderaAxios = false;
                    me.banderaRutaIniciada = true;
                    me.id_ruta_iniciada = rutaSelec;
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            },
            volverGestor(){
                let me=this;
                me.banderaRutaIniciada = false;
                me.id_ruta_iniciada = null; 
                me.buscarRutaLista();
            }
        }
    }
</script>