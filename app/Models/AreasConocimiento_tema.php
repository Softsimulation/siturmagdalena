<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreasConocimiento_tema extends Model
{
    protected $table = 'temas_has_areas_conocimiento';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
