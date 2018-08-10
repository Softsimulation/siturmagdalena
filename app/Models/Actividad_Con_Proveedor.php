<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PerfilesUsuario $perfilesUsuario
 * @property Proveedore $proveedore
 * @property int $id
 * @property int $actividades_id
 * @property int $proveedores_id
 */
class Actividades_Con_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['actividad_id', 'proveedor_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividad()
    {
        return $this->belongsTo('App\Models\Actividades', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Models\Proveedor', 'proveedores_id');
    }
}
