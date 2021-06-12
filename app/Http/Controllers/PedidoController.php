<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OrdenCompra;

use App\Orden_Compra_Detalle;

use App\Oportunidades;

use App\Prospecto;

use App\Distribuidores;

use SoapClient;

use DB;

class PedidoController extends Controller
{
    public function index(){
        return view('promotor.pedidos.index');
    }

    public function consultarMaterial(Request $request){
        
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
  
           
        $usuario_vendedor = $request->usuario;
        $puesto=$request->puesto;
        $bandera_programado = $request->bandera_pedido_programado;
        $mat_recibido = $request->id_material;
        $cantidad_pedida = $request->num_unidades;   
  
        $cliente = $request->idCliente;
        $ID_lista = $request->id_lista;
        $mensage_error = "";//variable para mensage de errores 
        //completar el código de material a 18 digitos
        $n1=strlen($mat_recibido);
        $n1_aux=18-$n1;
        $mat="";
        for ($i=0; $i <$n1_aux ; $i++) { 
          $mat.="0";
        }
        $material=$mat.$mat_recibido;
        $VKORG = "IUS2";
        $VTWEG = "PR"; 
  
        
       
        //validacion si el material se encuentra en carretes
        try {
        //$servicio1="http://172.16.176.25/webservices/PGC360_Des_Carretes/Carretes.asmx?WSDL";
        $servicio1="http://172.16.171.10/webservices/PGC360_Pro_Carretes/Carretes.asmx?WSDL";
        
        $client1 = new SoapClient($servicio1,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
        $result1 = $client1->Vb_Carretes();
        $result1 = obj2array($result1);
        $noticias1=$result1['Vb_CarretesResult']['MyResultData'];
        $lista_carretes = collect($noticias1);
        } catch (Exception $e) {
        trigger_error($e->getMessage(), E_USER_WARNING);
        }
        $bandera_carrete = 0;
        foreach ($lista_carretes as $constructor) {
        $dato = $constructor;
        
        if($dato['MATNR'] == $material){
            $bandera_carrete = 1;
        }
        }
  
        //********* WEBSERVICE PARA MATERIALES Y EXISTENCIAS
        try {
  
        //$servicio5="http://172.16.176.25/webservices/PGC360_Des_Mater_Exist_Precios/Mater_Exist_Precios.asmx?WSDL"; //url del servicio
       // $servicio5="http://172.16.176.25/webservices/PGC360_Des_Mater_Exist_Precios2/Mater_Exist_Precios2.asmx?WSDL"; //url del servicio antiguo
       $servicio5="http://172.16.171.10/webservices/PGC360_Pro_Mater_Exist_Precios2/Mater_Exist_Precios2.asmx?WSDL"; //url del servicio antiguo
        $parametros5=array(); //parametros de la llamada
  
        $parametros5['VKBUR']="IU00";
        $parametros5['MATNR']="$material";
        $parametros5['KUNNR']="$cliente";
        $parametros5['VTWEG']="$VTWEG";
        $parametros5['VKORG']="$VKORG";
        $parametros5['CANT']="1";
         //dd($parametros5);
        $client5 = new SoapClient($servicio5,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
        $result5 = $client5->Vb_Mater_Exist_Precios2($parametros5);//llamamos al métdo que nos interesa con los parámetros  
        $result5 = obj2array($result5);
        $noticias5=$result5['Vb_Mater_Exist_Precios2Result']['MyResultData'];
        $collection = collect($noticias5);
        $collection = $collection->first();
        
        }catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
          }//fin del servicio
          //si obtubo un erro del ws
          //si hay cantidad menor a 1 
         // dd($collection);
          if ($cantidad_pedida <= 0) {
            $mensage_error = "Cantidad ingresada no debe ser cero";
             $cadena_result = [];
          }else if ($bandera_carrete == 1) {
            $mensage_error = "Codigo erroneo, producto asignado a carrete";
             $cadena_result = [];
          }else if ($collection['MYERR'] == 1 && $collection['FNMSG'] == 'Arithmetic operation resulted in an overflow.') {
            $mensage_error = "Codigo erroneo, revisar empaque, costo o bloqueos de cliente";
             $cadena_result = [];
          }else if ($collection['MYERR'] == 1) {
            $mensage_error = "Codigo erroneo, intente con otro codigo";
             $cadena_result = [];
          } else if ($collection == null) {
            $mensage_error = "Codigo no encontrado o erroneo";
             $cadena_result = [];
          }else{
            //obtener valores del WS resultado
            $codigo_material=$collection['MATNR'];
            $sucursal=$collection['VKBUR'];
            $aux_nombre=str_replace("\"", "",$collection['MAKTX']); 
            $aux_material_2=str_replace("'", "",$aux_nombre);
            $nombre_material=str_replace("#", "",$aux_material_2);
            $unidad_medida=$collection['MEINS'];
            $existencia=$collection['LABST'];
            $existencia_cdpt=$collection['LABS1'];
            $stock_transito=$collection['TRAME'];
            $empaque=$collection['BSTRF'];
  
            $empaqueLabel=$collection['BSTRF'];
  
            $importe=$collection['KBETR']; //ventas_presio
            $importe_descuento=$collection['PCDESC'];//presiodesc
            $importe_real=$collection['ZCOSTO3'];  
            $tipo_material=$collection['MAABC'];
            $error=$collection['MYERR'];
            $centro_informacion=$collection['WERKS'];
            //datos extra para alidaciones y guardar en bd 
            $descuento=$collection['PDPER'];//%descuento
            $ventas_centro=$collection['WERKS']; 
            $sector=$collection['SPART'];
            // fecha programada es del formulario
            $pormar=$collection['PORMAR'];//valores para valiaciones de credito
            $porcom=$collection['PROCOM'];//valores para valiaciones de credito
            $margen=$collection['ZCOSTO3'];
            $inventario=$collection['LABST'];
            //$inventario2=$collection['LABST1'];
            $ZK14=$collection['ZK14'];//
            $ZK71=$collection['ZK71'];
            $ZK73=$collection['ZK73'];//
            $ZK08=$collection['ZK08'];
            $ZK66=$collection['ZK66'];
            $ZK69=$collection['ZK69'];//
            $ZK25=$collection['ZK25'];
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $precio_lista=$collection['PLIST'];
  //margenes comerciales
          $sector_id=$collection['SPART'];
          //conparaciones de sector con el margen minimo que debe tener 
          $margen_minimo_definido = 13;//
          //VALORES PARA DETERMINAR SU GPOM4
          $id_gpom4 = $collection['GERPRO']; 
          $nombre_gpom4 = $collection['BEZEI'];
          $bandera_gpom4 = 0; 
    // comparacion si material empaque es = 1.111
  
    if ($empaque == "1.111") {
            $empaque = "1";
          }
    //si el empaque es igual a 0
      if ($empaque == "0.000" || $empaque == "0") {
        $cadena_result = [];
        $mensage_error = "Código de material con empaque de cero";
      }else{
          
          // Tabla de margen minimo defindo actualizada 30/09/2020
        if ($sector_id != "") {
          if ($sector_id == "00") {
            //Alta tension
            $margen_minimo_definido = 15;
          }else if ($sector_id == "05") {
            //ARTEFACTOS ELECTRIC.
            $margen_minimo_definido = 15;
          }else if ($sector_id == "11") {
            //LAMPARAS LED
            $margen_minimo_definido = 15;
          }else if ($sector_id == "12") {
            //MICROINVERSOR
            $margen_minimo_definido = 7;
          }else if ($sector_id == "13") {
            //PANEL
            $margen_minimo_definido = 7;
          }else if ($sector_id == "14") {
            //KIT SOLAR
            $margen_minimo_definido = 7;
          }else if ($sector_id == "20") {
            //COBRE Y ALEACIONES
            $margen_minimo_definido = 10;
          }else if ($sector_id == "30") {
            //CONDUCTORES
            $margen_minimo_definido = 10;
          }else if ($sector_id == "35") {
            //CONTROLES
            $margen_minimo_definido = 15;
          }else if ($sector_id == "36") {
            //CONTROLES FORGAMEX
            $margen_minimo_definido = 15;
          }else if ($sector_id == "37") {
            //TRANSFORMADORES
            $margen_minimo_definido = 10;
          }else if ($sector_id == "38") {
            //CALENTADORES
            $margen_minimo_definido = 15;
          }else if ($sector_id == "39") {
            //TINACOS
            $margen_minimo_definido = 15;
          }else if ($sector_id == "40") {
            //ELECTROCERAMICA
            $margen_minimo_definido = 13;
          }else if ($sector_id == "45") {
            //ELECTROVIDRIO
            $margen_minimo_definido = 20;
          }else if ($sector_id == "51") {
            //EMPAQUES SINTETICOS
            $margen_minimo_definido = 15;
          }else if ($sector_id == "63") {
            //MERCADERIAS
            $margen_minimo_definido = 15;
          }else if ($sector_id == "70") {
            //MOLDEO DE PLASTICO
            $margen_minimo_definido = 15;
          }else if ($sector_id == "71") {
            //GABINETES
            $margen_minimo_definido = 15;
          }else if ($sector_id == "72") {
            //TUBERIA DE PLASTICO
            $margen_minimo_definido = 15;
          }else if ($sector_id == "76") {
            //TUBERIA CPVC
            $margen_minimo_definido = 10;
          }else if ($sector_id == "90") {
            //TUBERIA
            $margen_minimo_definido = 15;
          }else if ($sector_id == "C3") {
            //Material y EquipoMed
            $margen_minimo_definido = 35;
          }
      }
          //calculos de ventas        
          $ventas_pormar_cien = number_format((100 - $pormar),2);
          $ventas_precio_minimo = number_format((($margen / $ventas_pormar_cien) * 100),2);
          //$ventas_contribucion = number_format(($ventas_precio_minimo - $margen),2);
          $ventas_limite_gerente_pctj = number_format(($pormar * 0.8),2);
          $ventas_limite_comercial_pctj = number_format(($pormar * 0.1),2);
          $ventas_limite_gerente_cien = number_format((100 - $ventas_limite_gerente_pctj),2);
          $ventas_limite_comercial_cien = number_format((100 - $ventas_limite_comercial_pctj),2);
          $ventas_limite_gerente = number_format((($margen / $ventas_limite_gerente_cien) * 100),2);
          $ventas_limite_comercial = number_format((($margen / $ventas_limite_comercial_cien) * 100),2);
  
         
  
          $bandera_de_error = 0;
          $errorcomercial = 0;
          $errorgerente = 0;
  
          if ($importe_descuento <= $ventas_limite_comercial) {
            $errorcomercial = 1;
            $bandera_de_error = 1;
          }
  
          if ($importe_descuento >= $ventas_limite_comercial) {
            if ($importe_descuento < $ventas_limite_gerente &&  $bandera_de_error == 0) {
              $errorcomercial = 1;
              $bandera_de_error = 1;
            }
          }
  
          if ($importe_descuento >= $ventas_limite_gerente) {
            if ($importe_descuento < $ventas_precio_minimo &&  $bandera_de_error == 0) {
              
              $errorgerente = 1;
            }
          }

            //validaciones para obtener material existente.
            if ($existencia>0) {
             $aux1_existencia= floor($existencia/$empaque);//existencia en su almacen
            }else{
                $aux1_existencia=0;
            }
            if ($existencia_cdpt>0) {
              $aux2_existencia=floor($existencia_cdpt/$empaque);//existencia en cdpt
            }else{
               $aux2_existencia=0;
            }
  
            $existencia_total=($aux1_existencia*$empaque)+($aux2_existencia*$empaque);
            //si esto esta en modo pedido programado 
            if ($bandera_programado == true) {
              $existencia_total = 0;
              }
  
          //validamos si hay cantidades en existencia para este material
          $bandera_existencia="";
          if ($existencia_total>=$cantidad_pedida) {
            $bandera_existencia="SI";
          }else{
            $bandera_existencia="NO";
          }
  
          $aux=$cantidad_pedida/$empaque;
  
          $aux_2=ceil($aux);
  
          $surtir= $aux_2*$empaque;
  
          $surtir2 = (string)$surtir;

          //Validacion de Materiales
          if ($tipo_material=="A" || $tipo_material=="B" || $tipo_material=="C") {
          
              if ($error=="0" && $bandera_existencia=="SI") {
                $importe_producto=($surtir*$importe_descuento);
                
                $margen_utilidad=($importe_descuento - $margen) * $surtir2;
                $cadena_result = [
                  'id_lista' => $ID_lista,
                  'codigo_material' => $codigo_material,
                  'nombre_material' => $nombre_material,
                  'unidad_medida' => $unidad_medida,
                  'existencia' => $existencia,
                  'existencia_cdpt' => $existencia_cdpt,
                  'empaque' => $empaqueLabel,
                  'u_pedidas' => $surtir,
                  'u_confirm' => $surtir2,
                  'recordatorios' => "0",
                  'importe_desciento' => $importe_descuento,
                  'importe_producto' => $importe_producto,
                  'validacion' => "Disponible",
                  //datos extra para alidaciones y guardar en bd 
                 'descuento' => $descuento,
                  'ventas_centro' =>$ventas_centro,
                  'sector' =>$sector,
                  // fecha programada es del formulario
                  'pormar' =>$pormar,//valores para valiaciones de credito
                  'porcom' =>$porcom,//valores para valiaciones de credito
                  'margen' =>$margen,
                  'inventario' =>$inventario,
                  //'inventario1' =>$inventario2,
                  'ZK14' =>$ZK14,
                  'ZK71' =>$ZK71,
                  'ZK73' =>$ZK73,
                  'ZK08' =>$ZK08,
                  'ZK66' =>$ZK66,
                  'ZK69' =>$ZK69,
                  'ZK25' =>$ZK25,
                  'gpom4' => $id_gpom4,
                  'margen_utilidad' => $margen_utilidad,
                  'margen_minimo_definido' => $margen_minimo_definido,
                  'errorcomercial' => $errorcomercial,
                  'errorgerente' => $errorgerente,
                  'bandera_error' => $bandera_de_error,
                  'precio_lista' => $precio_lista,
                  'bandera_gpom4' => $bandera_gpom4
                  ];
              }//fin cuando la validacion es Disponible 
              if ($error=="0" && $bandera_existencia=="NO" && $existencia_total>0) {
                $recordatorio=$surtir-$existencia_total;
                $importe_producto=($existencia_total*$importe_descuento);
                
                $margen_utilidad=($importe_descuento - $margen) * $existencia_total;
                $cadena_result = [
                  'id_lista' => $ID_lista,
                  'codigo_material' => $codigo_material,
                  'nombre_material' => $nombre_material,
                  'unidad_medida' => $unidad_medida,
                  'existencia' => $existencia,
                  'existencia_cdpt' => $existencia_cdpt,
                  'empaque' => $empaqueLabel,
                  'u_pedidas' => $surtir,
                  'u_confirm' => $existencia_total+$recordatorio,
                  'recordatorios' => $recordatorio,
                  'importe_desciento' => $importe_descuento,
                  'importe_producto' => $importe_producto,
                  'validacion' => "Parcial",
                  //datos extra para alidaciones y guardar en bd 
                 'descuento' => $descuento,
                  'ventas_centro' =>$ventas_centro,
                  'sector' =>$sector,
                  // fecha programada es del formulario
                  'pormar' =>$pormar,//valores para valiaciones de credito
                  'porcom' =>$porcom,//valores para valiaciones de credito
                  'margen' =>$margen,
                  'inventario' =>$inventario,
                  //'inventario1' =>$inventario2,
                  'ZK14' =>$ZK14,
                  'ZK71' =>$ZK71,
                  'ZK73' =>$ZK73,
                  'ZK08' =>$ZK08,
                  'ZK66' =>$ZK66,
                  'ZK69' =>$ZK69,
                  'ZK25' =>$ZK25,
                  'gpom4' => $id_gpom4,
                  'margen_utilidad' => $margen_utilidad,
                  'margen_minimo_definido' => $margen_minimo_definido,
                  'errorcomercial' => $errorcomercial,
                  'errorgerente' => $errorgerente,
                  'bandera_error' => $bandera_de_error,
                  'precio_lista' => $precio_lista,
                  'bandera_gpom4' => $bandera_gpom4
                  ];
              }// fin validacion cuando es Parcial
              if ($error=="0" && $bandera_existencia=="NO" && $existencia_total==0) {
                $recordatorio=$surtir-$existencia_total;
                $importe_producto=($existencia_total*$importe_descuento);
               
                $margen_utilidad=($importe_descuento - $margen) * $existencia_total;
                $cadena_result = [
                  'id_lista' => $ID_lista,
                  'codigo_material' => $codigo_material,
                  'nombre_material' => $nombre_material,
                  'unidad_medida' => $unidad_medida,
                  'existencia' => $existencia,
                  'existencia_cdpt' => $existencia_cdpt,
                  'empaque' => $empaqueLabel,
                  'u_pedidas' => $surtir,
                  'u_confirm' => $existencia_total+$recordatorio,
                  'recordatorios' => $recordatorio,
                  'importe_desciento' => $importe_descuento,
                  'importe_producto' => $importe_producto,
                  'validacion' => "Sin Existencia",
                  //datos extra para alidaciones y guardar en bd 
                 'descuento' => $descuento,
                  'ventas_centro' =>$ventas_centro,
                  'sector' =>$sector,
                  // fecha programada es del formulario
                  'pormar' =>$pormar,//valores para valiaciones de credito
                  'porcom' =>$porcom,//valores para valiaciones de credito
                  'margen' =>$margen,
                  'inventario' =>$inventario,
                  //'inventario1' =>$inventario2,
                  'ZK14' =>$ZK14,
                  'ZK71' =>$ZK71,
                  'ZK73' =>$ZK73,
                  'ZK08' =>$ZK08,
                  'ZK66' =>$ZK66,
                  'ZK69' =>$ZK69,
                  'ZK25' =>$ZK25,
                  'gpom4' => $id_gpom4,
                  'margen_utilidad' => $margen_utilidad,
                  'margen_minimo_definido' => $margen_minimo_definido,
                  'errorcomercial' => $errorcomercial,
                  'errorgerente' => $errorgerente,
                  'bandera_error' => $bandera_de_error,
                  'precio_lista' => $precio_lista,
                  'bandera_gpom4' => $bandera_gpom4
                  ];
              }//fin validacion cuando no hay existencia.
              //fin validacion precio
            
          }//fin validacion material A y B y C
          if ($tipo_material=="D") {
            $cadena_result = [];
            $mensage_error = "Código erroneo. Producto Descontinuado";
          }
          if ($tipo_material=="O") {
            $cadena_result = [];
            $mensage_error = "Código erroneo. Producto Obsoleto";
          }
          if ($tipo_material=="Z") {
            $cadena_result = [];
            $mensage_error = "Código erroneo. Producto Pendiente de Verificación Comercial";
          }
          if ($tipo_material=="") {
            $cadena_result = [];
            $mensage_error = "Código de material sin genetica de producto, Centro: ".$centro_informacion;
          }
  
  
        }//fin else error codigo
            
            }//validacion de empaque cero
  
          $datos_total = ['cadena_result' => $cadena_result, 'mensaje_error' => $mensage_error];
              return response()->json(
                          $datos_total
                          );
  
        }//fin de funcion material

    public function guardarOrden(Request $request){
        //dd($request);
        $tipo_orden = 0;
        if($request->tipo_orden == 'Oportunidad'){
          $tipo_orden = 1;
        }else if($request->tipo_orden == 'Prospecto'){
          $tipo_orden = 2;
        }
        //Obtener Folio del Promotor
        $promotor_id = 1;
        $oportunidades = OrdenCompra::where('id_promotor',$promotor_id)->get();
        $numero_oportunidad = count($oportunidades);
        $numero_oportunidad++;
        $Folio = 'OC-'.$promotor_id.'-'.$numero_oportunidad;
        //Guardar info en OrdenCompra
        date_default_timezone_set('America/Mexico_City');
        $fechaactual= date("Y-m-d");
        $horaactual= date("H:i:s");

        $nueva_orden_compra = new OrdenCompra();
        $nueva_orden_compra->folio = $Folio;
        $nueva_orden_compra->tipoUsuario = $tipo_orden;
        $nueva_orden_compra->idUsuario = $request->idUsuario;
        $nueva_orden_compra->nombreUsuario = $request->nombreUsuario;
        $nueva_orden_compra->tipoDistribuidor = $request->tipoDistribuidor;
        $nueva_orden_compra->idDistribuidor = $request->idDistribuidor;
        $nueva_orden_compra->nombreDistribuidor = $request->nombreDistribuidor;
        $nueva_orden_compra->orden_compra = $request->orden_compra;
        $nueva_orden_compra->estatus = 'Pendiente';
        $nueva_orden_compra->hora = $horaactual;
        $nueva_orden_compra->fecha = $fechaactual;
        $nueva_orden_compra->id_promotor = $promotor_id;
        $nueva_orden_compra->save();
        //guardar info de detalle de OrdenCompra
        $lista = $request->lista;
        foreach($lista as $infoLista){
          $nueva_orden_compra_detalle = new Orden_Compra_Detalle();
        
          $nueva_orden_compra_detalle->codigo_material = $infoLista['codigo_material'];
          $nueva_orden_compra_detalle->nombre_material = $infoLista['nombre_material'];
          $nueva_orden_compra_detalle->unidades_confirmadas = $infoLista['u_confirm'];
          $nueva_orden_compra_detalle->orden_compra_id = $nueva_orden_compra->id;
          $nueva_orden_compra_detalle->save();
        }
        return 'guardado exitoso';
    }//fin guardarOrden

    public function obtenerDistribuidores(){        
      $usuario="facastillo";  
      $puesto="E";
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
        /******** WEBSERVICE PARA CLIENTES VENDEDORES ********/
        try {
          $servicio1="http://172.16.171.10/webservices/PGC360_Pro_Vendedor_Cliente/Vendedor_Cliente.asmx?WSDL"; //url del servicio
          $parametros1=array(); //parametros de la llamada
          $parametros1['P_USERNAME']="$usuario";
          $parametros1['P_PUESTO']="$puesto";
          $client1 = new SoapClient($servicio1,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
          $result1 = $client1->Vb_Vendedor_Cliente($parametros1);//llamamos al métdo que nos interesa con los parámetros
          $result1 = obj2array($result1);
          $noticias1=$result1['Vb_Vendedor_ClienteResult']['MyResultData'];
          $collection = collect($noticias1);
          
        } catch (Exception $e) {
          trigger_error($e->getMessage(), E_USER_WARNING);
        }
        $n_clientes = count($collection);
        $array_clientes = [];
        for ($i=0; $i < $n_clientes-1 ; $i++) {
          $array_clientes = $collection[$i];
         // dd($array_clientes);
          $array_clientes['NOMBRELIST'] = $array_clientes['KUNNR']." - ".$array_clientes['NAME1'];
          $collection[$i] = $array_clientes;
        }
        return response()->json(
        $collection
          );
      }
    
    public function obtenerProspectosPGC(Request $request){
      //Datos para Georeferencia del Cliente
      //$prospectos = DB::connection('PGC360_DES')->select("SELECT * FROM prospecto ORDER BY id DESC");
      $prospectos = Prospecto::where('id_promotor',1)->get();
      return response()->json(
        $prospectos
          );
    }

    //*************************CATALOGO DE PRODUCTOS ****************

public function CatalogoProductos(Request $request)
{
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
$GPOM4 = $request->gpom4;

//********* WEBSERVICE PARA HISTORIAL COMPRA CLIENTES
  try {

        //$servicio="http://172.16.176.25/WebServices/PGC360_Des_Catalogo/Catalogo.asmx?WSDL"; //url del servicio
        $servicio="http://172.16.171.10/WebServices/PGC360_Pro_Catalogo/Catalogo.asmx?WSDL"; //url del servicio
        $parametros=array(); //parametros de la llamada

        $parametros['P_GPO4']="$GPOM4";
        


        $client = new SoapClient($servicio,array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));

        $result = $client->Vb_Catalogo($parametros);//llamamos al métdo que nos interesa con los parámetros
        //convertir result a array
        

        $result = obj2array($result);
        $noticias=$result['Vb_CatalogoResult']['MyResultData'];
        $Catalogo = collect($noticias);
       

        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        } 

      return response()->json(
            $Catalogo
            );      

}//FIN METODO


public function buscarDistribuidores(Request $request)
{  
  $distribuidoresIusa =  Distribuidores::where('id_oportunidad',$request->id_oportunidad)->where('tipo','IUSA')->get();
  $distribuidoresOTRO =  Distribuidores::where('id_oportunidad',$request->id_oportunidad)->where('tipo','Otro')->get();
  $datos = ['iusa' => $distribuidoresIusa,'otros' => $distribuidoresOTRO];
      return response()->json(
        $datos
          );
}

}
