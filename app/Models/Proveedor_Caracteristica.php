<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Caracteristica $caracteristica
 * @property Proveedore $proveedore
 * @property int $id
 * @property int $caracteristicas_id
 * @property int $proveedores_id
 */
class Proveedor_Caracteristica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proveedores_caracteristicas';

    /**
     * @var array
     */
    protected $fillable = ['caracteristicas_id', 'proveedores_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function caracteristica()
    {
        return $this->belongsTo('App\Caracteristica', 'caracteristicas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedores_id');
    }
}
