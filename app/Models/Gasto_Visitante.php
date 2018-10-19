<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Divisa $divisa
 * @property Divisa $divisa
 * @property Rubro $rubro
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $rubros_id
 * @property int $divisas_fuera
 * @property int $divisas_magdalena
 * @property float $cantidad_pagada_fuera
 * @property float $cantidad_pagada_magdalena
 * @property int $personas_cubiertas
 * @property boolean $gastos_asumidos_otros
 */
class Gasto_Visitante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'gastos_visitante';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
       'cantidad_pagada_fuera' => 'float',
       'cantidad_pagada_magdalena' => 'float',
   ];
    /**
     * @var array
     */
    protected $fillable = ['divisas_fuera', 'divisas_magdalena', 'cantidad_pagada_fuera', 'cantidad_pagada_magdalena', 'personas_cubiertas', 'gastos_asumidos_otros','visitante_id','rubros_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisaFue()
    {
        return $this->belongsTo('App\Models\Divisa', 'divisas_fuera');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisaMag()
    {
        return $this->belongsTo('App\Models\Divisa', 'divisas_magdalena');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rubro()
    {
        return $this->belongsTo('App\Models\Rubro', 'rubros_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }
}
