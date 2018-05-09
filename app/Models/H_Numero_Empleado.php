<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DDestinoProveedor $dDestinoProveedor
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTiempo $dTiempo
 * @property DTiposProveedore $dTiposProveedore
 * @property integer $id
 * @property int $destino_proveedor_id
 * @property int $tiempo_id
 * @property int $tipo_proveedor_id
 * @property float $frecuencia
 * @property int $tamaño_empresa_id
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class H_Numero_Empleado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_numero_empleados';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['destino_proveedor_id', 'tiempo_id', 'tipo_proveedor_id', 'frecuencia', 'tamaño_empresa_id', 'updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dDestinoProveedor()
    {
        return $this->belongsTo('App\DDestinoProveedor', 'destino_proveedor_id');
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
}
