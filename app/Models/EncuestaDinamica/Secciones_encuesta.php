<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Secciones_encuesta extends Model
{
    
    public function preguntas(){
        return $this->hasMany( "App\Models\EncuestaDinamica\Pregunta", 'secciones_encuestas_id'); 
    }
    
}
