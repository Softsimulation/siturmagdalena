<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma_pais extends Model
{
    protected $table = 'paises_has_idiomas';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
