<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ElementosRepresentativo $elementosRepresentativo
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $elementos_representativos_id
 */
class Elemento_Representativo_Favorito extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'elementos_representativos_favoritos';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function elementosRepresentativo()
    {
        return $this->belongsTo('App\ElementosRepresentativo', 'elementos_representativos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
