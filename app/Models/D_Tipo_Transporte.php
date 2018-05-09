<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HMedioTransporteInternoEmisor[] $hMedioTransporteInternoEmisors
 * @property HMedioTransporteReceptor[] $hMedioTransporteReceptors
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Tipo_Transporte extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tipos_transporte';

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
    public function hMedioTransporteInternoEmisors()
    {
        return $this->hasMany('App\HMedioTransporteInternoEmisor', 'tipos_transporte_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteReceptors()
    {
        return $this->hasMany('App\HMedioTransporteReceptor', 'tipos_transporte_id');
    }
}
