<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $administrativo
 * @property int $gerencial
 * @property int $operativo
 */
class Vacante extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'administrativo', 'gerencial', 'operativo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }
}
