<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multimedia_noticia_Idioma extends Model
{
    public $timestamps = false;
    protected $table = 'multimedias_noticias_has_idiomas';
    protected $fillable = [
        'idiomas_id','titulo','resumen','texto'
    ];
    
    public function idiomas()
    {
        return $this->belongsTo('App\Models\Idioma');
    }
    public function multimedias_noticia()
    {
        return $this->belongsTo('App\Models\Multimedia_noticia');
    }
}
