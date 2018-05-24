<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_Acompaniante_Visitante_Con_Idioma extends Model
{
    protected $table = 'tipos_acompañantes_visitantes_con_idiomas';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    
    protected $fillable = ['tipos_acompañantes_visitantes_id', 'id', 'nombre','idiomas_id'];
    
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposAcompañiante()
    {
        return $this->belongsTo('App\Models\Tipo_Acompaniante_Visitante', 'tipos_acompañantes_visitantes_id');
    }
    
}
