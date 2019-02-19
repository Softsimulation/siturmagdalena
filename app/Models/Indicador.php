<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstadoIndicador $estadoIndicador
 * @property TiempoIndicador $tiempoIndicador
 * @property int $id
 * @property int $estado_indicador_id
 * @property int $tiempo_indicador_id
 * @property string $nombre
 * @property string $grupo
 * @property string $fecha_carga
 * @property string $fecha_finalizacion
 */
class Indicador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'indicadores';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['estado_indicador_id', 'tiempo_indicador_id', 'nombre', 'grupo', 'fecha_carga', 'fecha_finalizacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoIndicador()
    {
        return $this->belongsTo('App\EstadoIndicador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiempoIndicador()
    {
        return $this->belongsTo('App\TiempoIndicador');
    }
}
