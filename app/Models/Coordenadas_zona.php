<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordenadas_zona extends Model
{
    
    public $timestamps = false;
    
    protected $fillable = ['x', 'y'];
    
    protected $casts = [
        'x' => 'float',
        'y' => 'float'
    ];
    
    
}
