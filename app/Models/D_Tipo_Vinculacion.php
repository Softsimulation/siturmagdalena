<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HVinculacionLaboral[] $hVinculacionLaborals
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Tipo_Vinculacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tipo_vinculacion';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hVinculacionLaborals()
    {
        return $this->hasMany('App\HVinculacionLaboral', 'tipo_vinculacion_id');
    }
}
