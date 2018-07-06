<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property PeriodosInforme $periodosInforme
 * @property int $encuestas_pst_sosteniblidad_id
 * @property int $periodos_informe_id
 * @property boolean $mide_residuos
 */
class Informe_Gestion_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'informes_gestion_pst';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'encuestas_pst_sosteniblidad_id';

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
    protected $fillable = ['periodos_informe_id', 'mide_residuos','encuestas_pst_sosteniblidad_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad', 'encuestas_pst_sosteniblidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodosInforme()
    {
        return $this->belongsTo('App\PeriodosInforme');
    }
}
