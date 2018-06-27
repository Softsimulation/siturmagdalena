<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Encuestas_dinamica extends Model
{
    
    
    public function secciones(){
        return $this->hasMany( "App\Models\EncuestaDinamica\Secciones_encuesta", 'encuestas_id'); 
    }
    
    public function idiomas(){
        return $this->hasMany( "App\Models\EncuestaDinamica\Encuestas_idioma", 'encuestas_id'); 
    }
    
    public function estado(){
        return $this->hasOne( "App\Models\EncuestaDinamica\Estados_encuesta", 'id', 'estados_encuestas_id'); 
    }
    
    public function encuestas(){ // encuestas de usuarios
        return $this->hasMany( "App\Models\EncuestaDinamica\Encuestas_usuario", 'encuestas_id'); 
    }
    
    public function preguntas(){ // encuestas de usuarios
        return $this->hasMany( "App\Models\EncuestaDinamica\Encuestas_usuario", 'encuestas_id'); 
    }
    
}
