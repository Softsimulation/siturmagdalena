<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspectosEvaluado $aspectosEvaluado
 * @property Idioma $idioma
 * @property int $id
 * @property int $aspectos_evaluados_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Aspecto_Evaluado_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aspectos_evaluados_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['aspectos_evaluados_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspectosEvaluado()
    {
        return $this->belongsTo('App\AspectosEvaluado', 'aspectos_evaluados_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
