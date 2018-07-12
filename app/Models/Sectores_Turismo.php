<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SectoresTurismosSostenibilidad[] $sectoresTurismosSostenibilidads
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $user_update
 * @property string $updated_at
 */
class Sectores_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sectores_turismos';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'user_create', 'estado', 'user_update', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresTurismosSostenibilidads()
    {
        return $this->hasMany('App\SectoresTurismosSostenibilidad', 'sectores_turismos_id');
    }
}
