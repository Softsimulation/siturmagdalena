<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicadores_medicion extends Model
{
    
    protected $table = 'indicadores_mediciones';

    public function idiomas()
    {
        return $this->hasMany('App\Models\Indicadores_mediciones_idioma', 'indicadores_medicion_id');
    }
    
    public function graficas()
    {
        return $this->belongsToMany('App\Models\Tipos_grafica', 'graficas_indicadores', 'indicador_medicion_id', 'tipo_grafica_id')->withPivot("es_principal");
    }

}
