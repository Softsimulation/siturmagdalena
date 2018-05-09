<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTamañoOcupacionHotel $dTamañoOcupacionHotel
 * @property DTiempo $dTiempo
 * @property DTiposProveedore $dTiposProveedore
 * @property DUbicacionProveedor $dUbicacionProveedor
 * @property integer $id
 * @property int $tiempo_id
 * @property int $tipo_proveedor_id
 * @property int $ubicacion_proveedor_id
 * @property float $denominador
 * @property float $numerador
 * @property int $tamaño_empresa_id
 * @property int $tamaño_ocupacion_hotel_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class H_Ocupacion_Hotel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_ocupacion_hoteles';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tiempo_id', 'tipo_proveedor_id', 'ubicacion_proveedor_id', 'denominador', 'numerador', 'tamaño_empresa_id', 'tamaño_ocupacion_hotel_id', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

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
    public function dTamañoOcupacionHotel()
    {
        return $this->belongsTo('App\DTamañoOcupacionHotel', '"tamaño_ocupacion_hotel_id"');
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
