<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OfertasVacante $ofertasVacante
 * @property PostuladosVacante $postuladosVacante
 * @property int $id
 * @property int $ofertas_vacante_id
 * @property int $postulados_vacante_id
 * @property string $fecha_postulacion
 * @property string $ruta_hoja_vida
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update
 * @property string $user_create
 * @property boolean $estado
 */
class Postulaciones_Vacante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'postulaciones_vacantes';

    /**
     * @var array
     */
    protected $fillable = ['ofertas_vacante_id', 'datos_usuario_id', 'fecha_postulacion', 'ruta_hoja_vida', 'created_at', 'updated_at', 'user_update', 'user_create', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ofertasVacante()
    {
        return $this->belongsTo('App\Models\Oferta_Vacante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postuladosVacante()
    {
        return $this->belongsTo('App\Models\Datos_Adicional_Usuario', 'datos_usuario_id');
    }
}
