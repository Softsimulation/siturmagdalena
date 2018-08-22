<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';
    public $timestamps = false;
    
   public function idiomas(){
        return $this->hasMany(Idioma_Tema::class, 'temas_id'); 
    }
    
    public function publicaciones(){
       return $this->belongsToMany('App\Publicacion', 'publicaciones_has_temas', 'publicaciones_id', 'temas_id');
    }
    
    public function areasconocimiento(){
       return $this->belongsToMany('App\AreasConocimiento', 'areas_conocimiento', 'areas_conocimiento_id', 'temas_id');
    }
     public function getNombreEs(){
        return $this->idiomas->where("idiomas_id",1)->first();
    }

}
