<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anio extends Model
{
    //
    protected $table ="anios";
    protected $fillable = ['id','anio', 'user_create', 'user_update'];
    
    
    public function mesesAnio()
    {
        return $this->hasMany('App\Model\Mes_Anio', 'anio_id');
    }
}
