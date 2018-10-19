<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Alojamiento $alojamiento
 * @property int $id
 * @property int $alojamientos_id
 * @property int $total
 * @property int $total_camas
 * @property int $capacidad
 * @property float $tarifa
 * @property int $numero_personas
 * @property int $viajeros_locales
 * @property int $viajeros_extranjeros
 * @property int $habitaciones_ocupadas
 * @property int $total_huespedes
 */
class Habitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'habitaciones';

    public $timestamps = false;
    
    protected $casts = [
        'tarifa' => 'float'
    ];
    
    /**
     * @var array
     */
    protected $fillable = ['alojamientos_id', 'total', 'total_camas', 'capacidad', 'tarifa', 'numero_personas', 'viajeros_locales', 'viajeros_extranjeros', 'habitaciones_ocupadas', 'total_huespedes'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alojamiento()
    {
        return $this->belongsTo('App\Alojamiento', 'alojamientos_id');
    }
}
