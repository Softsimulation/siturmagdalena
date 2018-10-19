<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HGastoMedioTotalReceptor[] $hGastoMedioTotalReceptors
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class D_Rubro_Gasto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_rubros_gastos';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalReceptors()
    {
        return $this->hasMany('App\HGastoMedioTotalReceptor', 'rubros_id');
    }
}
