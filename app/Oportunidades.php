<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oportunidades extends Model
{
    protected $table = 'oportunidades';

    protected $fillable = [
        'Id_INEGI',
        'Nombre',
        'Razon_social',
        'Clase_actividad',
        'Estrato',
        'Tipo_vialidad',
        'Calle',
        'Num_Exterior',
        'Num_Interior',
        'Colonia',
        'CP',
        'Ubicacion',
        'Telefono',
        'Correo_e',
        'Sitio_internet',
        'Tipo',
        'Longitud',
        'Latitud',
        'tipo_corredor_industrial',
        'nom_corredor_industrial',
        'numero_local',
        'id_zona',
        'bandera_prospecto',
        'id_promotor'
    ];
}
