<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Opciones_sub_pregunta extends Model
{
    
    public function idiomas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Idiomas_opciones_sub_pregunta', 'opciones_sub_preguntas_id'); 
    }
    
}
