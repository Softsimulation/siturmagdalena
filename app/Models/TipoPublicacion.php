<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPublicacion extends Model
{
    protected $table = 'tipos_publicaciones_obras';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
     public function idiomas(){
        return $this->hasMany(Idioma_TipoPublicacion::class, 'tipos_publicaciones_obras_id'); 
    }
    
      public function getNombreEs(){
        return $this->idiomas->where("idiomas_id",1);
    }
}
