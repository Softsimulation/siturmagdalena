<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Planificador $planificador
 * @property Proveedore $proveedore
 * @property int $id
 * @property int $planificador_id
 * @property int $proveedor_id
 * @property int $dia
 * @property int $orden_visita
 */
class Planificador_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planificador_proveedores';
    
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['planificador_id', 'proveedor_id', 'dia', 'orden_visita'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planificador()
    {
        return $this->belongsTo('App\Planificador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedor_id');
    }
}
