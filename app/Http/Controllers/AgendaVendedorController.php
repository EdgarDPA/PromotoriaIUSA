<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use DB;
use App\Agenda;
use App\AgendaEvidencia;

class AgendaVendedorController extends Controller
{
    public function fecha_actual()
    {
		$fechaActual = date('d-m-Y');
		return response()->json(
	        $fechaActual
	        );
	} 

    public function GuardarCita(Request $request){
        //$request->cita = json_decode($request->cita);	
        //dd($request);
        //$cita = $request->cita;
        $clase_cita = $request->class;
        if($request->grupal == 1){
            $clase_cita = "cita_grupal_anfitrion";
        }
        $cita_en_bd = new Agenda();
        $cita_en_bd->start = $request->start;
        $cita_en_bd->end = $request->end;
        $cita_en_bd->title = $request->title;
        $cita_en_bd->content = $request->content;
        $cita_en_bd->class = $clase_cita;
        $cita_en_bd->cliente = $request->cliente;
        $cita_en_bd->nombre_cliente = $request->nombre_cliente;
        $cita_en_bd->lat_cliente = $request->lat_cliente;
        $cita_en_bd->lon_cliente = $request->lon_cliente;
        $cita_en_bd->email_cliente = $request->cliente_email;
        $cita_en_bd->forma_contacto = $request->cliente_forma;
        $cita_en_bd->objetivo_contacto = $request->cliente_objetivo;
        $cita_en_bd->tipo_cita = $request->tipo_cita;
        $cita_en_bd->descripcion_detalle = $request->descripcion_detalle;
        $cita_en_bd->fecha = $request->fecha;
        $cita_en_bd->hora_inicio = $request->hora_inicio;
        $cita_en_bd->hora_fin = $request->hora_fin;
        $cita_en_bd->vendedor = 1;
        $cita_en_bd->cita_grupal = $request->grupal;   
        $cita_en_bd->anfitrion = $request->vendedor;     
        $cita_en_bd->invitados = $request->envioDestinatarios;
        $cita_en_bd->save();
        $id_nuevo = $cita_en_bd->id;

        if($request->file('Evidencia')){
            $file = $request->file('Evidencia');
            $nombre = 'img/agenda/'.$id_nuevo.'/'.$file->getClientOriginalName();
            $path = public_path().'/img/agenda/'.$id_nuevo;
            $file->move($path, $nombre);
            $evidencia = new AgendaEvidencia();
            $evidencia->foto =  $nombre;
            $evidencia->seccion =  'check-in';
            $evidencia->agenda_id =  $id_nuevo;
            $evidencia->save();
        }
    
        if($request->grupal == 1){
            $clase_cita = "cita_grupal";
            $lista_destinatarios = $request->envioDestinatarios;            
            $array_destinatarios = explode(",", $lista_destinatarios);
            $contador_destinatarios = count($array_destinatarios);
            $contador_destinatarios--;
            $id_invitados = "";
            for ($i=0; $i < $contador_destinatarios ; $i++) { 
                $usuario_invitado = $array_destinatarios[$i];

                $cita_invitado = new Agenda();
                $cita_invitado->start = $request->start;
                $cita_invitado->end = $request->end;
                $cita_invitado->title = $request->title;
                $cita_invitado->content = $request->content;
                $cita_invitado->class = $clase_cita;
                $cita_invitado->cliente = $request->cliente;
                $cita_invitado->nombre_cliente = $request->nombre_cliente;
                $cita_invitado->lat_cliente = $request->lat_cliente;
                $cita_invitado->lon_cliente = $request->lon_cliente;
                $cita_invitado->tel_cliente = $request->cliente_tel;
                $cita_invitado->email_cliente = $request->cliente_email;
                $cita_invitado->forma_contacto = $request->cliente_forma;
                $cita_invitado->objetivo_contacto = $request->cliente_objetivo;
                $cita_invitado->tipo_cita = $request->tipo_cita;
                $cita_invitado->descripcion_detalle = $request->descripcion_detalle;
                $cita_invitado->fecha = $request->fecha;
                $cita_invitado->hora_inicio = $request->hora_inicio;
                $cita_invitado->hora_fin = $request->hora_fin;
                $cita_invitado->vendedor = $usuario_invitado;
                $cita_invitado->cita_grupal = 1;
                $cita_invitado->id_cita_grupal = $id_nuevo;
                $cita_invitado->anfitrion = $request->vendedor;  
                $cita_invitado->invitados = $lista_destinatarios;
                
                $cita_invitado->save();

                $id_cita_i = $cita_invitado->id;
                $id_cita_i1 = (string)$id_cita_i;

                $id_invitado1 = $id_cita_i1.",";
                $id_invitados = $id_invitados.$id_invitado1;
            }

            $guardar_invitados_id = Agenda::find($id_nuevo);
            $guardar_invitados_id->id_invitados = $id_invitados;
            $guardar_invitados_id->save();

        }

        return response()->json(
            $cita_en_bd
            );
    }
    public function ConcentradoCita(Request $request){
        //dd($request);
        $vendedor = $request->vendedor;
        $citas_asociados = Agenda::all()->where('vendedor',$vendedor)->where('cancelado','!=',1);
        $citas_asociados_query = $citas_asociados->values();
        $citas_asociados_query->all();
        return response()->json(
            $citas_asociados_query
            );
    }
    public function ConcentradoCitaXDia(Request $request){
        //dd($request);
        $vendedor = $request->vendedor;
        $fecha = $request->fecha;
        $citas_asociados = Agenda::all()->where('vendedor',$vendedor)->where('fecha',$fecha)->where('cancelado','!=',1);
        $citas_asociados_query = $citas_asociados->values();
        $citas_asociados_query->all();
        return response()->json(
            $citas_asociados_query
            );
    }
    public function BorrarCita(Request $request){
        //dd($request);
        $id_cita = $request->cita_id;
        $citas = Agenda::find($id_cita);
        $citas->cancelado = 1;
        $citas->motivo_cancelacion = $request->motivo;
        $cita_grupal = $citas->cita_grupal;
        $lista_invitados = $citas->id_invitados;
        $citas->save();

        if($cita_grupal== 1)
        {
            $array_destinatarios = explode(",", $lista_invitados);
            $contador_destinatarios = count($array_destinatarios);
            $contador_destinatarios--;
            for ($i=0; $i < $contador_destinatarios ; $i++) { 
                $usuario_invitado = $array_destinatarios[$i];
                $cita_invitado = Agenda::find($id_cita);
                $cita_invitado->cancelado = 1;
                $cita_invitado->motivo_cancelacion = $request->motivo;
                $citas->save();
            }            

        }
        $ok = ['mensaje' => 'ok'];
       return response()->json(
        $ok
        );
    }

