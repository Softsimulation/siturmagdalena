<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series_estadistica_rotulo extends Model
{
    
    public $timestamps = false;
    
    protected $fillable = ['series_estadistica_id', 'anio_id', 'rotulo_estadistica_id', 'valor'];
    
    protected $casts = [
        'valor' => 'float',
    ];
    
}
