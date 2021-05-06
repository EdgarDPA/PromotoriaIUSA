<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="text-dark  header-title m-t-0 m-b-30">Directorio Estadístico Nacional de Unidades Económicas</h4>
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>NOMBRE</th>
                                <th>UBICACIÓN</th>
                                <th colspan="3">OPCIONES</th>
                                <!-- <th></th>
                                <th></th> -->
                            </tr>
                        </thead>
                        <tbody v-for="opportunity in opportunities" :key="opportunity.id">
                            <tr>
                                <td>{{opportunity.Nombre}}</td>
                                <td>{{opportunity.Ubicacion}}</td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Mapa"><a class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal" @click="GMaps(opportunity.Latitud, opportunity.Longitud, opportunity.Nombre, opportunity.Ubicacion)"><i class="fa fa-map-marker" style="color:#fff;font-size:18px;"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Encuesta"><a href="encuesta" class="btn btn-success waves-effect"><i class="fa fa-check-circle"></i></a></td>
                                <td class="text-center" data-toggle="tooltip" data-placement="left" title="Archivos"><a href="files_upload" class="btn btn-primary waves-effect"><i class="fa fa-file-import"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <!-- <div class="col-lg-12">
                <button type="button" class="btn btn-secondary" @click="enviodeOportunidad">guardar opportunities</button>
            </div>-->
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
                opportunities: [
                {
                Id_INEGI: "4614745",
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
                Id_INEGI: "8454371",
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
                Id_INEGI: "4646588",
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
                Id_INEGI: "4607675",
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
                Id_INEGI: "4600577",
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
                Id_INEGI: "4618789",
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
                Id_INEGI: "4620218",
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
                Id_INEGI: "4598952",
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
                Id_INEGI: "7824735",
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
                Id_INEGI: "4597511",
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
            console.log('OpportunityComponent')
        },
        methods: {
            GMaps(Latitud, Longitud, Nombre, Ubicacion){
                this.center = { lat: parseFloat(Latitud), lng: parseFloat(Longitud) }
                this.marker = { lat: parseFloat(Latitud), lng: parseFloat(Longitud) }
                this.nombre = Nombre;
                this.ubicacion = Ubicacion;
            },
            enviodeOportunidad(){
                let me=this;
               
                axios.post('./guardarOportunidad',{
                    lista: me.opportunities
                })
                .then(function (response) {
                    // handle success
                   alert("Se a guardado")                    
                                     
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);                   
                });
            }
        }
    }
</script>