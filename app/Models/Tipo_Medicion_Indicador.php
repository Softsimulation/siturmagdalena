<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_Medicion_Indicador extends Model
{
    //
    
    protected $table = 'tipos_mediciones_indicadores';

    protected $fillable = ['user_update', 'nombre','estado', 'created_at', 'updated_at', 'user_create'];
    
}