    public function obtenerEvidenciaCita(Request $request){
        //dd($request);
        $id_cita = $request->cita_id;
        $evidencia = AgendaEvidencia::all()->where('agenda_id',$id_cita);
        $contador_check_in = 0;
        $contador_check_out = 0;
        foreach ($evidencia as $constructor) {
            $dato = $constructor;
            if($dato->seccion == 'check-in'){
                $contador_check_in++;
            }
            if($dato->seccion == 'check-out'){
                $contador_check_out++;
            }
        }
        $count_evidencia = count($evidencia);
        $datos = ['datos' => $evidencia, 'conteo_checkin' => $contador_check_in,'conteo_checkout' => $contador_check_out];
        return response()->json(
            $datos
            );
    }

    public function ActivarCheckIn(Request $request){
        //dd($request);
        $fechahoy = date('d-m-Y');
        $hora = date('G:i:s');
     
        $lat = round($request->lat, 6);
        $lng = round($request->lng, 6); 
        $id_cita = $request->cita_id;

        $citas = Agenda::find($id_cita);
        $citas->checkin = 1;
        $citas->fecha_checkin = $fechahoy;
        $citas->hora_checkin = $hora;
        $citas->lat_checkin = $lat;
        $citas->lng_checkin = $lng;
        $citas->save();
        $ok = ['mensaje' => 'ok'];
       return response()->json(
        $ok
        );
    }

    public function ConcentradoCheckIn(Request $request){
        //dd($request);
        $vendedor = $request->vendedor;
        $citas_asociados = Agenda::all()->where('vendedor',$vendedor)->where('checkin',1)->where('checkout','!=',1)->where('cancelado','!=',1);
        $citas_asociados_query = $citas_asociados->values();
        $citas_asociados_query->all();
        return response()->json(
            $citas_asociados_query
            );
    }

