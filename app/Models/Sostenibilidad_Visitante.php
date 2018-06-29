<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sostenibilidad_Visitante extends Model
{
    //
    
    protected $table = 'sostenibilidad_visitantes';
    public $primaryKey = 'visitante_id';
    public $incrementing = false;
    protected $fillable = ['visitante_id',  'user_update', 'updated_at', 'estado', 'created_at', 'user_create'];
    
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }
    
    public function actividadesSostenibilidad(){
        return $this->belongsToMany('App\Models\Actividades_Sostenibilidad', 'actividades_sostenibilidad_visitantes', 'visitante_id', 'actividades_sostenibilidad_id')->withPivot('nombre');
    }
    
}
