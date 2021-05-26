<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OrdenCompra;

use App\Orden_Compra_Detalle;

use App\Distribuidores;

use SoapClient;

use Mail;

class OrderManagementController extends Controller
{
    public function index(){
        return view('promotor.orders_management.index');
    }

    public function obtenerOrden(Request $request){
        $promotor_id = 1;
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

    public function obtenerInfoDistribuidor(Request $request){
       // dd($request);
        function obj2array($obj) {
            $out = array();
            foreach ($obj as $key => $val) {
              switch(true) {
                  case is_object($val):
                    $out[$key] = obj2array($val);
                    break;
                case is_array($val):
                    $out[$key] = obj2array($val);
                    break;
                default:
                  $out[$key] = $val;
              }
            }
            return $out;
          }//fin funcion obj2arra
        $distribuidor_id = $request->id;
        if($request->tipo == 'IUSA'){
            try {
                //$servicio="http://172.16.176.25/WebServices/PGC360_Des_Cliente_Datosgrales/Cliente_Datosgrales.asmx?WSDL";
                $servicio="http://172.16.171.10/WebServices/PGC360_Pro_Cliente_Datosgrales/Cliente_Datosgrales.asmx?WSDL";  
                $parametros=array();
                $parametros['Username']="facastillo";
                $parametros['KKBER']="217";
                $parametros['KUNNR1']="$distribuidor_id";                
                $parametros['VKORG']='IUS2';
                $parametros['VTWEG']='PR';
                $client = new SoapClient($servicio,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
                $result = $client->Vb_Cliente_Datosgrales($parametros);
                $result = obj2array($result);
                $noticias=$result['Vb_Cliente_DatosgralesResult']['MyResultData'];
                $collection = collect($noticias);
                $cliente_datos = $collection->first(); 
                } catch (Exception $e) {
                    trigger_error($e->getMessage(), E_USER_WARNING);
                }
                //dd($cliente_datos);
            return response()->json(
                $cliente_datos['SMTP_ADDR']
            );
        }
        if($request->tipo == 'Otro'){
            $distribuidor =  Distribuidores::find($distribuidor_id);
            $distribuidor_correo = $distribuidor->correo;
            if($distribuidor_correo == null){
                $distribuidor_correo = '';
            }
            return response()->json(
              $distribuidor_correo
                ); 
        }
        if($request->tipo == null){
            $mensaje = 'error';
            return response()->json(
              $mensaje
                ); 
        }
            
    }

    public function envioOrdenEmail(Request $request){
        //dd($request);
        $orden_id = $request->id;
        $correo = $request->correo;
        $oportunidad = OrdenCompra::where('id',$orden_id)->get();
        $oportunidades_detalle = Orden_Compra_Detalle::where('orden_compra_id',$orden_id)->get();
        //dd($oportunidad);
        
        try{
            $data["email"]="$correo";
            $data["client_name"]="Daniel";
            $data["subject"]="Orden de Compra";

                Mail::send('mails.edocuenta_call', $data, function($message)use($data) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"]);
                //->attachData($pdf->output(), "edocuenta.pdf");
                });
                return "Correo enviado";
          } catch (Exception $e) {
            return "Error en el envio de correo, verifique la dirección e intentelo mas tarde";
          } 

        
    }

}
