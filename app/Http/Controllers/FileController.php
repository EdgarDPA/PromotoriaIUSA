<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Oportunidades;

use App\Oportunidad_Piloto;

use App\InfoRuta;

class FileController extends Controller
{
    //
    public function index()
    {
        return view('promotor.csv.index');
    }

    public function guardarOportunidades(Request $request){
        //dd($request);

        $lista = $request->lista;
        foreach($lista as $infoLista){
          $nueva_orden_compra_detalle = new Oportunidades();
          $nueva_orden_compra_detalle->Id_INEGI = $infoLista['Id'];
          $nueva_orden_compra_detalle->Nombre= $infoLista['Nombre'];
          $nueva_orden_compra_detalle->Razon_social= $infoLista['Razon_social'];
          $nueva_orden_compra_detalle->Clase_actividad= $infoLista['Clase_actividad'];
          $nueva_orden_compra_detalle->Estrato= $infoLista['Estrato'];
          $nueva_orden_compra_detalle->Tipo_vialidad= $infoLista['Tipo_vialidad'];
          $nueva_orden_compra_detalle->Calle= $infoLista['Calle'];
          $nueva_orden_compra_detalle->Num_Exterior= $infoLista['Num_Exterior'];
          $nueva_orden_compra_detalle->Num_Interior= $infoLista['Num_Interior'];
          $nueva_orden_compra_detalle->Colonia= $infoLista['Colonia'];
          $nueva_orden_compra_detalle->CP= $infoLista['CP'];
          $nueva_orden_compra_detalle->Ubicacion= $infoLista['Ubicacion'];
          $nueva_orden_compra_detalle->Telefono= $infoLista['Telefono'];
          $nueva_orden_compra_detalle->Correo_e= $infoLista['Correo_e'];
          $nueva_orden_compra_detalle->Sitio_internet= $infoLista['Sitio_internet'];
          $nueva_orden_compra_detalle->Tipo= $infoLista['Tipo'];
          $nueva_orden_compra_detalle->Longitud= $infoLista['Longitud'];
          $nueva_orden_compra_detalle->Latitud= $infoLista['Latitud'];
          $nueva_orden_compra_detalle->tipo_corredor_industrial = $infoLista['tipo_corredor_industrial'];
          $nueva_orden_compra_detalle->nom_corredor_industrial = $infoLista['nom_corredor_industrial'];
          $nueva_orden_compra_detalle->numero_local = $infoLista['numero_local'];
          $nueva_orden_compra_detalle->id_zona = 0;

          $nueva_orden_compra_detalle->id_promotor = 2;
          
          $nueva_orden_compra_detalle->save();
        }
        return 'guardado exitoso';
    }//fin guardarOrden

    public function subirCSVOportunidad(Request $request){
        //dd($request);
        $mensage = "";
        if($request->file('csv')) {

            $file = $request->file('csv');

            $tipo = $file->getClientMimeType();
    
            $nombre = $file->getClientOriginalName();
    
            $path = public_path().'/Archivos/';
    
            $pathinfo = public_path().'/Archivos/'.$nombre;

            $path_info = 'Archivos/'.$nombre;
    
            $file->move($path, $nombre);
            
            $fila2=1;
            
            $i=0;
            
            $fp2 = fopen ("$path_info","r");
    
            while ($data2 = fgetcsv ($fp2, 1000, ",")) {
                $num2 = count ($data2);
        
                if ($fila2>1) {
                $carrito[$i] = $data2;        
                }
        
                $fila2++;
                $i++;
            }
            fclose ($fp2);
            
    
            \File::delete($path_info);
            $info_ruta = [];
            $bandera_nuevo = 0;

            foreach($carrito as $infoCarrito){
                $folio = $infoCarrito[0];
                $folio1 = str_replace('FMR','',$folio);
                $folio2 = explode('_',$folio1);
                //dd($infoCarrito);
                $bandera_nuevo = 0;   
                $nuevo_oportunidad_piloto = new Oportunidad_Piloto();
                $nuevo_oportunidad_piloto->ruta_id = $infoCarrito[0];
                $nuevo_oportunidad_piloto->nombre = $infoCarrito[1];
                $nuevo_oportunidad_piloto->razon_social = $infoCarrito[2];
                $nuevo_oportunidad_piloto->estrato = $infoCarrito[3];
                $nuevo_oportunidad_piloto->direccion = $infoCarrito[4];
                $nuevo_oportunidad_piloto->codigo_postal = $infoCarrito[5];
                $nuevo_oportunidad_piloto->clave_entidad = $infoCarrito[6];
                $nuevo_oportunidad_piloto->entidad = 'MEXICO';
                $nuevo_oportunidad_piloto->clave_municipio = $infoCarrito[8];
                $nuevo_oportunidad_piloto->municipio = $infoCarrito[9];
                $nuevo_oportunidad_piloto->clave_localidad = $infoCarrito[10];
                //$nuevo_oportunidad_piloto->localidad = str_replace('b','',$infoCarrito[11]);
                $nuevo_oportunidad_piloto->telefono = $infoCarrito[12];
                $nuevo_oportunidad_piloto->correo_electronico = $infoCarrito[13];
                $nuevo_oportunidad_piloto->sitio_internet = $infoCarrito[14];                
                $nuevo_oportunidad_piloto->latitud = $infoCarrito[15];
                $nuevo_oportunidad_piloto->longitud = $infoCarrito[16];
                $nuevo_oportunidad_piloto->ageb = $infoCarrito[17];
                $nuevo_oportunidad_piloto->manzana = $infoCarrito[18];
                $nuevo_oportunidad_piloto->numero_ruta = $folio2[0];
                $nuevo_oportunidad_piloto->orden_ruta = $folio2[1];
                $nuevo_oportunidad_piloto->id_promotor = 1;
                $nuevo_oportunidad_piloto->save();
                //guardar en el contador de rutas
                foreach($info_ruta as $key=>$infolistaRuta){
                    if($infolistaRuta['numero_ruta'] == $folio2[0]){
                        //dd($infolistaRuta['numero_ruta']);
                        //se actualiza el contador de ruta si es mayor
                        if(intval($infolistaRuta['orden_ruta']) < intval($folio2[1])){                            
                            $infolistaRuta['orden_ruta'] = $folio2[1];
                            $info_ruta[$key] = $infolistaRuta;
                        }
                        //actibar bandera de nuevo registro
                        $bandera_nuevo = 1;
                    }
                }
                //crear nuevo registro depende la bandera 
                if($bandera_nuevo == 0){
                    $info_ruta[] = ['numero_ruta' => $folio2[0], 'orden_ruta' =>$folio2[1]];
                }
            }

            foreach($info_ruta as $key=>$infolistaRuta){
                $nuevo_info_rutas = new InfoRuta();
                $nuevo_info_rutas->numero_ruta = $infolistaRuta['numero_ruta'];
                $nuevo_info_rutas->orden_ruta = $infolistaRuta['orden_ruta'];
                $nuevo_info_rutas->id_promotor = 1;
                $nuevo_info_rutas->save();
            }

            $mensage = "Exito";
    
      }else{
        $mensage = "Error de carga de archivo, vuelva a intentarlo";
      }
      return $mensage;
    }
}
