<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property CategoriaTurismo $categoriaTurismo
 * @property int $id
 * @property int $atracciones_id
 * @property int $categoria_turismo_id
 */
class Categoria_Turismo_Con_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo_con_atracciones';

    /**
     * @var array
     */
    protected $fillable = ['atracciones_id', 'categoria_turismo_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Models\Atraccione', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaTurismo()
    {
        return $this->belongsTo('App\Models\Categoria_Turismo');
    }
}
