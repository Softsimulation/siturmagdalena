<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property Visitante $visitante
 * @property int $atraccion_id
 * @property int $visitante_id
 */
class Atraccion_Favorita_Visitante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atracciones_favoritas_visitante';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Atraccione', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
