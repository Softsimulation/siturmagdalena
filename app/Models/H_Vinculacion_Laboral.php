<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTiempoEmpleo $dTiempoEmpleo
 * @property DTipoVinculacion $dTipoVinculacion
 * @property DTiposProveedore $dTiposProveedore
 * @property DUbicacionProveedor $dUbicacionProveedor
 * @property integer $id
 * @property int $tiempo_empleo_id
 * @property int $tipo_vinculacion_id
 * @property int $tipo_proveedor_id
 * @property int $ubicacion_proveedor_id
 * @property float $frecuencia
 * @property int $tamaño_empresa_id
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class H_Vinculacion_Laboral extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_vinculacion_laboral';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tiempo_empleo_id', 'tipo_vinculacion_id', 'tipo_proveedor_id', 'ubicacion_proveedor_id', 'frecuencia', 'tamaño_empresa_id', 'updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

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
    public function dTiempoEmpleo()
    {
        return $this->belongsTo('App\DTiempoEmpleo', 'tiempo_empleo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTipoVinculacion()
    {
        return $this->belongsTo('App\DTipoVinculacion', 'tipo_vinculacion_id');
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
