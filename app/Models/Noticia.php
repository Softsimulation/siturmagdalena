<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    public $timestamps = false;
    protected $table = 'noticias';
    public function idiomas()
    {
        return $this->belongsToMany('App\Models\Idioma', 'noticias_has_idiomas', 'noticias_id', 'idiomas_id');
    }
    public function tipoNoticia()
    {
        return $this->belongsTo('App\Models\Tipo_noticia','tipos_noticias_id');
    }
}
