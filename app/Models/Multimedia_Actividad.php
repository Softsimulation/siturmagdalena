<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property int $id
 * @property int $actividades_id
 * @property string $ruta
 * @property boolean $tipo
 * @property boolean $portada
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Multimedia_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedias_actividades';

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'ruta', 'tipo', 'portada', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Models\Actividade', 'actividades_id');
    }
}
