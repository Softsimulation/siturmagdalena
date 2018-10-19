<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Opciones_sub_preguntas_has_sub_pregunta extends Model
{
    
    public $timestamps = false;
    
     public function opcionesRespuestas()
    {
        return $this->belongsToMany('App\Models\EncuestaDinamica\Encuestas_usuario', 'opciones_sub_preguntas_encuestados', 'opciones_sub_preguntas_has_sub_preguntas_id', 'encuestas_usuarios_id');
    }
    
    
}
