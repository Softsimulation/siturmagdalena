<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Tamanio_Empresa extends Model
{
    public $timestamps = false;
    protected $table = 'd_tamaño_empresa';

    public function factoresExpansion()
    {
        return $this->hasMany('App\Models\Factor_Expansion_Oferta_Empleo');
    }

}