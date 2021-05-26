<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuesta';

    protected $fillable = [
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'pregunta4',
        'pregunta5',
        'pregunta6',
        'pregunta7',
        'pregunta8',
        'pregunta9',
        'pregunta10',
        'id_oportunidad'
    ];
}
