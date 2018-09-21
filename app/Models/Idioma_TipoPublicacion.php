<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma_TipoPublicacion extends Model
{
    protected $table = 'idiomas_has_tipos_publicaciones_obras';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
