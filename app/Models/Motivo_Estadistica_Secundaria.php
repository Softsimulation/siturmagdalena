<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SerieMotivo[] $serieMotivos
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Motivo_Estadistica_Secundaria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motivo_estadisticas_secundarias';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serieMotivos()
    {
        return $this->hasMany('App\SerieMotivo', 'motivo_estadisticas_secundarias_id');
    }
}
