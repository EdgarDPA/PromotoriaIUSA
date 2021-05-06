<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden_Compra_Detalle extends Model
{
    protected $table = 'orden_compra_detalle';

    protected $fillable = [
    'codigo_material',
    'nombre_material',
    'unidades_confirmadas',
    'orden_compra_id'
    ];
}
