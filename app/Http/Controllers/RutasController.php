<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Oportunidades;

use App\Oportunidad_Piloto;

use App\InfoRuta;

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

}
