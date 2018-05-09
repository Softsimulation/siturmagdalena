<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CiudadesVisitada[] $ciudadesVisitadas
 * @property MunicipiosVisitadosMagdalena[] $municipiosVisitadosMagdalenas
 * @property TiposAlojamientoConIdioma[] $tiposAlojamientoConIdiomas
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Alojamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_alojamiento';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'estado', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ciudadesVisitadas()
    {
        return $this->hasMany('App\CiudadesVisitada', 'tipo_alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipiosVisitadosMagdalenas()
    {
        return $this->hasMany('App\MunicipiosVisitadosMagdalena', 'tipo_alojamiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposAlojamientoConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Alojamiento_Con_Idioma', 'tipos_alojamientos_id');
    }
}
