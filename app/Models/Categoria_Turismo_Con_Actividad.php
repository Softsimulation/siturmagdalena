<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property CategoriaTurismo $categoriaTurismo
 * @property int $id
 * @property int $actividades_id
 * @property int $categoria_turismo_id
 */
class Categoria_Turismo_Con_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo_con_actividades';

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'categoria_turismo_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaTurismo()
    {
        return $this->belongsTo('App\CategoriaTurismo');
    }
}
