<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property CriteriosCalificacione $criteriosCalificacione
 * @property int $encuesta_pst_sostenibilidad_id
 * @property int $criterios_calificacion_id
 * @property int $trato_general
 * @property boolean $respetan_normas
 * @property boolean $ofrece_informacion
 * @property int $nivel_importacia
 * @property boolean $responsabilidad_social
 * @property boolean $espacios_accesibles
 * @property boolean $conoce_herramienta_tic
 * @property boolean $implementa_herramienta_tic
 * @property string $contribucion_turismo
 * @property string $user_create
 * @property boolean $estado
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 */
class Componente_Social_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componente_social_pst';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'encuesta_pst_sostenibilidad_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['criterios_calificacion_id', 'trato_general', 'respetan_normas', 'ofrece_informacion', 'nivel_importancia', 'responsabilidad_social', 'espacios_accesibles', 'conoce_herramienta_tic', 'implementa_herramienta_tic', 'contribucion_turismo', 'user_create', 'estado', 'user_update', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteriosCalificacione()
    {
        return $this->belongsTo('App\CriteriosCalificacione', 'criterios_calificacion_id');
    }
}
