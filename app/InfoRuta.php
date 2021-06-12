<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoRuta extends Model
{
    protected $table = 'inforuta';

    protected $fillable = [
        'numero_ruta',
        'orden_ruta',
        'estatus',
        'id_promotor'
    ];
}
