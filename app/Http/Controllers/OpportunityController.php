<?php

namespace App\Http\Controllers;

use App\Oportunidad_Piloto;

use App\Prospecto;

use Illuminate\Http\Request;



class OpportunityController extends Controller
{
    //
    public function index(){
        return view('promotor.opportunities.index');
    }

    public function obtenerOportunidades(Request $request){
        $oportunidades = Oportunidad_Piloto::where('id_promotor',1)->get();
        //dd($oportunidades);
        return response()->json(
            $oportunidades
              );
    }

    public function obtenerOportunidadesOrden(Request $request){
        $oportunidades = Oportunidad_Piloto::all()->where('id_promotor',1)->where('bandera_prospecto','!=',1); 
        $oportunidades_query = $oportunidades->values();
        $oportunidades_query->all();
        return response()->json(
            $oportunidades_query
              );
    }

    public function nuevoProspecto(Request $request){
        //dd($request);
        //guardar info en prospecto
        $nuevo_prospecto = new Prospecto();
        $nuevo_prospecto->nombre = $request->nombre;
        $nuevo_prospecto->rfc = $request->rfc;
        $nuevo_prospecto->contacto = $request->contacto;
        $nuevo_prospecto->direccion = $request->direccion;
        $nuevo_prospecto->telefono = $request->telefono;
        $nuevo_prospecto->correo = $request->correo;
        $nuevo_prospecto->referencia = $request->referencia;
        $nuevo_prospecto->antiguedad = $request->antiguedad;
        $nuevo_prospecto->ramo = $request->ramo;
        $nuevo_prospecto->mensualidad = $request->mensualidad;
        $nuevo_prospecto->transporte = $request->transporte;
        $nuevo_prospecto->mostrador = $request->mostrador;
        $nuevo_prospecto->notas = $request->notas;
        $nuevo_prospecto->idDistribuidor = $request->idDistribuidor;
        $nuevo_prospecto->nombreDistribuidor = $request->nombreDistribuidor;
        $nuevo_prospecto->latitud = $request->lat;
        $nuevo_prospecto->longitud = $request->lon;
        $nuevo_prospecto->id_oportunidad = $request->idOportunidad;
        $nuevo_prospecto->id_promotor = 1;
        $nuevo_prospecto->save();
        

        //actualizar la lista de Oportunidades
        $oportunidad = Oportunidad_Piloto::find($request->idOportunidad);
        $oportunidad->bandera_prospecto = 1;
        $oportunidad->save();

        return 'guardado exitoso';
    }//fin guardarOrden
    
}
