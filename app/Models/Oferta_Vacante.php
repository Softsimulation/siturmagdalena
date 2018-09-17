<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProveedoresRnt $proveedoresRnt
 * @property Municipio $municipio
 * @property NivelEducacion $nivelEducacion
 * @property int $id
 * @property int $proveedores_rnt_id
 * @property int $municipio_id
 * @property int $nivel_educacion_id
 * @property string $nombre
 * @property string $perfil
 * @property int $anios_experiencia
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property float $salario
 * @property int $numero_vacantes
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_update
 * @property string $user_create
 * @property string $requisitos
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
    protected $fillable = ['proveedores_rnt_id', 'municipio_id', 'nivel_educacion_id', 'nombre', 'perfil', 'anios_experiencia', 'fecha_inicio', 'fecha_fin', 'salario', 'numero_vacantes', 'updated_at', 'created_at', 'estado', 'user_update', 'user_create', 'requisitos'];
    

    
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
}
