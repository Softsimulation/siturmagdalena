<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AccionesReducirEnergiaPst[] $accionesReducirEnergiaPsts
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $user_create
 * @property string $created_at
 * @property string $updated_at
 */
class Accion_Reducir_Energia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acciones_reduccir_energia';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'user_create', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesReducirEnergiaPsts()
    {
        return $this->hasMany('App\AccionesReducirEnergiaPst', 'acciones_reduccir_energia_id');
    }
}
