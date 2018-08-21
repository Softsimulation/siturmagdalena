<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion_tema extends Model
{
    protected $table = 'publicaciones_has_temas';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
