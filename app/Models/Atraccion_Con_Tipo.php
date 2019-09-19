<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property TipoAtraccione $tipoAtraccione
 * @property int $id
 * @property int $atracciones_id
 * @property int $tipo_atracciones_id
 */
class Atraccion_Con_Tipo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atracciones_con_tipo';

    /**
     * @var array
     */
    protected $fillable = ['atracciones_id', 'tipo_atracciones_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Models\Atracciones', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAtraccione()
    {
        return $this->belongsTo('App\Models\Tipo_Atraccion', 'tipo_atracciones_id');
    }
}
