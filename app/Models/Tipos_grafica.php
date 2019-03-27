<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipos_grafica extends Model
{
    //
    protected $table = 'tipos_graficas';
    
    public function indicadores()
    {
        return $this->hasMany('App\Models\Indicadores_medicion');
    }
    /*public function indicadores(){
       return $this->belongsToMany('App\Models\Indicadores_medicion');
   }*/
}
