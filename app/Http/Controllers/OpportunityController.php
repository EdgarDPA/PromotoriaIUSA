<?php

namespace App\Http\Controllers;

use App\Oportunidades;

use Illuminate\Http\Request;



class OpportunityController extends Controller
{
    //
    public function index(){
        return view('promotor.opportunities.index');
    }

    public function obtenerOportunidades(Request $request){
        $oportunidades = Oportunidades::where('id_promotor',3)->get();
        //dd($oportunidades);
        return response()->json(
            $oportunidades
              );
    }
    
}
