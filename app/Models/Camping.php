<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Alojamiento $alojamiento
 * @property int $id
 * @property int $alojamientos_id
 * @property float $area
 * @property int $total_parcelas
 * @property int $capacidad
 * @property float $tarifa
 * @property int $viajeros
 * @property int $viajeros_extranjeros
 * @property int $total_huespedes
 * @property int $capacidad_ocupada
 */
class Camping extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['alojamientos_id', 'area', 'total_parcelas', 'capacidad', 'tarifa', 'viajeros', 'viajeros_extranjeros', 'total_huespedes', 'capacidad_ocupada'];
    public $timestamps = false;
    
    protected $casts = [
        'tarifa' => 'float',
        'area' => 'int',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alojamiento()
    {
        return $this->belongsTo('App\Alojamiento', 'alojamientos_id');
    }
}
