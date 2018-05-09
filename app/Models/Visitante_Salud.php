<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TiposAtencionSalud $tiposAtencionSalud
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $tipo_atencion_salud
 */
class Visitante_Salud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitantes_salud';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'visitante_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tipo_atencion_salud'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposAtencionSalud()
    {
        return $this->belongsTo('App\TiposAtencionSalud', 'tipo_atencion_salud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
