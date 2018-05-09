<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ItemsEvaluar $itemsEvaluar
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $item_evaluar_id
 * @property int $calificacion
 */
class Calificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'calificacion';

    /**
     * @var array
     */
    protected $fillable = ['calificacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itemsEvaluar()
    {
        return $this->belongsTo('App\ItemsEvaluar', 'item_evaluar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
