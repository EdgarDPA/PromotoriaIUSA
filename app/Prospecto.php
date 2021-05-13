<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    protected $table = 'prospecto';

    protected $fillable = [
        'nombre',       
        'rfc',
        'contacto',
        'direccion',
        'telefono',
        'correo',
        'referencia',
        'antiguedad',
        'ramo',
        'mensualidad',
        'transporte',
        'mostrador',
        'notas',
        'idDistribuidor',
        'nombreDistribuidor',
        'id_oportunidad',
        'id_promotor'
    ];

}
