<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Respuesta_pregunta extends Model
{
    public $fillable = ['encuestado_id','preguntas_id','estado','respuesta'];
}
