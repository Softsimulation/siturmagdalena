<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades_Sostenibilidad_Idiomas extends Model
{
    //
     protected $table = 'actividades_sostenibilidad_idiomas';
    
    protected $fillable = [ 'nombre', 'idioma_id', 'actividades_sostenibilidad_id'];
    
    public function actvidadesSostenibilidad()
    {
        return $this->belongsTo('App\Models\Actividades_Sostenibilidad', 'actividades_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idioma_id');
    }
}
