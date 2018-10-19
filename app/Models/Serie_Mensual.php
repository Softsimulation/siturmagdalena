<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstadisiticasSecundaria $estadisiticasSecundaria
 * @property TiempoIndicador $tiempoIndicador
 * @property int $id
 * @property int $estadisticas_secundarias_id
 * @property int $tiempo_indicador_id
 * @property float $serie1
 * @property float $serie2
 * @property float $serie3
 */
class Serie_Mensual extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'series_mensual';

    /**
     * @var array
     */
    protected $fillable = ['estadisticas_secundarias_id', 'tiempo_indicador_id', 'serie1', 'serie2', 'serie3'];

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
    public function tiempoIndicador()
    {
        return $this->belongsTo('App\Models\Tiempo_Indicador');
    }
}
