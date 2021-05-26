<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'orden_compra';

    protected $fillable = [
        'folio',
        'tipoUsuario',
        'idUsuario',
        'nombreUsuario',
        'tipoDistribuidor',
        'idDistribuidor',
        'nombreDistribuidor',
        'orden_compra',
        'estatus',
        'hora',
        'fecha',
        'id_promotor'
    ]; 

    public function orden_compra_detalle(){
        return $this->hasMany('App\Orden_Compra_Detalle');
    }
}
