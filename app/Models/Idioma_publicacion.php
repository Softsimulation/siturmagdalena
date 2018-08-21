<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma_publicacion extends Model
{
    protected $table = 'publicaciones_has_idiomas';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
