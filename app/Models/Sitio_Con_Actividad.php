<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property Sitio $sitio
 * @property int $id
 * @property int $actividades_id
 * @property int $sitios_id
 */
class Sitio_Con_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sitios_con_actividades';

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'sitios_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Models\Actividade', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitio()
    {
        return $this->belongsTo('App\Models\Sitio', 'sitios_id');
    }
}
