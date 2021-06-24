<template>
    <div>
                <div class="loader" v-if="BanderaAxios">Cargando ..</div>            
                <div class="col-lg-12" v-if="!ocultarMenu">
                  <div class="card-box">
                    <div class="row">
                      <button id="show-modal" @click="abrirCrearCita()" class="btn ntn-lg btn-success text-white"><i class="fa fa-plus"></i> Agregar cita</button>
                      &nbsp;
                      <a class="btn btn-primary text-white" href="#!/clientesProspectos">
                        <i class="ti-user"></i><span>Prospectos</span>
                      </a>
                    </div>
                  </div>               
                </div>
  
                <div class="col-lg-12" v-if="!ocultarMenu">
                  <div class="row">
                    
                    <div class="col-lg-6">
                      <center><label>Tareas para hoy ({{fecha_actual}})</label></center>
                      <center>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-handshake-o" aria-hidden="true"></i>
                      <span class="badge badge-success noti-icon-badge">{{contador_visitas_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-phone" aria-hidden="true"></i>
                    <span class="badge badge-success noti-icon-badge">{{contador_llamadas_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="badge badge-success noti-icon-badge">{{contador_correos_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-video-camera" aria-hidden="true"></i>
                          <span class="badge badge-success noti-icon-badge">{{contador_videoConferencia_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    <span class="badge badge-success noti-icon-badge">{{contador_whatsapp_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-skype" aria-hidden="true"></i>
                    <span class="badge badge-success noti-icon-badge">{{contador_skype_hoy}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                    <span class="badge badge-success noti-icon-badge">{{contador_twitter_hoy}}</span>
                      </a>
                      </center>
                    </div>
                    <div class="col-lg-6">
                      <center><label>Tareas atrasadas</label></center>
                      <center>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-handshake-o" aria-hidden="true"></i>
                      <span class="badge badge-danger noti-icon-badge">{{contador_visitas_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-phone" aria-hidden="true"></i>
                    <span class="badge badge-danger noti-icon-badge">{{contador_llamadas_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="badge badge-danger noti-icon-badge">{{contador_correos_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-video-camera" aria-hidden="true"></i>
                          <span class="badge badge-danger noti-icon-badge">{{contador_videoConferencia_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    <span class="badge badge-danger noti-icon-badge">{{contador_whatsapp_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-skype" aria-hidden="true"></i>
                    <span class="badge badge-danger noti-icon-badge">{{contador_skype_pendientes}}</span>
                      </a>
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"  role="button"
                          aria-haspopup="false" aria-expanded="false">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                    <span class="badge badge-danger noti-icon-badge">{{contador_twitter_pendientes}}</span>
                      </a>
                      </center>

                    </div>

                    <div class="col-lg-6">
                      <div class="col-lg-12 alert alert-info" v-for="(eventos_checkin, index) in eventos_checkin" :key="index">
                        Se inicio Check in en la cita: {{eventos_checkin.title}} 
                        <button @click="seleccionarCheckOut(eventos_checkin)" class="btn btn-danger text-white"> Check out</button>
                      </div>
                    </div>

                  </div>
                </div>
  
                <div class="col-lg-6 align-self-center" v-if="BanderaCheckOut">
                  <div class="card-box">
                    <div class="card-header crear-cita-header">
                      <center><h1><i class="fa fa-plus"></i>&nbsp;Check out</h1></center>
                    </div>
                    <div class="col-lg-12 alert alert-warning" v-if="alertaCita2">
                      {{alertaCita2}}
                    </div>
                      <label>Titulo: {{CheckinSeleccionada.title}}</label>
                      <br>
                      <label>Cliente: {{CheckinSeleccionada.cliente}} {{CheckinSeleccionada.nombre_cliente}}</label> 
                    <br> 
                      <div class="col-lg-12">
                        <div class="form-group" style="width: 100%;">
                          <label for="exampleFormControlInput1">Resultado de la visita</label>                                                                                          
                            <textarea v-model="descripcion_final" style="height: ; width: 100%;" rows="4">  </textarea>               
                        </div>
                      </div>
  
                      <div class="col-lg-12">
                        <div class="form-group" ng-non-bindable>
                          <label for="exampleFormControlInput1">Archivo Adjunto</label>
                          <br>
                          <input type="file" name="evidencia_foto_final" @change="onFileSelectedFinal">
                        </div>
                      </div>
  
                    <div class="col-lg-12 d-flex justify-content-center">
                      <button class="btn btn-danger text-white" @click="cerrarCheckout">
                        Volver
                      </button>
                      &nbsp;&nbsp;
                      <button class="btn btn-success text-white" @click="confirmarCheckOut">
                        Finalizar Visita
                      </button>
                    </div>
  
                  </div>
                </div>

                <div class="col-lg-6 align-self-center" v-if="BanderaFinalizar">
                  <div class="card-box">
                    <div class="card-header crear-cita-header">
                      <center><h1><i class="fa fa-plus"></i>&nbsp;Concluir Tarea</h1></center>
                    </div>
                    
                      <label>Titulo: {{FinalizarSeleccionada.title}}</label>
                      <br>
                      <label>Cliente: {{FinalizarSeleccionada.cliente}} {{FinalizarSeleccionada.nombre_cliente}}</label> 
                    <br> 
                      <div class="col-lg-12">
                        <div class="form-group" style="width: 100%;">
                        <label for="exampleFormControlInput1">Resultado de {{FinalizarSeleccionada.forma_contacto}}</label>                                                                                          
                            <textarea v-model="descripcion_final" style="height: ; width: 100%;" rows="4">  </textarea>               
                        </div>
                      </div>
  
                      <div class="col-lg-12">
                        <div class="form-group" ng-non-bindable>
                          <label for="exampleFormControlInput1">Archivo Adjunto</label>
                          <br>
                          <input type="file" name="evidencia_foto_final" @change="onFileSelectedFinal">
                        </div>
                      </div>
  
                    <div class="col-lg-12 d-flex justify-content-center">
                      <button class="btn btn-danger text-white" @click="cerrarFinalizar">
                        Volver
                      </button>
                      &nbsp;&nbsp;
                      <button class="btn btn-success text-white" @click="confirmarFinalizar">
                        Realizado
                      </button>
                    </div>
  
                  </div>
                </div>

                <div class="col-lg-6 align-self-center" v-if="BanderaBorrarCita">
                  <div class="card-box">
                    <div class="card-header borrar-cita-header">
                      <center><h1><i class="fa fa-trash-o"></i>&nbsp;Borrar Cita</h1></center>
                    </div>
                    <div class="col-lg-12 alert alert-warning" v-if="alertaCita3">
                      @{{alertaCita3}}
                    </div>
                      <label>Titulo: {{BorrarSeleccionada.title}}</label>
                      <br>
                      <label>Cliente: {{BorrarSeleccionada.cliente}} {{BorrarSeleccionada.nombre_cliente}}</label> 
                    <br> 
                      <div class="col-lg-12">
                        <div class="form-group" style="width: 100%;">
                          <label for="exampleFormControlInput1">Motivo de eliminación</label>                                                                                          
                            <textarea v-model="motivo_eliminacion" style="height: ; width: 100%;" rows="4">  </textarea>               
                        </div>
                      </div>

  
                    <div class="col-lg-12 d-flex justify-content-center">
                      <button class="btn btn-danger text-white" @click="cerrarBorrarCita">
                        Volver
                      </button>
                      &nbsp;&nbsp;
                      <button class="btn btn-success text-white" @click="borrarCita">
                        Borrar Cita
                      </button>
                    </div>
  
                  </div>
                </div>
  
                <div class="col-lg-6 align-self-center" v-if="mostrarCrearCita">
                 
                    <div class="card-box">
                      <div class="card-header crear-cita-header">
                        <center><h1><i class="fa fa-plus"></i>&nbsp;Crear Cita</h1></center>
                      </div>
                  
                  <div class="card-body">
                    <div class="col-lg-12 alert alert-warning" v-if="alertaCita">
                      {{alertaCita}}
                    </div>
                    <form>
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <!--<label for="exampleFormControlInput1">Titulo</label>-->
                              <input type="text" class="form-control" id="exampleFormControlInput1" v-model="asunto" placeholder="Titulo">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="exampleFormControlInput3">Tipo</label>
                                  <select class="form-control" v-model="tipo_evento">
                                    <option value="cliente">Oportunidad</option>
                                    <option value="prospecto">Prospecto</option>
                                    <option value="personal">Personal</option>
                                  </select>
                                  
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="exampleFormControlInput2">Fecha</label>
                                  <input type="date" class="form-control" id="exampleFormControlInput2" v-model="fecha_inicio" v-bind:min="fecha_buscar">
                                </div>
                              </div>
                            </div>
                          </div>
  
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label for="exampleFormControlInput4">Hora Inicio</label>
                              <br>
                              <select v-model="hora_inicio">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                              </select> -
  
                              <select v-model="minutos_inicio">
                                <option>00</option>
                                <option>05</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>55</option>
                                <option>60</option>
  
                              </select>
  
                            </div>
                          </div>
  
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label for="exampleFormControlInput3">Hora Termino</label>
                              <br>
                              <select v-model="hora_termino">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                              </select> -
  
                              <select v-model="minutos_termino">
                                <option>00</option>
                                <option>05</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>55</option>
                                <option>59</option>
  
                              </select>
  
                            </div>
                          </div>
  
                          <div class="col-lg-12">
                            <div v-if="ListaClientes && tipo_evento == 'cliente'" class="form-group" ng-non-bindable>
                              <label for="exampleFormControlInput1">Oportunidad</label>
                              <select class="form-control" v-model="cliente_seleccionado">
                                <option v-for="(ListaClientes, index) in ListaClientes" :key="index"
                                  :value="ListaClientes">{{ ListaClientes.ruta_id}} - {{ ListaClientes.nombre}}
                                </option>
                              </select>
                            </div>
  
                            <div v-if="ListaProspecto && tipo_evento == 'prospecto'" class="form-group" ng-non-bindable>
                              <label for="exampleFormControlInput1">Prospectos</label>
                              <select class="form-control" v-model="cliente_seleccionado">
                                <option v-for="(ListaProspecto, index) in ListaProspecto" :key="index"
                                  :value="ListaProspecto">{{ ListaProspecto.nombre}}
                                </option>
                              </select>
                            </div>
                          </div>
                         
                          <div class="col-lg-6">
                            <div v-if="tipo_evento == 'cliente' || tipo_evento == 'prospecto'" class="form-group" ng-non-bindable>
                              <label for="exampleFormControlInput1">Forma de Contacto</label>
                              <br>
                              <select class="form-control" v-model="cliente_forma">
                                <option>Visita</option>
                                <option>Llamada</option>
                                <option>Correo</option>
                                <option>VideoConferencia</option>
                                <option>Whatsapp</option>
                                <option>Skype</option>
                                <option>Twitter</option>
                              </select>
                            </div>
                          </div>
  
                          <div class="col-lg-6">
                            <div v-if="tipo_evento == 'cliente' || tipo_evento == 'prospecto'" class="form-group" ng-non-bindable>
                              <label for="exampleFormControlInput1">Objetivo de contacto</label>
                              <br>
                              <select class="form-control" v-model="cliente_objetivo">
                                <option>Prospectación</option>
                                <option>Venta</option>
                                <option>Seguimiento pedidos</option>
                                <option>Cobranza</option>
                                <option>Contacto Técnico</option>
                                <option>Capacitación</option>
                                <option>Reunión</option>
                              </select>
                            </div>
                          </div>
  
                          <div class="col-lg-12">
                            <div class="form-group" style="width: 100%;">
                              <label for="exampleFormControlInput1">Descripción</label>                                                                                          
                                <textarea v-model="descripcion" style="height: ; width: 100%;" rows="4">  </textarea>               
                            </div>
                          </div>
  
                          <div class="col-lg-12">
                            <div v-if="tipo_evento == 'cliente' || tipo_evento == 'prospecto'" class="form-group" ng-non-bindable>
                              <label for="exampleFormControlInput1">Archivo Adjunto</label>
                              <br>
                              <input type="file" name="evidencia_foto" @change="onFileSelected">
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </form>
  
  
                  </div>
                  <hr>
                  <div class="col-lg-12 d-flex justify-content-center">
                    <button class="btn btn-danger text-white" @click="cerrarCrearCita">
                      Volver
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-success text-white" @click="customEventCreation">
                      Crear cita
                    </button>
                  </div>
                    
                  </div>
                </div>
  
                <modal v-if="mostrarDetalle" @close="mostrarDetalle = false">
                  
                  <div slot="body"> 
                    <div v-bind:class="EventSeleccionado.class">
                      <center><h2>{{EventSeleccionado.title}}</h2></center>
                    </div> 
                    <label>Fecha: {{EventSeleccionado.fecha}}</label><br>               
                    <label>Hora inicio: {{EventSeleccionado.hora_inicio}}</label><br>
                    <label>Hora fin: {{EventSeleccionado.hora_fin}}</label><br>                  
              
                    <label v-if="EventSeleccionado.tipo_cita == 'Reunion con cliente'">
                      Oportunidad: ({{EventSeleccionado.cliente}}) - {{EventSeleccionado.nombre_cliente}}
                    </label>
                    <label v-if="EventSeleccionado.tipo_cita == 'Cita prospecto'">
                      Prospecto: ({{EventSeleccionado.cliente}}) - {{EventSeleccionado.nombre_cliente}}
                    </label>
                    <br>                
                    <label v-if="EventSeleccionado.forma_contacto">
                      Forma de contacto: {{EventSeleccionado.forma_contacto}}
                    </label>
                    <br>
                    <label v-if="EventSeleccionado.objetivo_contacto">
                      Objetivo de contacto: {{EventSeleccionado.objetivo_contacto}}
                    </label>
                    <br>
                    <label v-if="EventSeleccionado.descripcion_detalle">Detalle del cita:
                      {{EventSeleccionado.descripcion_detalle}}
                    </label>
                    <br>
                    <div v-if="ConteoEvidenciaCheckIn != 0"> 
                        Archivo Adjunto<br>
                        <div v-for="(evidencia1, index) in EvidenciaSeleccionada" :key="index">
                          <!--<img v-bind:src="'https://pgc360.iusa.com.mx/'+ EvidenciaSeleccionada[0].foto" style="height: 100px; auto">-->
                          <a v-if="evidencia1.seccion == 'check-in'" target="_blank" v-bind:href="'https://pgc360.iusa.com.mx/'+ evidencia1.foto" > Mostrar archivo</a>
                        </div>
                    </div>
  
                    <a class="btn btn-success btn-lg text-white" target="_blank"
                      v-if="EventSeleccionado.forma_contacto == 'Visita' && !EventSeleccionado.checkin"  @click="iniciarCheckIn">
                      Iniciar Check In
                    </a>
  
                    <div class="col-lg-12 alert alert-warning" v-if="EventSeleccionado.checkin && !EventSeleccionado.checkout">                      
                      Se a iniciado Check In
                    </div>

                    <button @click="seleccionarCheckOut2(EventSeleccionado)" class="btn btn-danger text-white"
                    v-if="EventSeleccionado.checkin && !EventSeleccionado.checkout"> Check out</button>

                    <a class="btn btn-success btn-lg text-white" target="_blank"
                      v-if="EventSeleccionado.tipo_cita != 'Cita personal' && EventSeleccionado.forma_contacto != 'Visita' && !EventSeleccionado.finalizo"  @click="finalizarTarea(EventSeleccionado)">
                      Concluir Tarea 
                    </a>
                    
                    <div class="col-lg-12 alert alert-warning" v-if="EventSeleccionado.checkin && EventSeleccionado.checkout">
                      Se a terminado la visita.
                    </div>

                    <div class="col-lg-12 alert alert-warning"
                    v-if="EventSeleccionado.tipo_cita != 'Cita personal' && EventSeleccionado.forma_contacto != 'Visita' && EventSeleccionado.finalizo">
                      Se a concluido la tarea
                    </div>

                    <br>
                    <label v-if="EventSeleccionado.observacion_final && EventSeleccionado.observacion_final != null  && EventSeleccionado.observacion_final != 'null'">Observaciones Finales:
                      {{EventSeleccionado.observacion_final}}
                    </label>
                    <br>
                    <div v-if="EventSeleccionado.observacion_final && ConteoEvidenciaCheckOut != 0">
                      Archivo Adjunto<br> 
                      <div v-for="(evidencia1, index) in EvidenciaSeleccionada" :key="index">
                        <!--<img v-bind:src="'https://pgc360.iusa.com.mx/'+ EvidenciaSeleccionada[0].foto" style="height: 100px; auto">-->
                        <a v-if="evidencia1.seccion == 'check-out'" target="_blank" v-bind:href="'https://pgc360.iusa.com.mx/'+ evidencia1.foto" > Mostrar archivo</a>
                      </div>
                  </div>
                                   
  
                  </div>
                  <div slot="footer">
                    <button class="btn btn-danger text-white" @click="abrirBorrarCita(EventSeleccionado)" v-if="!EventSeleccionado.checkin && !EventSeleccionado.checkout && !EventSeleccionado.finalizo">
                      Eliminar cita
                    </button>
  
                    <button class="btn btn-warning text-white" @click="mostrarDetalle = false">
                      Volver
                    </button>
                  </div>
                </modal>
                
                <vue-cal 
                style="height: 450px" 
                default-view="week" 
                :disable-views="['years']" 
                locale="es" 
                today-button                
                :time-step="30" 
                :events="events" 
                :on-event-click="onEventClick"
                v-if="!ocultarMenu"></vue-cal>
              
                <!-- template for the modal component -->
                <script type="text/x-template" id="modal-template">
                  <transition name="modal">
                  <div class="modal-mask">
                    <div class="modal-wrapper">
                      <div class="modal-container">
              
                        <div class="modal-body">
                          <slot name="body">
                            default body
                          </slot>
                        </div>
              
                        <div class="modal-footer">
                          <slot name="footer">
                          </slot>
                        </div>
                      </div>
                    </div>
                  </div>
                </transition>
              </script>
  
  
              </div>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
Vue.component('modal', {
                template: '#modal-template'
              })
export default {
  components: { VueCal },
  data: () => ({
    BanderaAxios: false,
                selectedEvent: {},
                ocultarMenu: false,
                asunto: "",
                fecha_inicio: "",
                hora_inicio: "",
                minutos_inicio: "",
                rango_inicio: "",
                nuevo_date: "",
                hora_termino: "",
                minutos_termino: "",
                rango_termino: "",
                nuevo_date_segundo: "",
                descripcion: "",
                descripcion_agenda: "",
                ListaClientes: [],
                nuevoArreglo: [],
                loading: true,
                errored: false,
                cliente_seleccionado: "",
                cliente_forma: "",
                cliente_objetivo: "",
                tipo_evento: "",
                EventSeleccionado: [],
                mostrarDetalle: false,
                cliente_nombre: "",
                cliente_lat: "",
                cliente_lon: "",
                cliente_tel: "",
                cliente_email: "",
                ClienteLugar: [],
                InfoVendedor: "",
                events: [],
                ListaProspecto: [],
                evidencia_foto: null,
                EvidenciaSeleccionada: {},
                ConteoEvidenciaCheckIn: 0,
                ConteoEvidenciaCheckOut: 0,
                eventos_checkin: [],
                CheckinSeleccionada: {},
                BanderaCheckOut: false,
                mostrarCrearCita: false,
                descripcion_final: "",
                evidencia_foto_final: null,
                alertaCita : null,
                alertaCita2 : null,
                fecha_actual : "",                
                fecha_buscar: "",
                FinalizarSeleccionada: {},
                BanderaFinalizar: false,
                contador_visitas_hoy: 0,
                contador_llamadas_hoy: 0,
                contador_correos_hoy: 0,
                contador_videoConferencia_hoy: 0,
                contador_whatsapp_hoy: 0,
                contador_skype_hoy: 0,
                contador_twitter_hoy: 0,
                contador_visitas_pendientes: 0,
                contador_llamadas_pendientes: 0,
                contador_correos_pendientes: 0,
                contador_videoConferencia_pendientes: 0,
                contador_whatsapp_pendientes: 0,
                contador_skype_pendientes: 0,
                contador_twitter_pendientes: 0,
                BorrarSeleccionada: {},
                BanderaBorrarCita: false,
                alertaCita3 : null,
                motivo_eliminacion: "",
  }),
  methods: {
                customEventCreation () {
                      if(this.asunto == null || this.asunto == ''){
                        this.alertaCita = 'Es necesario poner título'
                      }else if(this.tipo_evento == null || this.tipo_evento == ''){
                        this.alertaCita = 'Es necesario seleccionar tipo'
                      }else if(this.fecha_inicio == null || this.fecha_inicio == ''){
                        this.alertaCita = 'Es necesario seleccionar fecha'
                      }else if(this.hora_inicio == null || this.hora_inicio == ''){
                        this.alertaCita = 'Es necesario seleccionar hora de inicio'
                      }else if(this.minutos_inicio == null || this.minutos_inicio == ''){
                        this.alertaCita = 'Es necesario seleccionar los minutos de inicio' 
                      }else if(this.hora_termino == null || this.hora_termino == ''){
                        this.alertaCita = 'Es necesario seleccionar hora de termino' 
                      }else if(this.minutos_termino == null || this.minutos_termino == ''){
                        this.alertaCita = 'Es necesario seleccionar los minutos de termino' 
                      }else if(this.tipo_evento == 'cliente' && this.cliente_seleccionado == ''){
                        this.alertaCita = 'Es necesario seleccionar un cliente' 
                      }else if(this.tipo_evento == 'cliente' && this.cliente_forma == ''){
                        this.alertaCita = 'Es necesario seleccionar una forma de contacto' 
                      }else if(this.tipo_evento == 'cliente' && this.cliente_objetivo == ''){
                        this.alertaCita = 'Es necesario seleccionar un objetivo de contacto' 
                      }else if(this.tipo_evento == 'prospecto' && this.cliente_seleccionado == ''){
                        this.alertaCita = 'Es necesario seleccionar un cliente' 
                      }else if(this.tipo_evento == 'prospecto' && this.cliente_forma == ''){
                        this.alertaCita = 'Es necesario seleccionar una forma de contacto' 
                      }else if(this.tipo_evento == 'prospecto' && this.cliente_objetivo == ''){  
                        this.alertaCita = 'Es necesario seleccionar un objetivo de contacto' 
                      }else{
                        this.ocultarMenu = false
                        this.mostrarCrearCita = false
                        this.BanderaAxios = true
                        this.nuevo_date = this.fecha_inicio +' ' + this.hora_inicio + ':' + this.minutos_inicio
                        this.nuevo_date_segundo = this.fecha_inicio +' ' + this.hora_termino + ':' + this.minutos_termino
                        this.descripcion_agenda = this.descripcion 
                        if(this.tipo_evento == 'cliente'){
                          //conseguir info de cliente asignado
                          this.cliente_id = this.cliente_seleccionado.id
                          this.cliente_nombre = this.cliente_seleccionado.nombre
                          this.cliente_lat = this.cliente_seleccionado.latitud
                          this.cliente_lon = this.cliente_seleccionado.longitud
                          this.cliente_email = this.cliente_seleccionado.correo_electronico
                          
                          if(this.cliente_forma == 'Visita'){
                            this.descripcion = '<i class="fa fa-handshake-o" aria-hidden="true"></i><br>Reunion con oportunidad'
                            
                          }else if(this.cliente_forma == 'Llamada'){
                            this.descripcion = '<i class="fa fa-phone" aria-hidden="true"></i><br>Llamada con oportunidad'
                            
                          }else if(this.cliente_forma == 'Correo'){
                            this.descripcion = '<i class="fa fa-envelope-o" aria-hidden="true"></i><br>Correo con oportunidad'
                           
                          }else if(this.cliente_forma == 'VideoConferencia'){
                            this.descripcion = '<i class="fa fa-video-camera" aria-hidden="true"></i><br>VideoConferencia con oportunidad'
                            
                          }else if(this.cliente_forma == 'Whatsapp'){
                            this.descripcion = '<i class="fa fa-whatsapp" aria-hidden="true"></i><br>Whatsapp con oportunidad'
                           
                          }else if(this.cliente_forma == 'Skype'){
                            this.descripcion = '<i class="fa fa-skype" aria-hidden="true"></i><br>Skype con oportunidad'
                            
                          }else if(this.cliente_forma == 'Twitter'){
                            this.descripcion = '<i class="fa fa-twitter" aria-hidden="true"></i><br>Twitter con oportunidad'
                          }  

                        

                          var mieventonuevo = {
                          start: this.nuevo_date,
                          end: this.nuevo_date_segundo,
                          title: this.asunto,
                          content: this.descripcion,
                          class: this.tipo_evento,
                          cliente: this.cliente_id,
                          nombre_cliente: this.cliente_nombre,
                          lat_cliente: this.cliente_lat,
                          lon_cliente: this.cliente_lon,
                          tipo_cita: "Reunion con oportunidad",
                          descripcion_detalle: this.descripcion_agenda,
                          fecha: this.fecha_inicio,
                          hora_inicio: this.hora_inicio + ':' + this.minutos_inicio,
                          hora_fin: this.hora_termino + ':' + this.minutos_termino,
                          cliente_tel: this.cliente_tel,
                          cliente_email: this.cliente_email,
                          cliente_forma: this.cliente_forma,
                          cliente_objetivo: this.cliente_objetivo,
                          vendedor: this.InfoVendedor
                          }
                          var formData = new FormData()
                          
                          formData.append("start",this.nuevo_date)
                          formData.append("end",this.nuevo_date_segundo)
                          formData.append("title",this.asunto)
                          formData.append("content",this.descripcion)
                          formData.append("class",this.tipo_evento)
                          formData.append("cliente",this.cliente_id)
                          formData.append("nombre_cliente",this.cliente_nombre)
                          formData.append("lat_cliente",this.cliente_lat)
                          formData.append("lon_cliente",this.cliente_lon)
                          formData.append("tipo_cita","Reunion con cliente")
                          formData.append("descripcion_detalle",this.descripcion_agenda)
                          formData.append("fecha",this.fecha_inicio)
                          formData.append("hora_inicio",this.hora_inicio + ':' + this.minutos_inicio)
                          formData.append("hora_fin",this.hora_termino + ':' + this.minutos_termino)
                          formData.append("cliente_tel",this.cliente_tel)
                          formData.append("cliente_email",this.cliente_email)
                          formData.append("cliente_forma",this.cliente_forma)
                          formData.append("cliente_objetivo",this.cliente_objetivo)
                          formData.append("vendedor",this.InfoVendedor)
                          formData.append("Evidencia", this.evidencia_foto)
                          //guardar el id 
                          axios.post('./agendaNuevaCita', formData,{
                             
                          }).then(response => {
                            //alert(response.data)
                            //var indice = response.data
                            mieventonuevo = response.data
                            this.events.push(mieventonuevo);
                            this.limpiarFormulario();
                            this.BanderaAxios = false
                            console.log(mieventonuevo.fecha)
                            console.log(this.fecha_buscar)
                            if(mieventonuevo.fecha == this.fecha_buscar){
                              console.log('es igual')
                              console.log(mieventonuevo) 
                                if(mieventonuevo.forma_contacto == 'Visita'){     
                                  console.log('es visita')    
                                  console.log(this.contador_visitas_hoy)                         
                                this.contador_visitas_hoy = this.contador_visitas_hoy + 1
                                console.log(this.contador_visitas_hoy)  
                              }else if(mieventonuevo.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Correo'){                                
                                this.contador_correos_hoy++
                              }else if(mieventonuevo.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Skype'){                               
                                this.contador_skype_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_hoy++ 
                              }
                            } 
                          }).catch(e => {
                              console.log(e);
                          });                        
                          
                        
  
                          
                        }else if(this.tipo_evento == 'personal'){
                          this.descripcion = '<i class="fa fa-home" aria-hidden="true"></i>'
                          var mieventonuevo = {
                          start: this.nuevo_date,
                          end: this.nuevo_date_segundo,
                          title: this.asunto,
                          content: this.descripcion,
                          class: this.tipo_evento,
                          cliente: this.cliente_seleccionado, 
                          nombre_cliente: this.cliente_nombre,
                          lat_cliente: this.cliente_lat,
                          lon_cliente: this.cliente_lon,
                          tipo_cita: "Cita personal",
                          descripcion_detalle: this.descripcion_agenda,
                          fecha: this.fecha_inicio,
                          hora_inicio: this.hora_inicio + ':' + this.minutos_inicio,
                          hora_fin: this.hora_termino + ':' + this.minutos_termino,
                          cliente_tel: this.cliente_tel,
                          cliente_email: this.cliente_email,
                          cliente_forma: this.cliente_forma,
                          cliente_objetivo: this.cliente_objetivo,
                          vendedor: this.InfoVendedor
                          } 
                          var formData = new FormData()
                          formData.append("start",this.nuevo_date)
                          formData.append("end",this.nuevo_date_segundo)
                          formData.append("title",this.asunto)
                          formData.append("content",this.descripcion)
                          formData.append("class",this.tipo_evento)
                          formData.append("cliente",this.cliente_seleccionado)
                          formData.append("nombre_cliente",this.cliente_nombre)
                          formData.append("lat_cliente",this.cliente_lat)
                          formData.append("lon_cliente",this.cliente_lon)
                          formData.append("tipo_cita","Cita personal")
                          formData.append("descripcion_detalle",this.descripcion_agenda)
                          formData.append("fecha",this.fecha_inicio)
                          formData.append("hora_inicio",this.hora_inicio + ':' + this.minutos_inicio)
                          formData.append("hora_fin",this.hora_termino + ':' + this.minutos_termino)
                          formData.append("cliente_tel",this.cliente_tel)
                          formData.append("cliente_email",this.cliente_email)
                          formData.append("cliente_forma",this.cliente_forma)
                          formData.append("cliente_objetivo",this.cliente_objetivo)
                          formData.append("vendedor",this.InfoVendedor)
                          formData.append("Evidencia", this.evidencia_foto)
                          //guardar el id 
                          axios.post('./agendaNuevaCita',formData, {
                            cita: mieventonuevo
                          }).then(response => {
                            //alert(response.data)
                            //var indice = response.data
                            mieventonuevo = response.data
                            this.events.push(mieventonuevo);
                            this.limpiarFormulario();
                            this.BanderaAxios = false
                          }).catch(e => {
                              console.log(e);
                          });
                        }else if(this.tipo_evento == 'prospecto'){
                          if(this.cliente_forma == 'Visita'){
                          this.descripcion = '<i class="fa fa-handshake-o" aria-hidden="true"></i><br>Reunion con prospecto'
                        }else if(this.cliente_forma == 'Llamada'){
                          this.descripcion = '<i class="fa fa-phone" aria-hidden="true"></i><br>Llamada con prospecto'
                        }else if(this.cliente_forma == 'Correo'){
                          this.descripcion = '<i class="fa fa-envelope-o" aria-hidden="true"></i><br>Correo con prospecto'
                        }else if(this.cliente_forma == 'VideoConferencia'){
                          this.descripcion = '<i class="fa fa-video-camera" aria-hidden="true"></i><br>VideoConferencia con prospecto'
                        }else if(this.cliente_forma == 'Whatsapp'){
                          this.descripcion = '<i class="fa fa-whatsapp" aria-hidden="true"></i><br>Whatsapp con prospecto'
                        }else if(this.cliente_forma == 'Skype'){
                          this.descripcion = '<i class="fa fa-skype" aria-hidden="true"></i><br>Skype con prospecto'
                        }else if(this.cliente_forma == 'Twitter'){
                          this.descripcion = '<i class="fa fa-twitter" aria-hidden="true"></i><br>Twitter con prospecto'
                        }
                        

                          var mieventonuevo = {
                          start: this.nuevo_date,
                          end: this.nuevo_date_segundo,
                          title: this.asunto,
                          content: this.descripcion,
                          class: this.tipo_evento,
                          cliente: this.cliente_seleccionado.id, 
                          nombre_cliente:  this.cliente_seleccionado.nombre,
                          lat_cliente: this.cliente_lat,
                          lon_cliente: this.cliente_lon,
                          tipo_cita: "Cita prospecto",
                          descripcion_detalle: this.descripcion_agenda,
                          fecha: this.fecha_inicio,
                          hora_inicio: this.hora_inicio + ':' + this.minutos_inicio,
                          hora_fin: this.hora_termino + ':' + this.minutos_termino,
                          cliente_tel: this.cliente_tel,
                          cliente_email: this.cliente_email,
                          cliente_forma: this.cliente_forma,
                          cliente_objetivo: this.cliente_objetivo,
                          vendedor: this.InfoVendedor
                          } 
                          //guardar el id 
                          var formData = new FormData()
                          formData.append("start",this.nuevo_date)
                          formData.append("end",this.nuevo_date_segundo)
                          formData.append("title",this.asunto)
                          formData.append("content",this.descripcion)
                          formData.append("class",this.tipo_evento)
                          formData.append("cliente",this.cliente_seleccionado.id)
                          formData.append("nombre_cliente",this.cliente_seleccionado.nombre)
                          formData.append("lat_cliente",this.cliente_lat)
                          formData.append("lon_cliente",this.cliente_lon)
                          formData.append("tipo_cita","Cita prospecto")
                          formData.append("descripcion_detalle",this.descripcion_agenda)
                          formData.append("fecha",this.fecha_inicio)
                          formData.append("hora_inicio",this.hora_inicio + ':' + this.minutos_inicio)
                          formData.append("hora_fin",this.hora_termino + ':' + this.minutos_termino)
                          formData.append("cliente_tel",this.cliente_tel)
                          formData.append("cliente_email",this.cliente_email)
                          formData.append("cliente_forma",this.cliente_forma)
                          formData.append("cliente_objetivo",this.cliente_objetivo)
                          formData.append("vendedor",this.InfoVendedor)
                          formData.append("Evidencia", this.evidencia_foto)
                          
  
                          axios.post('./agendaNuevaCita',formData, {
                            cita: mieventonuevo
                          }).then(response => {
                            //alert(response.data)
                            //var indice = response.data
                            mieventonuevo = response.data
                            this.events.push(mieventonuevo);
                            this.limpiarFormulario();
                            this.BanderaAxios = false
                            if(mieventonuevo.fecha == this.fecha_buscar){
                              console.log('es igual')
                              console.log(mieventonuevo) 
                                if(mieventonuevo.forma_contacto == 'Visita'){     
                                  console.log('es visita')    
                                  console.log(this.contador_visitas_hoy)                         
                                this.contador_visitas_hoy = this.contador_visitas_hoy + 1
                                console.log(this.contador_visitas_hoy)  
                              }else if(mieventonuevo.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Correo'){                                
                                this.contador_correos_hoy++
                              }else if(mieventonuevo.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Skype'){                               
                                this.contador_skype_hoy++
                              }else if(mieventonuevo.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_hoy++ 
                              }
                            }
                          }).catch(e => {
                              console.log(e);
                          });
                        }                   
                      }//fin else
                      },
                      ir_mapa () {
                        window.open(this.ClienteLugar,'_blank')
                      },
                      onEventClick (event, e) {
                        this.EvidenciaSeleccionada = {}
                        this.ConteoEvidenciaCheckIn = 0; 
                        this.ConteoEvidenciaCheckOut = 0; 
                        this.EventSeleccionado = event
                        this.mostrarDetalle = true
                        axios.post('./obtenerEvidenciaCita', {
                          cita_id: this.EventSeleccionado.id
                        }).then(response => {
                          this.EvidenciaSeleccionada = response.data.datos
                          this.ConteoEvidenciaCheckIn = response.data.conteo_checkin
                          this.ConteoEvidenciaCheckOut = response.data.conteo_checkout
                        }).catch(e => {
                            console.log(e);
                        });
                      },
                      limpiarFormulario () {
                          //vovler valores del formulario en blanco 
                          this.asunto = ""
                          this.fecha_inicio = ""
                          this.hora_inicio = ""
                          this.minutos_inicio = ""
                          this.rango_inicio = ""
                          this.nuevo_date = ""
                          this.hora_termino = ""
                          this.minutos_termino = ""
                          this.rango_termino = ""
                          this.nuevo_date_segundo = ""
                          this.descripcion = ""
                          this.cliente_seleccionado = ""
                          this.cliente_nombre = ""
                          this.cliente_lat = ""
                          this.cliente_lon = ""
                          this.descripcion_agenda = ""
                          this.cliente_tel = ""
                          this.cliente_email = ""
                          this.cliente_forma = ""
                          this.cliente_objetivo = ""
                          this.evidencia_foto = null
                          this.alertaCita = null 
                      },
                      borrarCita () {
                        if(this.motivo_eliminacion == null || this.motivo_eliminacion == ''){
                        this.alertaCita3 = 'Es necesario poner un motivo de eliminación'
                      }else{
                        this.BanderaAxios = true
                        axios.post('./agendaBorrarCita', {
                          cita_id: this.BorrarSeleccionada.id,
                          motivo: this.motivo_eliminacion
                        }).then(response => {

                          if(this.BorrarSeleccionada.fecha == this.fecha_buscar){
                              console.log('es igual')
                              console.log(this.BorrarSeleccionada) 
                                if(this.BorrarSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_hoy-- 
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_hoy--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Correo'){                                
                                this.contador_correos_hoy--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_hoy--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_hoy--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Skype'){                               
                                this.contador_skype_hoy--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_hoy--
                              }
                            }

                            if(this.BorrarSeleccionada.fecha < this.fecha_buscar){
                              console.log('es fecha anterior')
                              console.log(this.BorrarSeleccionada) 
                                if(this.BorrarSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_pendientes-- 
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_pendientes--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Correo'){                                
                                this.contador_correos_pendientes--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_pendientes--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_pendientes--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Skype'){                               
                                this.contador_skype_pendientes--
                              }else if(this.BorrarSeleccionada.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_pendientes--
                              }
                            }

                          for(var buscador in this.events){
                            var plan1_1 = this.events[buscador]                            
                              if(plan1_1.id == this.BorrarSeleccionada.id){
                                console.log(plan1_1)
                                this.events.splice(buscador, 1);
                              }  
                            }
                          for(var buscador in this.eventos_checkin){
                            var plan1_1 = this.eventos_checkin[buscador]                            
                              if(plan1_1.id == this.BorrarSeleccionada.id){
                                console.log(plan1_1)
                                this.eventos_checkin.splice(buscador, 1);
                              }  
                            }
                            this.ocultarMenu = false                   
                            this.BanderaBorrarCita = false
                            this.BanderaAxios = false
                            this.BorrarSeleccionada = {}
                        }).catch(e => {
                            console.log(e);
                            this.BanderaAxios = false
                        });
                      }//fin else
                      },                     
                    onFileSelected (event) {
                      const file = event.target.files[0]                      
                      this.evidencia_foto = file
                      console.log(this.evidencia_foto)
                    },
                    onFileSelectedFinal (event) {
                      const file = event.target.files[0]                      
                      this.evidencia_foto_final = file
                      console.log(this.evidencia_foto_final)
                    },
                    iniciarCheckIn (){
                      let me = this;
                      this.BanderaAxios = true
                      navigator.geolocation.getCurrentPosition(pos => {                        
                        this.mostrarDetalle = false  
                        axios.post('./agendaActivarCheckIn', {
                          cita_id: this.EventSeleccionado.id,
                          lat: pos.coords.latitude,
                          lng: pos.coords.longitude
                        }).then(response => {
                          this.EventSeleccionado.checkin = 1;
                          me.eventos_checkin.push(this.EventSeleccionado);

                          axios.post('./agendaConcentradoCita', {
                            vendedor: 1
                            }).then(response => {
                              this.events = response.data
                              this.BanderaAxios = false
                              this.alertaCita2 = null
                            }).catch(e => {
                                console.log(e);
                                this.BanderaAxios = false
                            });
                        }).catch(e => {
                            console.log(e);
                        });
                         
                      }, err => {
                        this.BanderaAxios = false
                      })
                      
                    },
                    seleccionarCheckOut (seleccionado){
                      console.log(seleccionado)
                      this.CheckinSeleccionada = seleccionado 
                      this.ocultarMenu = true                   
                      this.BanderaCheckOut = true
                    },
                    seleccionarCheckOut2 (seleccionado){
                      console.log(seleccionado)
                      this.CheckinSeleccionada = seleccionado
                      this.mostrarDetalle = false 
                      this.ocultarMenu = true                   
                      this.BanderaCheckOut = true
                    },
                    finalizarTarea(seleccionado){
                      console.log(seleccionado)
                      this.FinalizarSeleccionada = seleccionado
                      this.mostrarDetalle = false 
                      this.ocultarMenu = true                   
                      this.BanderaFinalizar = true
                    },                    
                    abrirCrearCita (){
                      this.ocultarMenu = true
                      this.mostrarCrearCita = true
                    },
                    cerrarCrearCita (){
                      this.ocultarMenu = false
                      this.mostrarCrearCita = false
                    },
                    cerrarCheckout (){
                      this.ocultarMenu = false                   
                      this.BanderaCheckOut = false
                    },
                    cerrarFinalizar (){
                      this.ocultarMenu = false                   
                      this.BanderaFinalizar = false
                    },
                    abrirBorrarCita(seleccionado){
                      console.log(seleccionado)
                      this.BorrarSeleccionada = seleccionado
                      this.mostrarDetalle = false 
                      this.ocultarMenu = true                   
                      this.BanderaBorrarCita = true
                    },
                    cerrarBorrarCita (){
                      this.ocultarMenu = false                   
                      this.BanderaBorrarCita = false
                    },
                    confirmarCheckOut () {
                      if(this.descripcion_final == null || this.descripcion_final == ''){
                        this.alertaCita2 = 'Es necesario poner una descripción'
                      }else {
                      this.BanderaAxios = true
                      navigator.geolocation.getCurrentPosition(pos => {
                        var formData = new FormData()
                          formData.append("cita_id",this.CheckinSeleccionada.id)
                          formData.append("lat",pos.coords.latitude)
                          formData.append("lng",pos.coords.longitude)
                          formData.append("descripcion_final",this.descripcion_final)
                          formData.append("evidencia_final",this.evidencia_foto_final)                      
                        axios.post('./agendaActivarCheckOut',formData,{
                          
                        }).then(response => {
                          var indice = this.eventos_checkin.indexOf(this.CheckinSeleccionada)
                          this.eventos_checkin.splice(indice, 1)    
                         
                          this.evidencia_foto_final = null
                          this.descripcion_final = null
                          this.ocultarMenu = false                   
                          this.BanderaCheckOut = false
                          //this.BanderaAxios = false
                          console.log(this.CheckinSeleccionada)
                          if(this.CheckinSeleccionada.fecha == this.fecha_buscar){
                              console.log('es igual')
                              console.log(this.CheckinSeleccionada) 
                                if(this.CheckinSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_hoy-- 
                              }
                            }
                          if(this.CheckinSeleccionada.fecha < this.fecha_buscar){
                              console.log('es fecha anterior')
                              console.log(this.CheckinSeleccionada) 
                                if(this.CheckinSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_pendientes-- 
                              }
                            }
                           
                          this.CheckinSeleccionada = {}

                          axios.post('./agendaConcentradoCita', {
                            vendedor: 1
                          }).then(response => {
                            this.events = response.data
                            this.BanderaAxios = false
                            this.alertaCita2 = null
                          }).catch(e => {
                              console.log(e);
                              this.BanderaAxios = false
                          });
  
                        }).catch(e => {
                            console.log(e);
                            this.BanderaAxios = false
                            this.alertaCita2 = null
                        });
                        
                      }, err => {
                          
                      })
                    }
                  },
                  confirmarFinalizar () {
            
                      this.BanderaAxios = true                      
                        var formData = new FormData()
                          formData.append("cita_id",this.FinalizarSeleccionada.id)                          
                          formData.append("descripcion_final",this.descripcion_final)
                          formData.append("evidencia_final",this.evidencia_foto_final)                      
                        axios.post('./agendaActivarFinalizo',formData,{
                          
                        }).then(response => {                             
                          
                          this.evidencia_foto_final = null
                          this.descripcion_final = null
                          this.ocultarMenu = false                   
                          this.BanderaFinalizar= false
                          //this.BanderaAxios = false
                          if(this.FinalizarSeleccionada.fecha == this.fecha_buscar){
                              console.log('es igual')
                              console.log(this.FinalizarSeleccionada) 
                                if(this.FinalizarSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_hoy-- 
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_hoy--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Correo'){                                
                                this.contador_correos_hoy--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_hoy--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_hoy--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Skype'){                               
                                this.contador_skype_hoy--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_hoy--
                              }
                            }

                            if(this.FinalizarSeleccionada.fecha < this.fecha_buscar){
                              console.log('es fecha anterior')
                              console.log(this.FinalizarSeleccionada) 
                                if(this.FinalizarSeleccionada.forma_contacto == 'Visita'){                
                                this.contador_visitas_pendientes-- 
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Llamada'){                                
                                this.contador_llamadas_pendientes--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Correo'){                                
                                this.contador_correos_pendientes--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'VideoConferencia'){                               
                                this.contador_videoConferencia_pendientes--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Whatsapp'){                                
                                this.contador_whatsapp_pendientes--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Skype'){                               
                                this.contador_skype_pendientes--
                              }else if(this.FinalizarSeleccionada.forma_contacto == 'Twitter'){                                
                                this.contador_twitter_pendientes--
                              }
                            }

                            this.FinalizarSeleccionada = {}
                          axios.post('./agendaConcentradoCita', {
                            vendedor: 1
                          }).then(response => {
                            this.events = response.data
                            this.BanderaAxios = false
                          }).catch(e => {
                              console.log(e);
                              this.BanderaAxios = false
                          });
  
                        }).catch(e => {
                            console.log(e);
                            this.BanderaAxios = false
                        });                       
                    
                    
                  }

                },
                mounted () {                  
                  axios
                    .post('./obtenerOportunidadesLista')
                    .then(response => {                    
                      this.ListaClientes = response.data
                    })
                    .catch(error => {
                      console.log(error) 
                      this.errored = true
                    })
  
                    axios
                    .post('./obtenerProspectos')
                    .then(response => {                    
                      this.ListaProspecto = response.data
                    })
                    .catch(error => {
                      console.log(error)
                      this.errored = true
                    })

                    axios
                    .get('./obtenerFecha_actual')
                    .then(response => {                    
                      this.fecha_actual = response.data                                      
                      var fecha_f_dateParts = this.fecha_actual.split("-")
                      console.log(fecha_f_dateParts)
                      console.log(fecha_f_dateParts[0])
                      console.log(fecha_f_dateParts[1])
                      console.log(fecha_f_dateParts[2])
                      this.fecha_buscar = fecha_f_dateParts[2] +"-"+ fecha_f_dateParts[1] +"-"+ fecha_f_dateParts[0]
                      console.log(this.fecha_buscar)
                    })
                    .catch(error => {
                      console.log(error)
                      this.errored = true
                    })              
                      
                    axios.post('./agendaConcentradoCita', {
                        vendedor: 1
                      }).then(response => {
                        this.events = response.data
                        this.BanderaAxios = false
                      }).catch(e => {
                          console.log(e);
                          this.BanderaAxios = false
                      });

                    axios.post('./agendaConcentradoCheckIn', {
                        vendedor: 1
                      }).then(response => {
                        this.eventos_checkin = response.data

                      }).catch(e => {
                          console.log(e);
                      });
                    
                    axios.post('./agendaContadorCitasDiaHoy', {
                        vendedor: 1
                      }).then(response => {
                        this.contador_visitas_hoy = response.data.visita
                        this.contador_llamadas_hoy = response.data.llamada
                        this.contador_correos_hoy = response.data.correo
                        this.contador_videoConferencia_hoy = response.data.videoconferencia
                        this.contador_whatsapp_hoy = response.data.whatsapp
                        this.contador_skype_hoy = response.data.skype
                        this.contador_twitter_hoy = response.data.twitter
                      }).catch(e => {
                          console.log(e);
                      });

                    axios.post('./agendaContadorCitasPendientes', {
                        vendedor: 1
                      }).then(response => {
                        this.contador_visitas_pendientes = response.data.visita
                        this.contador_llamadas_pendientes = response.data.llamada
                        this.contador_correos_pendientes = response.data.correo
                        this.contador_videoConferencia_pendientes = response.data.videoconferencia
                        this.contador_whatsapp_pendientes = response.data.whatsapp
                        this.contador_skype_pendientes = response.data.skype
                        this.contador_twitter_pendientes = response.data.twitter
                      }).catch(e => {
                          console.log(e);
                      });
                                     
                    
                }
              
              }
</script>
<style>
.vuecal__cell-events-count {background-color: #4eb254;}

    .crear-cita-header{
      background-color: #4eb254;
      border: 1px solid #4eb254;
      color: #fff;
    }
    .borrar-cita-header{
      background-color: #bb3434;
      border: 1px solid #bb3434;
      color: #fff;
    }
    .vuecal__event.personal {
      background-color: rgba(253, 156, 66, 0.9);
      border: 1px solid rgb(233, 136, 46);
      color: #fff;
    }
    .personal {
      background-color: rgba(253, 156, 66, 0.9);
      border: 1px solid rgb(233, 136, 46);
      color: #fff;
    }
    .vuecal__event.cliente {
      background-color: #4eb254;
      border: 1px solid #4eb254;
      color: #fff;
    }
    .cliente {
      background-color: #4eb254;
      border: 1px solid #4eb254;
      color: #fff;
    }
    .vuecal__event.prospecto {
      background-color: #bc67ff;
      border: 1px solid #bc67ff;
      color: #fff;
    }
    .prospecto {
      background-color: #bc67ff;
      border: 1px solid #bc67ff;
      color: #fff;
    }

    .vuecal__event.finalizado {
      background-color: #41bbf3;
      border: 1px solid #41bbf3;
      color: #fff;
    }
    .finalizado {
      background-color: #41bbf3;
      border: 1px solid #41bbf3;
      color: #fff;
    } 

  
    .modal-mask {
      position: fixed;
      z-index: 9998;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, .5);
      display: table;
      transition: opacity .3s ease;
    }
  
    .modal-wrapper {
      display: table-cell;
      vertical-align: middle;
    }
  
    .modal-container {
      width: 400px;
      margin: 0px auto;
      padding: 20px 30px;
      background-color: #fff;
      border-radius: 2px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
      transition: all .3s ease;
      font-family: Helvetica, Arial, sans-serif;
      overflow-y: auto;
      max-height: 700px;
    }
  
    .modal-header h3 {
      margin-top: 0;
      color: #42b983;
    }
  
    .modal-body {
      margin: 20px 0;
    }
  
    .modal-default-button {
      float: right;
    }
  
    .modal-enter {
      opacity: 0;
    }
  
    .modal-leave-active {
      opacity: 0;
    }
  
    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
      -webkit-transform: scale(1.1);
      transform: scale(1.1);
    }
  </style>