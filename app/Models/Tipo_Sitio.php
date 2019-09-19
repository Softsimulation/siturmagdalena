<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Sitio[] $sitios
 * @property TipoSitiosConIdioma[] $tipoSitiosConIdiomas
 * @property int $id
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Sitio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_sitios';

    /**
     * @var array
     */
    protected $fillable = ['estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitios()
    {
        return $this->hasMany('App\Models\Sitio', 'tipo_sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoSitiosConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Sitio_Con_Idioma', 'tipo_sitios_id');
    }
}
