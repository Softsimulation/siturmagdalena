<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valor_serie_tiempo extends Model
{
    
    protected $table = 'valor_series_tiempo';
    public $timestamps = false;
    
    protected $fillable = ['series_estadistica_id', 'anio_id', 'mes_indicador_id', 'valor'];
    
    protected $casts = [
        'valor' => 'float',
    ];
    
}
