<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property int $encuesta_pst_sosteniblidad_id
 * @property string $tipo_agua
 * @property string $uso_agua
 */
class Agua_Reciclada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aguas_recicladas';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'encuesta_pst_sosteniblidad_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['tipo_agua', 'uso_agua','encuesta_pst_sosteniblidad_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad', 'encuesta_pst_sosteniblidad_id');
    }
}
