<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma_Tema extends Model
{
    protected $table = 'idiomas_has_temas';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
