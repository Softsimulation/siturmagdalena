<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{

    public function encargados(){
        return $this->belongsToMany('App\Models\Digitador', 'zonas_digitadores', 'zona_id', 'digitador_id');
    }
    
}
