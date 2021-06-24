<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaEvidencia extends Model
{
    protected $table = 'agenda_evidencia';

    protected $fillable = ['foto', 'seccion', 'agenda_id'];
}
