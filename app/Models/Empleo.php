<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $tiempo_completo
 * @property int $medio_tiempo
 */
class Empleo extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'tiempo_completo', 'medio_tiempo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public $timestamps = false;
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }
}
