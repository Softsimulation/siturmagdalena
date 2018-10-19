<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Destino $destino
 * @property int $id
 * @property int $destino_id
 * @property string $ruta
 * @property boolean $tipo
 * @property boolean $portada
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Multimedia_Destino extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedia_destino';

    /**
     * @var array
     */
    protected $fillable = ['destino_id', 'ruta', 'tipo', 'portada', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destino()
    {
        return $this->belongsTo('App\Models\Destino');
    }
}
