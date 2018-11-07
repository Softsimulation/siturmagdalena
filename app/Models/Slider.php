<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $table = 'sliders';
    public function idiomas()
    {
        return $this->belongsToMany('App\Models\Idioma', 'sliders_idiomas', 'slider_id', 'idioma_id');
    }
}
