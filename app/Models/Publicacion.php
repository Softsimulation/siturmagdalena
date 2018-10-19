<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaDocumento $categoriaDocumento
 * @property TipoDocumento $tipoDocumento
 * @property PublicacionesIdioma[] $publicacionesIdiomas
 * @property int $id
 * @property int $categoria_doucmento_id
 * @property int $tipo_documento_id
 * @property string $autores
 * @property int $volumen
 * @property string $portada
 * @property string $ruta
 * @property string $fecha_creacion
 * @property string $fecha_publicacion
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class Publicacion extends Model
{
    
    protected $table = 'publicaciones_obras';
    public $timestamps = false;
    
    
    public function temas(){
        return $this->belongsToMany('App\Models\Tema', 'publicaciones_obras_has_temas', 'publicaciones_obras_id', 'temas_id');
    }
    
    public function personas(){
         return $this->belongsToMany('App\Models\Autor', 'autores_has_publicaciones_obras', 'publicaciones_obras_id', 'autores_id');
    }
        
    public function palabras(){
         return $this->belongsToMany('App\Models\Palabra', 'publicaciones_obras_has_palabras', 'publicaciones_obras_id', 'palabras_id');
    }
    
      public function tipopublicacion(){
        return $this->hasOne(TipoPublicacion::class,'id','tipos_publicaciones_obras_id'); 
    }
    
     public function estadoPublicacion(){
        return $this->hasOne(Estado::class,'id','estados_id'); 
    }
    
    public function getNombreEs(){

        return $this->idiomas()->where('idiomas_id',1);
    }
    

  
}
