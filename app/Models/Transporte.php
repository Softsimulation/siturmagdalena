<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property TipoTransporteOfertum $tipoTransporteOfertum
 * @property OfertaTransporte[] $ofertaTransportes
 * @property int $id
 * @property int $encuestas_id
 * @property int $tipos_transporte_oferta_id
 * @property int $numero_vehiculos
 * @property int $personas
 */
class Transporte extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'tipos_transporte_oferta_id', 'numero_vehiculos', 'personas'];
    public $timestamps = false;
     public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoTransporteOferta()
    {
        return $this->belongsTo('App\Models\Tipo_Transporte_Oferta', 'tipos_transporte_oferta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ofertaTransportes()
    {
        return $this->hasMany('App\Models\Oferta_Transporte');
    }
}
