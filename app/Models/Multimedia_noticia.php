<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multimedia_noticia extends Model
{
    public $timestamps = false;
    protected $table = 'multimedias_noticias';
    public function multimedias_noticia_idioma()
    {
        return $this->hasMany('App\Models\Multimedia_noticia_Idioma','multimedias_noticias_id');
    }
}
