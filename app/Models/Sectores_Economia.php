<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SectoresEconomiaSostenibilidad[] $sectoresEconomiaSostenibilidads
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $updated_at
 * @property string $user_update
 */
class Sectores_Economia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sectores_economia';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'estado', 'user_create', 'updated_at', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresEconomiaSostenibilidads()
    {
        return $this->hasMany('App\SectoresEconomiaSostenibilidad', 'sectores_economia_id');
    }
}
