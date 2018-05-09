<?php

namespace App;

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
    public function serieMotivos()
    {
        return $this->hasMany('App\SerieMotivo', 'estadisticas_secundarias_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seriesMensuals()
    {
        return $this->hasMany('App\SeriesMensual', 'estadisticas_secundarias_id');
    }
}
