<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ComponenteSocialPst[] $componenteSocialPsts
 * @property ComponenteAmbientalPst[] $componenteAmbientalPsts
 * @property RiesgosTurismo[] $riesgosTurismos
 * @property ComponentesSociale[] $componentesSociales
 * @property int $id
 * @property string $nombre
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_update
 * @property string $user_create
 */
class Criterio_Calificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'criterios_calificaciones';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'updated_at', 'created_at', 'estado', 'user_update', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function componenteSocialPsts()
    {
        return $this->hasMany('App\ComponenteSocialPst', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function componenteAmbientalPsts()
    {
        return $this->hasMany('App\ComponenteAmbientalPst', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riesgosTurismos()
    {
        return $this->hasMany('App\RiesgosTurismo', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function componentesSociales()
    {
        return $this->hasMany('App\ComponentesSociale', 'criterios_calificacion_id');
    }
}
