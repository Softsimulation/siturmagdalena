<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factor_Calidad extends Model
{
    //
     protected $table = 'factores_calidad';

    /**
     * @var array
     */
    protected $fillable = ['nombre','tipo_factor_id','user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

}
