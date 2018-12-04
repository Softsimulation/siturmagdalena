<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Informacion_departamento extends Model
{
    protected $table = 'informacion_departamento';
    
    
    public function imagenes()
    {
        return $this->hasMany('App\Models\Inoformacion_departamento_imagenes', 'informacion_id');
    }

    
}
