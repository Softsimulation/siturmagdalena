<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';
    public $timestamps = false;
    public function publicacines(){
             return $this->belongsToMany('App\Publicacion', 'autores_has_publicaciones', 'publicaciones_id', 'autores_id');
        }
        
    public function pais(){
        return $this->hasOne(Pais::class, 'id', 'paises_id'); 
    }
    

}
