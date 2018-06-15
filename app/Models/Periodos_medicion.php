<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodos_medicion extends Model
{
    protected $table = 'periodos_mediciones';
    
    public function zonas(){
        return $this->hasMany( "App\Models\Zona", 'periodo_medicion_id'); 
    }
  
}
