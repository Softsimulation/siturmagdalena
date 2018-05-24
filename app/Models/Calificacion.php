<?php

namespace App\Models;

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
    public $timestamps = false;
    public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = ['calificacion','item_evaluar_id','visitante_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itemsEvaluar()
    {
        return $this->belongsTo('App\Models\Item_Evaluar', 'item_evaluar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante','visitante_id');
    }
}
