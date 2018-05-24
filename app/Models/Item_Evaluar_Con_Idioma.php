<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property ItemsEvaluar $itemsEvaluar
 * @property int $id
 * @property int $idiomas_id
 * @property int $items_evaluar_id
 * @property string $nombre
 */
class Item_Evaluar_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'items_evaluar_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'items_evaluar_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itemsEvaluar()
    {
        return $this->belongsTo('App\ItemsEvaluar');
    }
}
