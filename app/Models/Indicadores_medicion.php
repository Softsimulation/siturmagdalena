<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicadores_medicion extends Model
{
    public $timestamps = false;
    protected $table = 'indicadores_mediciones';
    protected $fillable = [
        'formato','estado'
    ];

    public function idiomas()
    {
        return $this->hasMany('App\Models\Indicadores_mediciones_idioma', 'indicadores_medicion_id');
    }
    
    public function graficas()
    {
        return $this->belongsToMany('App\Models\Tipos_grafica', 'graficas_indicadores', 'indicador_medicion_id', 'tipo_grafica_id')->withPivot("es_principal");
    }
    public function tipoIndicador()
    {
        return $this->belongsTo('App\Models\Tipo_Medicion_Indicador','tipo_medicion_indicador_id');
    }

}
