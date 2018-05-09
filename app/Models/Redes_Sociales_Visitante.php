<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property RedesSociale $redesSociale
 * @property Visitante $visitante
 * @property int $redes_sociales_id
 * @property int $visitante_id
 */
class Redes_Sociales_Visitante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'redes_sociales_visitante';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function redesSociale()
    {
        return $this->belongsTo('App\RedesSociale', 'redes_sociales_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