    public function ConcentradoVisitas(Request $request){
        
        $fechahoy = date('Y-m-d');
        //dd($fechahoy);
        $vendedor = $request->vendedor;
        $citas_asociados = Agenda::all()->where('vendedor',$vendedor)->where('fecha',$fechahoy)->where('checkin','!=',1)->where('checkout','!=',1)->where('cancelado','!=',1);
        $citas_asociados_query = $citas_asociados->values();
        $citas_asociados_query->all();
        //dd($citas_asociados_query);
        return response()->json(
            $citas_asociados_query
            );
    }

    public function ConcentradoVisitasHoy(Request $request){
        //dd($request);
        $fechahoy = date('d-m-Y');
        $vendedor = $request->vendedor;
        $citas_asociados = Agenda::all()->where('vendedor',$vendedor)
        ->where('fecha',$fechahoy)
        ->where('forma_contacto','Visita')
        ->where('checkin','!=',1)
        ->where('checkout','!=',1)
        ->where('cancelado','!=',1);
        
        $citas_asociados_query = $citas_asociados->values();
        $citas_asociados_query->all();
        return response()->json(
            $citas_asociados_query
            );
    }

    public function ActivarCheckOut(Request $request){
        //dd($request);
        $fechahoy = date('d-m-Y');
        $hora = date('G:i:s');
     
        $lat = round($request->lat, 6);
        $lng = round($request->lng, 6); 
        $id_cita = $request->cita_id;
        $decripcion_final = $request->descripcion_final;

        $citas = Agenda::find($id_cita);
        $citas->class = 'finalizado';
        $citas->checkout = 1;
        $citas->fecha_checkout = $fechahoy;
        $citas->hora_checkout = $hora;
        $citas->lat_checkout = $lat;
        $citas->lng_checkout = $lng;
        $citas->finalizo = 1;
        $citas->observacion_final = $decripcion_final;
        $citas->save();

        if($request->file('evidencia_final')){
            $file = $request->file('evidencia_final');
            $nombre = 'img/agenda/'.$id_cita.'/'.$file->getClientOriginalName();
            $path = public_path().'/img/agenda/'.$id_cita;
            $file->move($path, $nombre);
            $evidencia = new AgendaEvidencia();
            $evidencia->foto =  $nombre;
            $evidencia->seccion =  'check-out';
            $evidencia->agenda_id =  $id_cita;
            $evidencia->save();
            }
            $ok = ['mensaje' => 'ok'];
       return response()->json(
        $ok
        );
    }

    public function ActivarFinalizarTarea(Request $request){
       // dd($request);
        $fechahoy = date('d-m-Y');
        $hora = date('G:i:s');

        $id_cita = $request->cita_id;
        $decripcion_final = $request->descripcion_final;

        $citas = Agenda::find($id_cita);
        $citas->class = 'finalizado';
        $citas->finalizo = 1;
        $citas->observacion_final = $decripcion_final;
        $citas->save();

        if($request->file('Evidencia_final')){
            $file = $request->file('Evidencia_final');
            $nombre = 'img/agenda/'.$id_cita.'/'.$file->getClientOriginalName();
            $path = public_path().'/img/agenda/'.$id_cita;
            $file->move($path, $nombre);
            $evidencia = new AgendaEvidencia();
            $evidencia->foto =  $nombre;
            $evidencia->seccion =  'check-out';
            $evidencia->agenda_id =  $id_cita;
            $evidencia->save();
            }
            $ok = 'ok';
            return response()->json(
                $ok
                );
    }

    

