<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="loader" v-if="BanderaAxios"></div>
                    <input type="file" name="inegi" @change="getArchivo" class="form-control">
                    <p></p>
                    <span><label>Carga el archivo ejemplo (formato: .csv) |</label><a target="_self"
                    v-bind:href="'documentacion/ejemplo_oportunidad.csv'"> Ejemplo clic aquí</a></span>
                    <p></p>
                    <button class="btn btn-success waves-effect" @click="enviarArchivo()">Aceptar</button>
                </div>
            </div>          
            
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                BanderaAxios : false,
                archivo: null
            }  
        },
        mounted() {
            console.log('SubirCSVComponent')
        },
        methods: {
            getArchivo(event){
                //Asignamos la imagen a  nuestra data
                this.archivo = event.target.files[0];
            },
            enviarArchivo(){
                let me=this;
                me.BanderaAxios = true;
                var data = new  FormData();
                data.append('csv', this.archivo);
                axios.post('./subirCSVOportunidad',data)
                .then(function (response) {
                    // handle success             
                 me.BanderaAxios = false;
                 swal(response.data, "Se a guardado las oportunidades", "success");                                  
                })
                .catch(function (error) {
                    me.BanderaAxios = false;
                    console.log(error);              
                });
            }
        }
    }
</script>