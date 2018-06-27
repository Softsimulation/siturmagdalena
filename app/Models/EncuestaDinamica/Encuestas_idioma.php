<?php

namespace App\Models\EncuestaDinamica;

use Illuminate\Database\Eloquent\Model;

class Encuestas_idioma extends Model
{
    
    public function idioma()
    {
        return $this->belongsTo('App\Models\EncuestaDinamica\Idioma', 'idiomas_id');
    }
    
}