    public function ContadorCitasDiaHoy(Request $request){
        $fechahoy = date('d-m-Y');
        $vendedor = $request->vendedor;
        $citas_de_hoy = Agenda::all()->where('vendedor',$vendedor)->where('fecha',$fechahoy)->where('finalizo','!=',1)->where('cancelado','!=',1);
        $citas_de_hoy_query = $citas_de_hoy->values();
        $citas_de_hoy_query->all();
        $contador_visitas = 0;
        $contador_llamadas = 0;
        $contador_correos = 0;
        $contador_videoconferencias = 0;
        $contador_whatsapp = 0;
        $contador_skype = 0;
        $contador_twitter = 0;

        foreach ($citas_de_hoy_query as $constructor) {
            $dato = $constructor;
            if($dato->forma_contacto == 'Visita'){
                $contador_visitas++;
            }
            if($dato->forma_contacto == 'Llamada'){
                $contador_llamadas++;
            }
            if($dato->forma_contacto == 'Correo'){
                $contador_correos++;
            }
            if($dato->forma_contacto == 'VideoConferencia'){
                $contador_videoconferencias++;
            }
            if($dato->forma_contacto == 'Whatsapp'){
                $contador_whatsapp++;
            }
            if($dato->forma_contacto == 'Skype'){
                $contador_skype++;
            }
            if($dato->forma_contacto == 'Twitter'){
                $contador_twitter++;
            }
        }
        $datos = ['visita' => $contador_visitas, 'llamada' => $contador_llamadas,'correo' => $contador_correos,'videoconferencia' => $contador_videoconferencias, 'whatsapp' => $contador_whatsapp,'skype' => $contador_skype,'twitter' => $contador_twitter];
       
        return response()->json(
            $datos
            );
    }

    public function ContadorCitasPendientes(Request $request){
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, 02, 2020); 
        
        $fechahoy = date('d-m-Y');
        $vendedor = $request->vendedor;
        $citas_de_hoy = Agenda::all()->where('vendedor',$vendedor)->where('fecha','<',$fechahoy)->where('finalizo','!=',1)->where('cancelado','!=',1);
        $citas_de_hoy_query = $citas_de_hoy->values();
        $citas_de_hoy_query->all();
        $contador_visitas = 0;
        $contador_llamadas = 0;
        $contador_correos = 0;
        $contador_videoconferencias = 0;
        $contador_whatsapp = 0;
        $contador_skype = 0;
        $contador_twitter = 0;

        foreach ($citas_de_hoy_query as $constructor) {
            $dato = $constructor;
            if($dato->forma_contacto == 'Visita'){
                $contador_visitas++;
            }
            if($dato->forma_contacto == 'Llamada'){
                $contador_llamadas++;
            }
            if($dato->forma_contacto == 'Correo'){
                $contador_correos++;
            }
            if($dato->forma_contacto == 'VideoConferencia'){
                $contador_videoconferencias++;
            }
            if($dato->forma_contacto == 'Whatsapp'){
                $contador_whatsapp++;
            }
            if($dato->forma_contacto == 'Skype'){
                $contador_skype++;
            }
            if($dato->forma_contacto == 'Twitter'){
                $contador_twitter++;
            }
        }
        $datos = ['visita' => $contador_visitas, 'llamada' => $contador_llamadas,'correo' => $contador_correos,'videoconferencia' => $contador_videoconferencias, 'whatsapp' => $contador_whatsapp,'skype' => $contador_skype,'twitter' => $contador_twitter];
       
        return response()->json(
            $datos
            );
    }
