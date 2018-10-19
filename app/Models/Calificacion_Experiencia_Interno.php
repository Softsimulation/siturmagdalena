<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ExperienciasDepartamento $experienciasDepartamento
 * @property ValorCalificacion $valorCalificacion
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property int $experiencias_departamento_id
 * @property int $valor_calificacion_id
 */
class Calificacion_Experiencia_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'calificacion_experiencia_interno';
    public $timestamps=false;
    protected $primaryKey = 'viajes_id';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function experienciasDepartamento()
    {
        return $this->belongsTo('App\ExperienciasDepartamento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function valorCalificacion()
    {
        return $this->belongsTo('App\ValorCalificacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
