<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspectosEvaluado $aspectosEvaluado
 * @property Calificacion[] $calificacions
 * @property ItemsEvaluarConIdioma[] $itemsEvaluarConIdiomas
 * @property int $id
 * @property int $aspectos_evaluar_id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Item_Evaluar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'items_evaluar';

    /**
     * @var array
     */
    protected $fillable = ['aspectos_evaluar_id', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspectosEvaluado()
    {
        return $this->belongsTo('App\AspectosEvaluado', 'aspectos_evaluar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calificacions()
    {
        return $this->hasMany('App\Models\Calificacion', 'item_evaluar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemsEvaluarConIdiomas()
    {
        return $this->hasMany('App\Models\Item_Evaluar_Con_Idioma','items_evaluar_id');
    }
}
