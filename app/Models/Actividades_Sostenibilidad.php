<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades_Sostenibilidad extends Model
{
    //
    
    protected $table = 'actividades_sostenibilidad';
    
    protected $fillable = [ 'user_update', 'updated_at', 'estado', 'created_at', 'user_create'];
    
    
    
    public function actividadesSostenibilidadIdiomas()
    {
        return $this->hasMany('App\Models\Actividades_Sostenibilidad_Idiomas', 'actividades_sostenibilidad_id');
    }
    public function actividadesSostenibilidad(){
        return $this->belongsToMany('App\Models\Actividades_Sostenibilidad', 'actividades_sostenibilidad_visitantes', 'actividades_sostenibilidad_id','visitante_id')->withPivot('nombre');
    }
}
