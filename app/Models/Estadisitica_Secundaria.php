<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SerieMotivo[] $serieMotivos
 * @property SeriesMensual[] $seriesMensuals
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 */
class Estadisitica_Secundaria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'estadisiticas_secundarias';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'created_at', 'user_create', 'user_update', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rotulos()
    {
        return $this->hasMany('App\Models\Rotulos_estadistica', 'estadisticas_secundaria_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function series()
    {
        return $this->hasMany('App\Models\Series_estadistica', 'estadisticas_secundaria_id');
    }
    
    public function graficas()
    {
        return $this->belongsToMany('App\Models\Tipos_grafica', 'estadistica_secundaria_graficas', 'estadisitica_secundaria_id', 'tipos_grafica_id')->withPivot("principal");
    }
    
}
