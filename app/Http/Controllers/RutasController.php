<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Oportunidades;

use App\Oportunidad_Piloto;

use App\InfoRuta;

use App\Bitacora_Ruta;

use DB;

class RutasController extends Controller
{
    //
    public function index()
    {
        return view('promotor.rutas.index');
    }

    public function obtenerRuta(Request $request){
        $NumeroRuta = $request->id_ruta;
        $registro_ruta = [];
        $contador_ruta = 0;
        $origen = '';
        $destino = '';

        $rutas = DB::connection()->select("SELECT * FROM oportunidad_piloto WHERE numero_ruta like '$NumeroRuta' ORDER BY orden_ruta ASC");

        foreach ($rutas as $constructor) {
            $dato = $constructor;
            //dd($dato);
            if($contador_ruta == 0){
                $origen = $dato->latitud.",".$dato->longitud;
                $location = ['lat' => (float)$dato->latitud,'lng' => (float)$dato->longitud];
                $location  = (object)$location;
                $registro_ruta[$contador_ruta] = ['location' => $location, 'stopover' => true];
                $contador_ruta++;
            }else{                      
                $destino = $dato->latitud.",".$dato->longitud;
                $location = ['lat' => (float)$dato->latitud,'lng' => (float)$dato->longitud];
                $location  = (object)$location;
                $registro_ruta[$contador_ruta-1] = ['location' => $location, 'stopover' => true];
                $contador_ruta++; 
            }
        }//fin foreach
        $datos = [
                'registro_gps' => $rutas, 
                'registro_rutas' => $registro_ruta,
                'origen' => $origen,
                'destino' => $destino];                           
        return response()->json(
            $datos
            );
    }//fin obtenerRuta

    public function obtenerListadoRuta(Request $request){
        $NumeroPromotor = 1;
        $lista_rutas = DB::connection()->select("SELECT * FROM inforuta WHERE id_promotor like '$NumeroPromotor' ORDER BY numero_ruta ASC");                        
        return response()->json(
            $lista_rutas
            );
    }//fin obtenerListadoRuta

    public function buscarRutaIniciada(Request $request){
        $NumeroPromotor = 1;
        $ruta_iniciada = DB::connection()->select("SELECT * FROM inforuta WHERE id_promotor like '$NumeroPromotor' AND estatus like 'En proceso' ");                        
        return response()->json(
            $ruta_iniciada[0]
            );
    }//fin obtenerListadoRuta

    public function iniciarRuta(Request $request){
        $idRuta = $request->id_ruta;
        date_default_timezone_set('America/Mexico_City');
        $fechaactual= date("Y-m-d");
        $horaactual= date("H:i:s");
        //actualizar estado de encuesta
        $rutaInfo = InfoRuta::find($idRuta);
        if($rutaInfo->fecha_inicio == null){
            $rutaInfo->fecha_inicio = $fechaactual;
        }
        if($rutaInfo->hora_inicio == null){
            $rutaInfo->hora_inicio = $horaactual;
        }
        $rutaInfo->estatus = 'En proceso';
        $rutaInfo->save();
        return 'Inicio Ruta';
    }

    public function pausarRuta(Request $request){
        $idRuta = $request->id_ruta;
        date_default_timezone_set('America/Mexico_City');
        $fechaactual= date("Y-m-d");
        $horaactual= date("H:i:s");
        //actualizar estado de encuesta
        $rutaInfo = InfoRuta::find($idRuta);
        $rutaInfo->estatus = 'En pausa';
        $rutaInfo->save();
        return 'Pausa Ruta';
    }

}
