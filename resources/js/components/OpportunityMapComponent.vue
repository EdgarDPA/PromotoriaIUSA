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
                opportunities: [
                {
                Id: "4614745",
                Nombre: "BICI PARTES Y TLAPALERIA CASANOVA",
                Razon_social: "",
                Clase_actividad: "Reparación y mantenimiento de bicicletas",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "AVENIDA",
                Calle: "MARAVILLAS",
                Num_Exterior: "116",
                Num_Interior: "",
                Colonia: "LOS FRESNOS",
                CP: "99050",
                Ubicacion: "FRESNILLO, Fresnillo, ZACATECAS",
                Telefono: "4939353305",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.85674086",
                Latitud: "23.18486808",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "8454371",
                Nombre: "BODEGA AUXILIAR DE FERRETERIA Y TLAPALERIA",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "JOSEFA ORTIZ DE DOMINGUEZ",
                Num_Exterior: "",
                Num_Interior: "",
                Colonia: "SANTA MARIA DE LA PAZ",
                CP: "99820",
                Ubicacion: "SANTA MARÍA DE LA PAZ, Santa María de la Paz, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-103.40975817",
                Latitud: "21.51327514",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4646588",
                Nombre: "FERRETERIA Y TLAPALERIA GUERRERO",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "AVENIDA",
                Calle: "5 DE MAYO",
                Num_Exterior: "41",
                Num_Interior: "",
                Colonia: "LA VICTORIA",
                CP: "98614",
                Ubicacion: "GUADALUPE, Guadalupe, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.52011882",
                Latitud: "22.75408691",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4607675",
                Nombre: "FERRETERIA Y TLAPALERIA IMELDA",
                Razon_social: "",
                Clase_actividad: "Comercio al por mayor de productos químicos para la industria farmacéutica y para otro uso industrial",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "FRANCISCO VILLA",
                Num_Exterior: "39",
                Num_Interior: "",
                Colonia: "LAS LOMITAS",
                CP: "99700",
                Ubicacion: "TLALTENANGO DE SÁNCHEZ ROMÁN, Tlaltenango de Sánchez Román, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-103.30457098",
                Latitud: "21.76933969",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4600577",
                Nombre: "FERRETERIA Y TLAPALERIA LA ALIANZA",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "ABASOLO",
                Num_Exterior: "",
                Num_Interior: "",
                Colonia: "CENTRO",
                CP: "98100",
                Ubicacion: "MORELOS, Morelos, ZACATECAS",
                Telefono: "4929310318",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.60906297",
                Latitud: "22.86275289",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4618789",
                Nombre: "FERRETERÍA Y TLAPALERÍA LIRA",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "JESUS ARECHIGA",
                Num_Exterior: "0",
                Num_Interior: "0",
                Colonia: "MELCHOR OCAMPO",
                CP: "98220",
                Ubicacion: "MELCHOR OCAMPO, Melchor Ocampo, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-101.64092423",
                Latitud: "24.83048730",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4620218",
                Nombre: "TLAPALERIA DON GOYO",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor de vidrios y espejos",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "GENERAL GONZALEZ ORTEGA NORTE",
                Num_Exterior: "308",
                Num_Interior: "0",
                Colonia: "CENTRO",
                CP: "98500",
                Ubicacion: "VÍCTOR ROSALES, Calera, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.70722028",
                Latitud: "22.95011856",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4598952",
                Nombre: "TLAPALERIA DON GOYO",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "PROFESOR JOSE REYES PONIENTE",
                Num_Exterior: "300",
                Num_Interior: "0",
                Colonia: "AÑO DE JUAREZ",
                CP: "98500",
                Ubicacion: "VÍCTOR ROSALES, Calera, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.70757860",
                Latitud: "22.95023683",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "7824735",
                Nombre: "TLAPALERIA MURILLO",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "CALLE",
                Calle: "SAN MARTIN",
                Num_Exterior: "20",
                Num_Interior: "0",
                Colonia: "TADEO",
                CP: "99500",
                Ubicacion: "VILLANUEVA, Villanueva, ZACATECAS",
                Telefono: "",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.87004153",
                Latitud: "22.35692382",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                },
                {
                Id: "4597511",
                Nombre: "TLAPALERIA RUIZ",
                Razon_social: "",
                Clase_actividad: "Comercio al por menor en ferreterías y tlapalerías",
                Estrato: "0 a 5 personas",
                Tipo_vialidad: "AVENIDA",
                Calle: "HIDALGO",
                Num_Exterior: "33",
                Num_Interior: "",
                Colonia: "CAÑITAS DE FELIPE PESCADOR",
                CP: "98480",
                Ubicacion: "CAÑITAS DE FELIPE PESCADOR, Cañitas de Felipe Pescador, ZACATECAS",
                Telefono: "4589370188",
                Correo_e: "",
                Sitio_internet: "",
                Tipo: "Fijo",
                Longitud: "-102.7265896",
                Latitud: "23.6053604",
                tipo_corredor_industrial: "",
                nom_corredor_industrial: "",
                numero_local: ""
                }
                ]
            }  
        },
        mounted() {
            this.data = this.opportunities;
            let total = this.data.length;
            for(let i = 0; i < total; i++){
                this.markers.push({'lat': parseFloat(this.data[i].Latitud), 'lng': parseFloat(this.data[i].Longitud), 'name': this.data[i].Nombre, 'ubicacion': this.data[i].Ubicacion, 'telefono': this.data[i].Telefono});
            }
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