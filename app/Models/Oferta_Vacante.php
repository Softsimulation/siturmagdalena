<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TiposCargosVacante $tiposCargosVacante
 * @property ProveedoresRnt $proveedoresRnt
 * @property Municipio $municipio
 * @property NivelEducacion $nivelEducacion
 * @property int $id
 * @property int $tipo_cargo_vacante_id
 * @property int $proveedores_rnt_id
 * @property int $municipio_id
 * @property int $nivel_educacion_id
 * @property string $nombre
 * @property string $descripcion
 * @property int $anios_experiencia
 * @property string $fecha_vencimiento
 * @property float $salario_minimo
 * @property int $numero_vacantes
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_update
 * @property string $user_create
 * @property string $requisitos
 * @property string $fecha_publicacion
 * @property int $numero_maximo_postulaciones
 * @property float $salario_maximo
 * @property boolean $es_publico
 */
class Oferta_Vacante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ofertas_vacantes';

    /**
     * @var array
     */
    protected $fillable = ['tipo_cargo_vacante_id', 'proveedores_rnt_id', 'municipio_id', 'nivel_educacion_id', 'nombre', 'descripcion', 'anios_experiencia', 'fecha_vencimiento', 'salario_minimo', 'numero_vacantes', 'updated_at', 'created_at', 'estado', 'user_update', 'user_create', 'requisitos', 'fecha_publicacion', 'numero_maximo_postulaciones', 'salario_maximo', 'es_publico'];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposCargosVacante()
    {
        return $this->belongsTo('App\Models\Tipo_Cargo_Vacante', 'tipo_cargo_vacante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedoresRnt()
    {
        return $this->belongsTo('App\Models\Proveedores_rnt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Models\Municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelEducacion()
    {
        return $this->belongsTo('App\Models\Nivel_Educacion');
    }
    
    public function postulaciones(){
        return $this->hasMany('App\Models\Postulaciones_Vacante', 'ofertas_vacante_id');
    }
    
    public function scopeSearch($query, $request){
        $query->where(function($q)use($request){ if( isset($request->proveedor) && $request->proveedor != null ){$q->where('proveedores_rnt_id',$request->proveedor);}})
            ->where(function($q)use($request){ if( isset($request->municipio) && $request->municipio != null ){$q->where('municipio_id',$request->municipio);}})
            ->where(function($q)use($request){ if( isset($request->tipoCargo) && $request->tipoCargo != null ){$q->where('tipo_cargo_vacante_id',$request->tipoCargo);}})
            ->where(function($q)use($request){ if( isset($request->nivelEducacion) && $request->nivelEducacion != null ){$q->where('nivel_educacion_id',$request->nivelEducacion);}})
            ->where(function($q)use($request){ if( isset($request->nombreVacante) && $request->nombreVacante != null ){$q->where('nombre','like','%'.$request->nombreVacante.'%');}});
    }
    
}
