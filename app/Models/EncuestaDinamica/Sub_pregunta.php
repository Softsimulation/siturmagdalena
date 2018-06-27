<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Sub_pregunta extends Model
{
    public function idiomas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Idiomas_sub_pregunta', 'sub_preguntas_id'); 
    }
    
    public function opciones(){
        return $this->hasMany('App\Models\EncuestaDinamica\Opciones_sub_preguntas_has_sub_pregunta', 'sub_preguntas_id'); 
    }
}
