<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property TiposCargo $tiposCargo
 * @property int $encuestas_id
 * @property int $tipos_cargos_id
 * @property int $sabeningles
 * @property int $nosabeningles
 */
class Dominiosingles extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sabeningles', 'nosabeningles'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public $timestamps = false;
     protected $primaryKey = 'encuestas_id';
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposCargo()
    {
        return $this->belongsTo('App\Models\TiposCargo', 'tipos_cargos_id');
    }
}
