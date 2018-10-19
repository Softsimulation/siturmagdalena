<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property RedesSociale $redesSociale
 * @property Viaje $viaje
 * @property int $redes_sociales_id
 * @property int $viajero_id
 */
class Redes_Sociales_Viajero extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'redes_sociales_viajeros';
    protected $primaryKey = 'viajero_id';
    public $timestamps=false;

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
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajero_id');
    }
}
