<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property CriteriosCalificacione $criteriosCalificacione
 * @property int $encuesta_pst_sostenibilidad_id
 * @property int $criterios_calificacion_id
 * @property string $areas_promociona
 * @property boolean $tiene_guia
 * @property boolean $tiene_informe_gestion
 * @property boolean $energias_renovables
 */
class Componente_Ambiental_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componente_ambiental_pst';

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
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['encuesta_pst_sostenibilidad_id','agua_reciclabe','criterios_calificacion_id', 'areas_promociona', 'tiene_guia', 'tiene_informe_gestion', 'energias_renovables','tiene_manual'];

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
