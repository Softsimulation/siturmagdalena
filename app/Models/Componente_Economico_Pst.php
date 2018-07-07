<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property int $encuestas_pst_sostenibilidad_id
 * @property boolean $es_positivo
 * @property float $porcentaje
 * @property string $dificultades
 */
class Componente_Economico_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componente_economico_pst';

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
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['es_positivo', 'porcentaje', 'dificultades','encuestas_pst_sostenibilidad_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad');
    }
}
