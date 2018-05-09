<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DGruposActividad $dGruposActividad
 * @property DRangosSalario $dRangosSalario
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property DTiempoEmpleo $dTiempoEmpleo
 * @property DTiposProveedore $dTiposProveedore
 * @property DUbicacionProveedor $dUbicacionProveedor
 * @property integer $id
 * @property int $grupo_actividad_id
 * @property int $rango_salario_id
 * @property int $tiempo_empleo_id
 * @property int $tipo_proveedor_id
 * @property int $ubicacion_proveedor_id
 * @property float $promedio
 * @property int $tamaño_empresa_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class H_Promedio_Salarial_Grupo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_promedio_salarial_grupos';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['grupo_actividad_id', 'rango_salario_id', 'tiempo_empleo_id', 'tipo_proveedor_id', 'ubicacion_proveedor_id', 'promedio', 'tamaño_empresa_id', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dGruposActividad()
    {
        return $this->belongsTo('App\DGruposActividad', 'grupo_actividad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dRangosSalario()
    {
        return $this->belongsTo('App\DRangosSalario', 'rango_salario_id');
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
