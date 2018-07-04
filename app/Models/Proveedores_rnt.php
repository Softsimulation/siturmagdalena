<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedores_rnt extends Model
{
    protected $table = 'proveedores_rnt';
    
    public function proveedor_rnt_idioma(){
        return $this->hasMany( "App\Models\Proveedores_rnt_idioma", 'proveedor_rnt_id'); 
    }
    
    public function estadop(){
        return $this->hasOne('App\Models\Estado_proveedor', 'id', 'estados_proveedor_id'); 
    }
    
    public function categoria(){
        return $this->hasOne('App\Models\Categoria_Proveedor', 'id', 'categoria_proveedores_id'); 
    }
    
}
