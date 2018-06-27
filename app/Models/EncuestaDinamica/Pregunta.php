<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    
    
    public function idiomas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Idiomas_pregunta', 'preguntas_id'); 
    }
    
    public function opciones(){
        return $this->hasMany('App\Models\EncuestaDinamica\Opciones_pregunta', 'preguntas_id'); 
    }
    
    public function subPreguntas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Sub_pregunta', 'preguntas_id'); 
    }
    
    public function OpcionesSubPreguntas(){
        return $this->hasMany('App\Models\EncuestaDinamica\Opciones_sub_pregunta', 'preguntas_id'); 
    }
    
    
    public function tipoCampo(){
        return $this->hasOne('App\Models\EncuestaDinamica\Tipo_campo', 'id', 'tipo_campos_id'); 
    }
    
    

}
