<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Año $año
 * @property EstadisiticasSecundaria $estadisiticasSecundaria
 * @property MotivoEstadisticasSecundaria $motivoEstadisticasSecundaria
 * @property int $id
 * @property int $estadisticas_secundarias_id
 * @property int $motivo_estadisticas_secundarias_id
 * @property int $años_id
 * @property float $serie1
 */
class Serie_Motivo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'serie_motivos';

    /**
     * @var array
     */
    protected $fillable = ['estadisticas_secundarias_id', 'motivo_estadisticas_secundarias_id', 'años_id', 'serie1'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function año()
    {
        return $this->belongsTo('App\Año', '"años_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadisiticasSecundaria()
    {
        return $this->belongsTo('App\EstadisiticasSecundaria', 'estadisticas_secundarias_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motivoEstadisticasSecundaria()
    {
        return $this->belongsTo('App\MotivoEstadisticasSecundaria', 'motivo_estadisticas_secundarias_id');
    }
}
