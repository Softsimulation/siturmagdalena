<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property Idioma $idioma
 * @property int $id
 * @property int $atracciones_id
 * @property int $idiomas_id
 * @property string $como_llegar
 * @property string $horario
 * @property string $periodo
 * @property string $recomendaciones
 * @property string $reglas
 */
class Atraccion_Con_Idioma extends Model
{
    /**
     * The timestamps.
     * 
     * @var bool
     */   
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atracciones_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['atracciones_id', 'idiomas_id', 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas'];

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
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
