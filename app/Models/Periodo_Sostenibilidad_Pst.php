<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo_Sostenibilidad_Pst extends Model
{
    protected $table = 'periodos_sostenibilidad_pst';
    
    protected $fillable = ['fecha_inicial', 'fecha_final', 'nombre', 'estado', 'user_create', 'user_update'];
    
    public function encuestas()
    {
        return $this->hasMany('App\Models\Encuesta_Pst_Sostenibilidad','periodo_sostenibilidad_id','id');
    }
    
}
