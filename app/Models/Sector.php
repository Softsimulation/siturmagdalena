<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Destino $destino
 * @property Sitio[] $sitios
 * @property SectoresConIdioma[] $sectoresConIdiomas
 * @property int $id
 * @property int $destino_id
 * @property boolean $es_urbano
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Sector extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sectores';

    /**
     * @var array
     */
    protected $fillable = ['destino_id', 'es_urbano', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destino()
    {
        return $this->belongsTo('App\Models\Destino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitios()
    {
        return $this->hasMany('App\Models\Sitio', 'sectores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresConIdiomas()
    {
        return $this->hasMany('App\Models\Sector_Con_Idioma', 'sectores_id');
    }
}
