<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OrdenCompra;

use App\Orden_Compra_Detalle;

use SoapClient;

class OrderManagementController extends Controller
{
    public function index(){
        return view('promotor.orders_management.index');
    }

    public function obtenerOrden(Request $request){
        $promotor_id = 3;
        $oportunidades = OrdenCompra::where('id_promotor',$promotor_id)->get();
        return response()->json(
          $oportunidades
        );
      }

    public function obtenerDetalleOrden(Request $request){
        //dd($request);
        $orden_id = $request->id;
        $oportunidades_detalle = Orden_Compra_Detalle::where('orden_compra_id',$orden_id)->get();
        return response()->json(
            $oportunidades_detalle
        );
    }

}
