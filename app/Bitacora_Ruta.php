<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora_Ruta extends Model
{
    protected $table = 'bitacora_ruta';

    protected $fillable = [
        'fecha',
        'hora',
        'estatus',
        'latitud',
        'longitud',
        'id_ruta',
        'id_promotor'
    ];
}
