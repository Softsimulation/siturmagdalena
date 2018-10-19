<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento $evento
 * @property int $id
 * @property int $eventos_id
 * @property string $ruta
 * @property boolean $tipo
 * @property boolean $portada
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Multimedia_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedia_evento';

    /**
     * @var array
     */
    protected $fillable = ['eventos_id', 'ruta', 'tipo', 'portada', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'eventos_id');
    }
}
