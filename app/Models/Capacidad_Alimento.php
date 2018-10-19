<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProvisionesAlimento $provisionesAlimento
 * @property int $id_alimento
 * @property int $max_platos
 * @property int $platos_servidos
 * @property float $valor_plato
 * @property int $promedio_unidades
 * @property int $unidades_vendidas
 * @property int $bebidas_promedio
 * @property int $bebidas_servidas
 * @property float $valor_bebida
 * @property float $valor_unidad
 */
class Capacidad_Alimento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'capacidad_alimentos';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_alimento';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */

    /**
     * @var array
     */
    protected $fillable = ['max_platos', 'platos_servidos', 'valor_plato', 'promedio_unidades', 'unidades_vendidas', 'bebidas_promedio', 'bebidas_servidas', 'valor_bebida', 'valor_unidad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provisionesAlimento()
    {
        return $this->belongsTo('App\Models\Provision_Alimento', 'id_alimento');
    }
}
