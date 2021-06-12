<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Distribuidores;

use App\Encuesta;

use App\Oportunidad_Piloto;

class EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('promotor.encuestas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        //guardar distribuidores
        $listaD = $request->distribuidores;
        foreach($listaD as $infoLista){
          $nuevo_distribuidor = new Distribuidores();
        
          $nuevo_distribuidor->nombre = $infoLista['nombre'];
          $nuevo_distribuidor->idIusa = $infoLista['idIusa'];
          $nuevo_distribuidor->tipo = $infoLista['tipo'];
          $nuevo_distribuidor->direccion = $infoLista['direccion'];
          $nuevo_distribuidor->telefono = $infoLista['telefono'];
          $nuevo_distribuidor->correo = $infoLista['correo'];
          $nuevo_distribuidor->cp = $infoLista['cp'];
          $nuevo_distribuidor->calificacion = $infoLista['calificacion'];
          $nuevo_distribuidor->id_oportunidad = $request->idOportunidad;
          $nuevo_distribuidor->save();
        }
        //guardar encuesta
        $nueva_encuesta= new Encuesta();
        $nueva_encuesta->pregunta1 = $request->pregunta1;
        $nueva_encuesta->pregunta2 = $request->pregunta2;
        $nueva_encuesta->pregunta3 = $request->pregunta3;
        $nueva_encuesta->pregunta4 = $request->pregunta4;
        $nueva_encuesta->pregunta5 = $request->pregunta5;
        $nueva_encuesta->pregunta6 = $request->pregunta6;
        $nueva_encuesta->pregunta7 = $request->pregunta7;
        $nueva_encuesta->pregunta8 = $request->pregunta8;
        $nueva_encuesta->pregunta9 = $request->pregunta9;
        $nueva_encuesta->pregunta10 = $request->pregunta10;
        $nueva_encuesta->id_oportunidad = $request->idOportunidad;
        $nueva_encuesta->save();

        //actualizar estado de encuesta
        $actualizar_oportunidad = Oportunidad_Piloto::find($request->idOportunidad);
        $actualizar_oportunidad->bandera_encuesta = 1;
        $actualizar_oportunidad->save();

        return 'guardado exitoso';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
