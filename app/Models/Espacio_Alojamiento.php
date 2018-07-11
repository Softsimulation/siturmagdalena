<?php

namespace App\Models;

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
    
    public $timestamps = false;
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['numero_habitaciones','encuestas_pst_sostenibilidad_id'];

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
    public function tiposDiscapacidades()
    {
        return $this->belongsToMany('App\Models\Tipo_Discapacidad', 'habitaciones_discapacidades', 'espacios_alojamiento_id','tipos_discapacidad_id')->withPivot('numero_habitacion','user_create','user_update')->withTimestamps();;
    }
}
