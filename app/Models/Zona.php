<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{

    public function encargados(){
        return $this->belongsToMany('App\Models\Digitador', 'zonas_digitadores', 'zona_id', 'digitador_id');
    }
    
    public function coordenadas(){
        return $this->hasMany('App\Models\Coordenadas_zona', 'zona_id');
    }
    
    public function proveedores(){
        return $this->hasMany('App\Models\Proveedores_rnt', 'zona_id');
    }
    
    
}
