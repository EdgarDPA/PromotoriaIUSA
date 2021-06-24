<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = ['vendedor', 
    'start', 
    'end', 
    'title',
    'content',
    'class',
    'cliente',
    'nombre_cliente',
    'lat_cliente',
    'lon_cliente',
    'tipo_cita',
    'descripcion_detalle',
    'fecha',
    'hora_inicio',
    'hora_fin',
    'forma_contacto',
    'objetivo_contacto',
    'tel_cliente',
    'email_cliente',
    'checkin',
    'fecha_chekin',
    'hora_checkin',
    'lat_checkin',
    'lng_checkin',
    'checkout',
    'fecha_checkout',
    'hora_checkout',
    'lat_checkout',
    'lng_checkout',
    'finalizo',
    'observacion_final',
    'cancelado',
    'motivo_cancelacion',
    'cita_grupal',
    'id_cita_grupal',
    'anfitrion',
    'invitados',
    'id_invitados'
    ];
}
