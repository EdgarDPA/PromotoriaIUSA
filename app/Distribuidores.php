<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribuidores extends Model
{
    protected $table = 'distribuidores';

    protected $fillable = [
        'nombre',
        'idIusa',
        'tipo',
        'direccion',
        'telefono',
        'correo',
        'cp',
        'calificacion',
        'id_oportunidad'
    ];
}
