<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Año $año
 * @property MesIndicador $mesIndicador
 * @property Indicadore[] $indicadores
 * @property SeriesMensual[] $seriesMensuals
 * @property int $id
 * @property int $mes_indicador_id
 * @property int $años_id
 */
class Tiempo_Indicador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tiempo_indicador';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['mes_indicador_id', 'años_id'];

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
    public function mesIndicador()
    {
        return $this->belongsTo('App\MesIndicador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indicadores()
    {
        return $this->hasMany('App\Indicadore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seriesMensuals()
    {
        return $this->hasMany('App\SeriesMensual');
    }
}
