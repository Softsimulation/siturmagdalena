<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Opciones_pregunta extends Model
{
    
    public function idiomas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Idiomas_opciones_pregunta', 'opciones_preguntas_id'); 
    }
    
    public function opcionesRespuestas()
    {
        return $this->belongsToMany('App\Models\EncuestaDinamica\Encuestas_usuario', 'opciones_preguntas_encuestados', 'opciones_preguntas_id', 'encuestado_id');
    }
    
    
}
