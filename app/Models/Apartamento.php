<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Alojamiento $alojamiento
 * @property int $id
 * @property int $alojamientos_id
 * @property int $total
 * @property int $capacidad
 * @property float $habitaciones
 * @property float $tarifa
 * @property int $capacidad_ocupada
 * @property int $viajeros
 * @property int $viajeros_colombianos
 * @property int $viajeros_extranjeros
 * @property int $total_huespedes
 */
class Apartamento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['alojamientos_id', 'total', 'capacidad', 'habitaciones', 'tarifa', 'capacidad_ocupada', 'viajeros', 'viajeros_colombianos', 'viajeros_extranjeros', 'total_huespedes'];
    public $timestamps = false;
    
    protected $casts = [
        'tarifa' => 'float',
        'habitaciones' => 'int',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alojamiento()
    {
        return $this->belongsTo('App\Alojamiento', 'alojamientos_id');
    }
}
