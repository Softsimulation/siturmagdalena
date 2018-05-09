<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DGruposActividad $dGruposActividad
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTiempoEmpleo $dTiempoEmpleo
 * @property DTiposProveedore $dTiposProveedore
 * @property DUbicacionProveedor $dUbicacionProveedor
 * @property integer $id
 * @property int $grupos_actividad_id
 * @property int $tiempo_empleo_id
 * @property int $tipo_proveedor_id
 * @property int $ubicacion_proveedor_id
 * @property float $frecuencia
 * @property boolean $hablan_ingles
 * @property int $tamaño_empresa_id
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class H_Empleado_Dominio_Ingles extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_empleados_dominio_ingles';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['grupos_actividad_id', 'tiempo_empleo_id', 'tipo_proveedor_id', 'ubicacion_proveedor_id', 'frecuencia', 'hablan_ingles', 'tamaño_empresa_id', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dGruposActividad()
    {
        return $this->belongsTo('App\DGruposActividad', 'grupos_actividad_id');
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
    public function dTiempoEmpleo()
    {
        return $this->belongsTo('App\DTiempoEmpleo', 'tiempo_empleo_id');
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
