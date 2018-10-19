<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HAlojamientosInternoEmisor[] $hAlojamientosInternoEmisors
 * @property HAlojamientosReceptor[] $hAlojamientosReceptors
 * @property HDuracionMediaEstanciaInternoEmisor[] $hDuracionMediaEstanciaInternoEmisors
 * @property HDuracionMediaEstanciaReceptor[] $hDuracionMediaEstanciaReceptors
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Tipos_Alojamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tipos_alojamiento';

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
    public function hAlojamientosInternoEmisors()
    {
        return $this->hasMany('App\HAlojamientosInternoEmisor', 'tipo_alojamiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosReceptors()
    {
        return $this->hasMany('App\HAlojamientosReceptor', 'tipo_alojamiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaInternoEmisors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaInternoEmisor', 'tipo_alojamiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaReceptors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaReceptor', 'tipos_alojamiento_id');
    }
}
