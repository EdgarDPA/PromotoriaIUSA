<template>
    <div v-if="mapa">
    <div class="row" style="margin-bottom:5px;margin-left:0px;">
        <div>
            <button class="btn btn-primary" @click="mapa=false"><i class="fa fa-chart-area"></i></button>
        </div>
    </div>
    <GmapMap
    :center="center"
    :zoom="zoom"
    style="width: auto; height: 500px"
    >
    <GmapMarker
    :key="key"
    v-for="(marker, key) in markers"                                           
    :position="marker"
    :icon="markerOptions"
    :clickable="true"
    :draggable="false"
    :animation=2
    @click="getInfo(marker, key)"
    />
    <GmapInfoWindow 
    @closeclick="window_open=false"
    :opened="window_open" 
    :position="infowindow"
    :options="{
        pixelOffset: {
        width: 0,
        height: -35
        }
    }"
    >
    <span style="font-weight:bolder;color:#000;"> <b>{{name}}</b></span><br>
    <span>{{ubicacion}}</span><br>
    <span>{{telefono}}</span><br>
    </GmapInfoWindow>
    </GmapMap>
    </div>
    <div v-else>
        <div class="row" style="margin-bottom:5px;margin-left:0px;">
            <button class="btn btn-danger" @click="mapa=true"><i class="fa fa-map-marked-alt"></i></button>
        </div>
        <fusion-chart-component></fusion-chart-component>
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

    const mapMarker = require('../../../public/placeholder.svg');

    export default {
        data(){
            return{
                mapa: true,
                markerOptions: {
                labelOrigin: { x: 45, y: 15},
                url: mapMarker,
                size: {width: 45, height: 45, f: 'px', b: 'px',},
                scaledSize: {width: 45, height: 45, f: 'px', b: 'px',},
                },
                data: null,
                markers:[],
                window_open: false,
                infowindow: null,
                name:null,
                ubicacion:null,
                telefono:null,
                zoom: 7,
                center: { lat: 22.7709, lng: -102.583 },
                opportunities: []
            }  
        },
        mounted() {
            let me=this;
            axios.post('./obtenerOportunidades',{
                id: '1',
            })
            .then(function (response) {
                // handle success                           
            me.opportunities = response.data 
            me.data = me.opportunities;
            let total = me.data.length;
            for(let i = 0; i < total; i++){
                me.markers.push({'lat': parseFloat(me.data[i].Latitud), 'lng': parseFloat(me.data[i].Longitud), 'name': me.data[i].Nombre, 'ubicacion': me.data[i].Ubicacion, 'telefono': me.data[i].Telefono});
            }                  
            })
            .catch(function (error) {
                console.log(error);              
            });            
        },
        methods: {
            async getInfo(marker, key){
            this.center = { lat: marker.lat, lng: marker.lng }
            this.name = marker.name;
            this.ubicacion = marker.ubicacion;
            this.telefono = marker.telefono;
            this.infowindow = this.center;
            this.window_open = true;
            this.selectedKey = key;
        },
        }
    }
</script>