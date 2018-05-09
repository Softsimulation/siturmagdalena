<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FinanciadoresViaje $financiadoresViaje
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $financiadores_viajes_id
 */
class Visitante_Gasto_Pagado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitante_gastos_pagados';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financiadoresViaje()
    {
        return $this->belongsTo('App\FinanciadoresViaje', 'financiadores_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
