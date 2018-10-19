<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DTamañoCapacidadRestaurante $dTamañoCapacidadRestaurante
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTiempo $dTiempo
 * @property DTiposProveedore $dTiposProveedore
 * @property DUbicacionProveedor $dUbicacionProveedor
 * @property integer $id
 * @property int $tiempo_id
 * @property int $tipo_proveedor_id
 * @property int $ubicacion_proveedor_id
 * @property float $numerador
 * @property float $denominador
 * @property int $tamaño_empresa_id
 * @property int $tamaño_capacidad_restaurante_id
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class H_Capacidad_Restaurante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_capacidad_restaurante';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tiempo_id', 'tipo_proveedor_id', 'ubicacion_proveedor_id', 'numerador', 'denominador', 'tamaño_empresa_id', 'tamaño_capacidad_restaurante_id', 'updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTamañoCapacidadRestaurante()
    {
        return $this->belongsTo('App\DTamañoCapacidadRestaurante', '"tamaño_capacidad_restaurante_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTamañoEmpresa()
    {
        return $this->belongsTo('App\DTamañoEmpresa', '"tamaño_empresa_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTiempo()
    {
        return $this->belongsTo('App\DTiempo', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTiposProveedore()
    {
        return $this->belongsTo('App\DTiposProveedore', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dUbicacionProveedor()
    {
        return $this->belongsTo('App\DUbicacionProveedor', 'ubicacion_proveedor_id');
    }
}
