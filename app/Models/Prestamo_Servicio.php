<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora $agenciasOperadora
 * @property int $id
 * @property int $agencia_operadora_id
 * @property float $numero_personas
 * @property float $personas_colombianas
 * @property float $personas_extranjeras
 * @property float $personas_magdalena
 */
class Prestamo_Servicio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'prestamos_servicios';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['agencia_operadora_id', 'numero_personas', 'personas_colombianas', 'personas_extranjeras', 'personas_magdalena'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agenciasOperadora()
    {
        return $this->belongsTo('App\AgenciasOperadora', 'agencia_operadora_id');
    }
}
