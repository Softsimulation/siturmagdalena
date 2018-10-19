<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property LugaresAplicacionEncuestum $lugaresAplicacionEncuestum
 * @property TiposViaje $tiposViaje
 * @property Visitante[] $visitantes
 * @property int $id
 * @property int $digitador_id
 * @property int $lugar_aplicacion_id
 * @property int $tipo_viaje_id
 * @property int $mayores_quince
 * @property int $menores_quince
 * @property int $mayores_quince_no_presentes
 * @property int $menores_quince_no_presentes
 * @property int $personas_magdalena
 * @property string $fecha_aplicacion
 * @property int $personas_encuestadas
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Grupo_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'grupos_viaje';

    /**
     * @var array
     */
    protected $fillable = ['digitador_id', 'lugar_aplicacion_id', 'tipo_viaje_id', 'mayores_quince', 'menores_quince', 'mayores_quince_no_presentes', 'menores_quince_no_presentes', 'personas_magdalena', 'fecha_aplicacion', 'personas_encuestadas', 'updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Models\Digitador', 'digitador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lugaresAplicacionEncuestum()
    {
        return $this->belongsTo('App\Models\Lugar_Aplicacion_Encuesta', 'lugar_aplicacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposViaje()
    {
        return $this->belongsTo('App\Models\Tipo_Viaje', 'tipo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Models\Visitante', 'grupo_viaje_id');
    }
}
