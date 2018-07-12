<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CapacitacionesEmpleo[] $capacitacionesEmpleos
 * @property int $id
 * @property string $nombre
 * @property boolean $tipo_nivel
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 */
class Linea_Tematica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lineas_tematicas';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'tipo_nivel', 'created_at', 'updated_at', 'estado', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function capacitacionesEmpleos()
    {
        return $this->belongsToMany('App\Models\Capacitacion_Empleo', 'tematicas_aplicadas_encuestas', 'linea_tematica_id', 'encuesta_id');
    }
}
