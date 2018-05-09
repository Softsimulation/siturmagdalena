<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Transporte $transporte
 * @property int $id
 * @property int $transporte_id
 * @property float $personas_total
 * @property float $tarifa_promedio
 */
class Oferta_Transporte extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'oferta_transporte';

    /**
     * @var array
     */
    protected $fillable = ['transporte_id', 'personas_total', 'tarifa_promedio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transporte()
    {
        return $this->belongsTo('App\Transporte');
    }
}
