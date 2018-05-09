<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property TiposCargo $tiposCargo
 * @property int $tipos_cargos_id
 * @property int $encuestas_id
 * @property int $unsalario
 * @property int $unoatres
 * @property int $tresacinco
 * @property int $masdecinco
 */
class Asignacion_Salarial extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'asignaciones_salariales';

    /**
     * @var array
     */
    protected $fillable = ['unsalario', 'unoatres', 'tresacinco', 'masdecinco'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposCargo()
    {
        return $this->belongsTo('App\TiposCargo', 'tipos_cargos_id');
    }
}
