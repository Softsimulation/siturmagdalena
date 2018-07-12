<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Sitio $sitio
 * @property int $id
 * @property int $sitios_id
 * @property string $ruta
 * @property boolean $tipo
 * @property boolean $portada
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Multimedia_Sitio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedia_sitios';

    /**
     * @var array
     */
    protected $fillable = ['sitios_id', 'ruta', 'tipo', 'portada', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitio()
    {
        return $this->belongsTo('App\Modelss\Sitio', 'sitios_id');
    }
}
