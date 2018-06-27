<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Encuestas_usuario extends Model
{
    
    public function encuesta()
    {
        return $this->belongsTo('App\Models\EncuestaDinamica\Encuestas_dinamica', 'encuestas_id');
    }
    
    
    public function opcionesRespuestas()
    {
        return $this->belongsToMany('App\Models\EncuestaDinamica\Opciones_pregunta', 'opciones_preguntas_encuestados', 'encuestado_id', 'opciones_preguntas_id');
    }

    public function estado(){
        return $this->hasOne('App\Models\EncuestaDinamica\Estados_encuestas_usuario', 'id', 'estados_encuestas_usuarios_id'); 
    }
    
    public function opcionesRespuestasSubPreguntas()
    {
        return $this->belongsToMany('App\Models\EncuestaDinamica\Opciones_sub_preguntas_has_sub_pregunta', 'opciones_sub_preguntas_encuestados', 'encuestas_usuarios_id', 'opciones_sub_preguntas_has_sub_preguntas_id');
    }
    
}
