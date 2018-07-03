<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property HabitacionesDiscapacidade[] $habitacionesDiscapacidades
 * @property int $encuestas_pst_sostenibilidad_id
 * @property int $numero_habitaciones
 */
class Espacio_Alojamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'espacios_alojamientos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'encuestas_pst_sostenibilidad_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['numero_habitaciones'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function habitacionesDiscapacidades()
    {
        return $this->hasMany('App\HabitacionesDiscapacidade', null, 'encuestas_pst_sostenibilidad_id');
    }
}
