<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora $agenciasOperadora
 * @property Tour $tour
 * @property int $tours_id
 * @property int $agencia_operadora_id
 */
class Tour_Con_Agencia_Deportiva extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tours_con_agencias_deportivas';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agenciasOperadora()
    {
        return $this->belongsTo('App\AgenciasOperadora', 'agencia_operadora_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tour()
    {
        return $this->belongsTo('App\Tour', 'tours_id');
    }
}
