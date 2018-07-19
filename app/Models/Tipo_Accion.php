<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AccionesAmbientale[] $accionesAmbientales
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property boolean $estado
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Accion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_acciones';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'estado', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesAmbientales()
    {
        return $this->hasMany('App\AccionesAmbientale', 'tipo_accion_id');
    }
}
