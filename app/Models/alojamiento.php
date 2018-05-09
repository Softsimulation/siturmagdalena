<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property Cabaña[] $cabañas
 * @property Casa[] $casas
 * @property Camping[] $campings
 * @property Habitacione[] $habitaciones
 * @property Apartamento[] $apartamentos
 * @property int $id
 * @property int $encuestas_id
 */
class alojamiento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['encuestas_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cabañas()
    {
        return $this->hasMany('App\Cabaña', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function casas()
    {
        return $this->hasMany('App\Casa', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campings()
    {
        return $this->hasMany('App\Camping', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function habitaciones()
    {
        return $this->hasMany('App\Habitacione', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apartamentos()
    {
        return $this->hasMany('App\Apartamento', 'alojamientos_id');
    }
}
