<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Vacante[] $vacantes
 * @property int $id
 * @property int $encuesta_id
 * @property int $apertura
 * @property int $crecimiento
 * @property int $remplazo
 */
class Razon_Vacante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'razones_vacantes';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['encuesta_id', 'apertura', 'crecimiento', 'remplazo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vacantes()
    {
        return $this->belongsToMany('App\Models\Vacante', 'opciones_vacantes', 'razon_vacante_id');
    }
}
