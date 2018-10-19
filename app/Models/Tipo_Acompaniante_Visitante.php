<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_Acompaniante_Visitante extends Model
{
    protected $table = 'tipos_acompañantes_visitantes';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    
    protected $fillable = ['id', 'estado'];
    
    public function tiposAcompanianteConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Acompaniante_Visitante_Con_Idioma', 'tipos_acompañantes_visitantes_id','id');
    }
    
}
