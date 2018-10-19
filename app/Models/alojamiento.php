<?php

namespace App\Models;

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
    
    public $timestamps = false;

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
    public function cabanas()
    {
        return $this->hasMany('App\Models\Cabana', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function casas()
    {
        return $this->hasMany('App\Models\Casa', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campings()
    {
        return $this->hasMany('App\Models\Camping', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function habitaciones()
    {
        return $this->hasMany('App\Models\Habitacion', 'alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apartamentos()
    {
        return $this->hasMany('App\Models\Apartamento', 'alojamientos_id');
    }
}
