<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_noticia extends Model
{
    public $timestamps = false;
    protected $table = 'tipos_noticias';
    public function noticias()
    {
        return $this->hasMany('App\Models\Noticia');
    }
    public function idiomas()
    {
        return $this->belongsToMany('App\Models\Idioma', 'tipos_noticias_has_idiomas', 'tipos_noticias_id', 'idiomas_id');
    }
}
