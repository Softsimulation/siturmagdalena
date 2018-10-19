<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Categoria_Proveedor_Con_Idioma;
use App\Models\Tipo_Proveedor;

class Muestra_proveedor extends Model
{
    
    protected $table = 'muestra_proveedores';
    
    //protected $appends = ['tipoCategoria'];
    
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedores_rnt', 'proveedor_rnt_id');
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
    
    /*
    public function getTipoCategoriaAttribute()
    {
        $idCategoria = $this->categoria->id;
        $idTipo = $this->categoria->tipo_proveedores_id;
        
        return $this->attributes['tipo_categoria'] =  [
                                                          "tipo"=> Categoria_Proveedor_Con_Idioma::where("categoria_proveedores_id", $idCategoria )->pluck("nombre")->first(),
                                                          "categoria"=> Tipo_Proveedor::join("tipo_proveedores_con_idiomas","tipo_proveedores.id","=","tipo_proveedores_id")
                                                                                      ->where("tipo_proveedores.id", $idTipo )->pluck("nombre")->first()
                                                        ];
    }
    */
    
    
}
