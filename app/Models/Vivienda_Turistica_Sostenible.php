<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ComponentesSociale $componentesSociale
 * @property int $casas_sostenibilidad_id
 * @property int $cantidad
 * @property string $razon_cambio
 * @property int $numero_meses
 * @property int $cuantas_rnt
 */
class Vivienda_Turistica_Sostenible extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viviendas_turisticas_sostenible';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'casas_sostenibilidad_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['cantidad', 'razon_cambio', 'numero_meses', 'cuantas_rnt'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function componentesSociale()
    {
        return $this->belongsTo('App\Models\Componente_Social', 'casas_sostenibilidad_id', 'casas_sostenibilidad_id');
    }
}
