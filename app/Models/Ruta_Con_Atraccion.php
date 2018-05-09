<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property Ruta $ruta
 * @property int $id
 * @property int $atraccion_id
 * @property int $ruta_id
 * @property int $orden
 */
class Ruta_Con_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'rutas_con_atracciones';

    /**
     * @var array
     */
    protected $fillable = ['atraccion_id', 'ruta_id', 'orden'];

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
    public function ruta()
    {
        return $this->belongsTo('App\Ruta');
    }
}
