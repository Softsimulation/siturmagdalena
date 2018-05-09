<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesServicio $actividadesServicio
 * @property Encuesta $encuesta
 * @property Especialidade $especialidade
 * @property CapacidadAlimento $capacidadAlimento
 * @property int $id
 * @property int $actividades_servicio_id
 * @property int $encuestas_id
 * @property int $especialidades_id
 * @property int $numero_mesas
 * @property int $numero_asientos
 */
class Provision_Alimento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'provisiones_alimentos';

    /**
     * @var array
     */
    protected $fillable = ['actividades_servicio_id', 'encuestas_id', 'especialidades_id', 'numero_mesas', 'numero_asientos'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadesServicio()
    {
        return $this->belongsTo('App\ActividadesServicio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidade()
    {
        return $this->belongsTo('App\Especialidade', 'especialidades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function capacidadAlimento()
    {
        return $this->hasOne('App\CapacidadAlimento', 'id_alimento');
    }
}
