<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muestra_proveedores_informale extends Model
{
    
    
    
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedores_informale', 'proveedores_informal_id');
    }
    
    public function zona()
    {
        return $this->belongsTo('App\Models\Zona', 'zona_id');
    }
    
    
    public function estadop(){
        return $this->hasOne('App\Models\Estado_proveedor', 'id', 'estado_proveedor_id'); 
    }
    
    
    public function categoria(){
        return $this->hasOne('App\Models\Categoria_Proveedor', 'id', 'categoria_proveedor_id'); 
    }
    
    
}
