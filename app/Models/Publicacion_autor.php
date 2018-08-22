<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion_autor extends Model
{
    protected $table = 'autores_has_publicaciones_obras';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
