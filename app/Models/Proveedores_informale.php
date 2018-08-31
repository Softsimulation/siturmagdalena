<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedores_informale extends Model
{
    
    //protected $appends = ['tipoCategoria'];
    
    
    public function categoria(){
        return $this->hasOne('App\Models\Categoria_Proveedor', 'id', 'categoria_proveedor_id'); 
    }
    
    public function municipio(){
        return $this->hasOne('App\Models\Municipio', 'id', 'municipio_id'); 
    }
    
    public function estadop(){
        return $this->hasOne('App\Models\Estado_proveedor', 'id', 'estados_proveedor_id'); 
    }
    
    /*
    public function getTipoCategoriaAttribute()
    {
        if($this->categoria){
            $idCategoria = $this->categoria->id;
            $idTipo = $this->categoria->tipo_proveedores_id;
            
            return $this->attributes['tipo_categoria'] =  [
                                                              "categoria"=> Categoria_Proveedor_Con_Idioma::where("categoria_proveedores_id", $idCategoria )->pluck("nombre")->first(),
                                                              "tipo"=> Tipo_Proveedor::join("tipo_proveedores_con_idiomas","tipo_proveedores.id","=","tipo_proveedores_id")
                                                                                          ->where("tipo_proveedores.id", $idTipo )->pluck("nombre")->first()
                                                            ];
        }
        return $this->attributes['tipo_categoria'] = null;
    }
    */
}
