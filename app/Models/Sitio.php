<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Sectore $sectore
 * @property TipoSitio $tipoSitio
 * @property Atraccione[] $atracciones
 * @property MultimediaSitio[] $multimediaSitios
 * @property Proveedore[] $proveedores
 * @property SitiosConIdioma[] $sitiosConIdiomas
 * @property SitiosParaEncuesta[] $sitiosParaEncuestas
 * @property SitiosConActividade[] $sitiosConActividades
 * @property SitiosConEvento[] $sitiosConEventos
 * @property int $id
 * @property int $sectores_id
 * @property int $tipo_sitios_id
 * @property string $latitud
 * @property string $longitud
 * @property string $direccion
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class Sitio extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sectores_id', 'tipo_sitios_id', 'latitud', 'longitud', 'direccion', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sectore()
    {
        return $this->belongsTo('App\Sectore', 'sectores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSitio()
    {
        return $this->belongsTo('App\TipoSitio', 'tipo_sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atracciones()
    {
        return $this->hasMany('App\Atraccione', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediaSitios()
    {
        return $this->hasMany('App\MultimediaSitio', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedores()
    {
        return $this->hasMany('App\Proveedore', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConIdiomas()
    {
        return $this->hasMany('App\Models\Sitio_Con_Idioma', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosParaEncuestas()
    {
        return $this->hasMany('App\SitiosParaEncuesta', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConActividades()
    {
        return $this->hasMany('App\SitiosConActividade', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConEventos()
    {
        return $this->hasMany('App\SitiosConEvento', 'sitios_id');
    }
}
