<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HDuracionMediaEstanciaEstablecimientoComercial[] $hDuracionMediaEstanciaEstablecimientoComercials
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $created_at
 * @property string $user_update
 * @property boolean $estado
 * @property string $updated_at
 * @property string $user_create
 */
class D_Establecimiento_Comercial extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_establecimiento_comercial';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'created_at', 'user_update', 'estado', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoComercial', 'establecimiento_comercial_id');
    }
}
