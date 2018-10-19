<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property RubroInterno $rubroInterno
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property int $rubros_id
 * @property float $valor
 * @property boolean $gastos_realizados_otros
 * @property int $personas_cubrio
 * @property float $valor_fuera
 */
class Viaje_Gasto_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viajes_gastos_interno';

    /**
     * @var array
     */
    protected $fillable = [ 'rubros_id', 'valor', 'gastos_realizados_otros', 'personas_cubrio', 'valor_fuera'];
    
    public $timestamps = false;
    
    public $primaryKey = 'viajes_id';

    protected $casts = [
        'valor' => 'int',
        'valor_fuera' => 'int',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rubroInterno()
    {
        return $this->belongsTo('App\RubroInterno', 'rubros_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