/*-----------------------------------------------------
---------  metodos de Reporte de Agenda ---------*/
    public function ResumenActividadDirectivo()
    {
        return view('directivo.Agenda.reporte_resumen_actividad');
    }

    public function ResumenActividadGerente()
    {
        return view('gerente.Agenda.reporte_resumen_actividad');
    }

    public function ResumenActividadUno(Request $request){
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, 02, 2020); 
        
        $fechahoy = date('d-m-Y');
        $vendedor = $request->user;
        $historial_citas = Agenda::all()->where('vendedor',$vendedor);
        $historial_citas_query = $historial_citas->values();
        $historial_citas_query->all();
        $citas_total = count($historial_citas_query);
       // dd($citas_total);
        $contador_visitas = 0;
        $contador_llamadas = 0;
        $contador_correos = 0;
        $contador_videoconferencias = 0;
        $contador_whatsapp = 0;
        $contador_skype = 0;
        $contador_twitter = 0;
        $contador_borradas = 0;
        $contador_personal = 0;
        foreach ($historial_citas_query as $constructor) {
            $dato = $constructor;
            if($dato->cancelado == 1){
                $contador_borradas++;
            }else{
                if($dato->tipo_cita == "Cita personal"){
                    $contador_personal++;
                }else{
                    if($dato->forma_contacto == 'Visita'){
                        $contador_visitas++;
                    }
                    if($dato->forma_contacto == 'Llamada'){
                        $contador_llamadas++;
                    }
                    if($dato->forma_contacto == 'Correo'){
                        $contador_correos++;
                    }
                    if($dato->forma_contacto == 'VideoConferencia'){
                        $contador_videoconferencias++;
                    }
                    if($dato->forma_contacto == 'Whatsapp'){
                        $contador_whatsapp++;
                    }
                    if($dato->forma_contacto == 'Skype'){
                        $contador_skype++;
                    }
                    if($dato->forma_contacto == 'Twitter'){
                        $contador_twitter++;
                    }
                }
            }
        }
       
        $datos = [
            'total' => $citas_total, 
            'visita' => $contador_visitas, 
            'llamada' => $contador_llamadas,
            'correo' => $contador_correos,
            'videoconferencia' => $contador_videoconferencias, 
            'whatsapp' => $contador_whatsapp,
            'skype' => $contador_skype,
            'twitter' => $contador_twitter,
            'personal' => $contador_personal,
            'canceladas' => $contador_borradas,
        ];
       
        return response()->json(
            $datos
            );
    }

    public function ResumenActividadVendedoresGerente(Request $request){
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, 02, 2020); 
        
        $fechahoy = date('d-m-Y');
        $gerente = $request->idGerente;

        try {
            $servicio="http://172.16.171.10/webservices/PGC360_Pro_GteVen/GteVen.asmx?WSDL"; //url del servicio 
            $parametros=array(); //parametros de la llamada
            $parametros['P_GERENTE']="$gerente";   
            $client = new SoapClient($servicio,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
            $result = $client->Vb_Basecliente($parametros);//llamamos al métdo que nos interesa con los parámetros
            $result = obj2array($result);
            $noticias=$result['Vb_BaseclienteResult']['MyResultData'];
            $ListaVendedores = collect($noticias);
            } catch (Exception $e) {
                trigger_error($e->getMessage(), E_USER_WARNING);
            }//fin de try webservice

        $count_vendedores = count($ListaVendedores);

        for($i = 0; $i < $count_vendedores -1; $i++){
            $vendedor = $ListaVendedores[$i];
            $numero_vendedor = $vendedor['PERNR'];
            $nombre_vendedor = $vendedor['NAME1'];
        

            $historial_citas = Agenda::all()->where('vendedor',$numero_vendedor);
            $historial_citas_query = $historial_citas->values();
            $historial_citas_query->all();
            $citas_total = count($historial_citas_query);
            
            $contador_visitas = 0;
            $contador_llamadas = 0;
            $contador_correos = 0;
            $contador_videoconferencias = 0;
            $contador_whatsapp = 0;
            $contador_skype = 0;
            $contador_twitter = 0;
            $contador_borradas = 0;
            $contador_personal = 0;
            foreach ($historial_citas_query as $constructor) {
                $dato = $constructor;
                if($dato->cancelado == 1){
                    $contador_borradas++;
                }else{
                    if($dato->tipo_cita == "Cita personal"){
                        $contador_personal++;
                    }else{
                        if($dato->forma_contacto == 'Visita'){
                            $contador_visitas++;
                        }
                        if($dato->forma_contacto == 'Llamada'){
                            $contador_llamadas++;
                        }
                        if($dato->forma_contacto == 'Correo'){
                            $contador_correos++;
                        }
                        if($dato->forma_contacto == 'VideoConferencia'){
                            $contador_videoconferencias++;
                        }
                        if($dato->forma_contacto == 'Whatsapp'){
                            $contador_whatsapp++;
                        }
                        if($dato->forma_contacto == 'Skype'){
                            $contador_skype++;
                        }
                        if($dato->forma_contacto == 'Twitter'){
                            $contador_twitter++;
                        }
                    }
                }
            }
        
            $datos[$i] = [
                'numero_vendedor' => $numero_vendedor,
                'nombre_vendedor' => $nombre_vendedor,
                'total' => $citas_total, 
                'visita' => $contador_visitas, 
                'llamada' => $contador_llamadas,
                'correo' => $contador_correos,
                'videoconferencia' => $contador_videoconferencias, 
                'whatsapp' => $contador_whatsapp,
                'skype' => $contador_skype,
                'twitter' => $contador_twitter,
                'personal' => $contador_personal,
                'canceladas' => $contador_borradas,
            ];

        }//fin for
       
        return response()->json(
            $datos
            );
    }

    public function ConsultarCita(Request $request){
        //dd($request);        
        $id_cita = $request->cita_id;
        $citas = Agenda::find($id_cita); 
        
        return response()->json(
            $citas
            );
    }


}
