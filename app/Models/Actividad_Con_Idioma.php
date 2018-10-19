<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property Idioma $idioma
 * @property int $id
 * @property int $actividades_id
 * @property int $idiomas
 * @property string $nombre
 * @property string $descripcion
 */
class Actividad_Con_Idioma extends Model
{
    /**
     * The timestamps.
     * 
     * @var bool
     */   
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'idiomas', 'nombre', 'descripcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Models\Actividad', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas');
    }
}
