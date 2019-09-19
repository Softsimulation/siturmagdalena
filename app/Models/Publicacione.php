<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacione extends Model
{
    
    
    public function tipo(){
        return $this->hasOne( "App\Models\Tipo_Documento", 'id', 'tipo_documento_id');  
    }
    
    public function categoria(){
        return $this->hasOne( "App\Models\Categoria_Documento", 'id', 'categoria_doucmento_id');  
    }
    
    public function idiomas(){
        return $this->hasMany( "App\Models\Publicaciones_idioma", 'publicaciones_id'); 
    }
    
}
