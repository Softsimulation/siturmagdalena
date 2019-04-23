<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Municipios_Interno extends Model
{
    public $timestamps = false;
    protected $table = 'd_municipios_interno';

    public function factoresExpansion()
    {
        return $this->hasMany('App\Models\Factor_Expansion_Oferta_Empleo');
    }

}