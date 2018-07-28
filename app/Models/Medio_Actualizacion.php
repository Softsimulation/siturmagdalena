<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta[] $encuestas
 * @property int $id
 * @property string $nombre
 */
class Medio_Actualizacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medios_actualizaciones';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encuestas()
    {
        return $this->hasMany('App\Models\Encuesta', 'medios_actualizacion_id');
    }
}
