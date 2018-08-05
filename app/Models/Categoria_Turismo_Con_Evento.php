<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaTurismo $categoriaTurismo
 * @property Evento $evento
 * @property int $id
 * @property int $categoria_turismo_id
 * @property int $eventos_id
 */
class Categoria_Turismo_Con_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo_con_eventos';

    /**
     * @var array
     */
    protected $fillable = ['categoria_turismo_id', 'eventos_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaTurismo()
    {
        return $this->belongsTo('App\Models\Categoria_Turismo', 'categoria_turismo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'eventos_id');
    }
}
