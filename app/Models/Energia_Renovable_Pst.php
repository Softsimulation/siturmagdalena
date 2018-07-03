<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property TiposEnergiasRenovable $tiposEnergiasRenovable
 * @property int $encuestas_pst_sostenibilidad_id
 * @property int $tipos_energias_renovable_id
 * @property boolean $tiene_manual
 * @property string $otro
 */
class Energia_Renovable_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'energias_renovables_pst';

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
    protected $fillable = ['tipos_energias_renovable_id', 'tiene_manual', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposEnergiasRenovable()
    {
        return $this->belongsTo('App\TiposEnergiasRenovable');
    }
}
