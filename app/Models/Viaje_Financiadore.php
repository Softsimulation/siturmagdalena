<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FinanciadoresViaje $financiadoresViaje
 * @property Viaje $viaje
 * @property int $financiadores_id
 * @property int $viaje_id
 */
class Viaje_Financiadore extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viajes_financiadores';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financiadoresViaje()
    {
        return $this->belongsTo('App\FinanciadoresViaje', 'financiadores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje');
    }
}
