<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property MotivosResponsabilidadesPst[] $motivosResponsabilidadesPsts
 * @property int $encuestas_pst_sostenibilidad_id
 * @property int $anio_compromiso
 * @property int $anio_normas
 * @property string $user_update
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $updated_at
 */
class Responsabilidad_Social extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'responsabilidades_sociales';

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
    protected $fillable = ['anio_compromiso', 'anio_normas', 'user_update', 'created_at', 'user_create', 'estado', 'updated_at'];

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
    public function motivosResponsabilidadesPsts()
    {
        return $this->hasMany('App\MotivosResponsabilidadesPst', 'responsabilidades_sociales_id', 'encuestas_pst_sostenibilidad_id');
    }
}
