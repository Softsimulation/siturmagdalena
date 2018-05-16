<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property VolveriaVisitar $volveriaVisitar
 * @property VolveriaVisitar $volveriaVisitar
 * @property int $visitante_id
 * @property int $recomendaria
 * @property int $volveria
 * @property string $recomendaciones
 * @property int $calificacion
 * @property string $veces_visitadas
 * @property string $contribucion
 * @property boolean $informado
 */
class Valoracion_General extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'valoracion_general';
    public $timestamps = false;

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
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['recomendaria', 'volveria', 'recomendaciones', 'calificacion', 'veces_visitadas', 'contribucion', 'informado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function volveriaVisitarRecomendaria()
    {
        return $this->belongsTo('App\VolveriaVisitar', 'recomendaria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function volveriaVisitarVolveria()
    {
        return $this->belongsTo('App\VolveriaVisitar', 'volveria');
    }
}
