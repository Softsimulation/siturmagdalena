<?php

namespace App\Models;

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
     
     public $timestamps = false;
     
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }
}
