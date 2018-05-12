<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspectosEvaluadosConIdioma[] $aspectosEvaluadosConIdiomas
 * @property AtraccionesConIdioma[] $atraccionesConIdiomas
 * @property ActividadesRealizadasConIdioma[] $actividadesRealizadasConIdiomas
 * @property CategoriaTurismoConIdioma[] $categoriaTurismoConIdiomas
 * @property CategoriaProveedoresConIdioma[] $categoriaProveedoresConIdiomas
 * @property DestinoConIdioma[] $destinoConIdiomas
 * @property ElementosRepresentativosConIdioma[] $elementosRepresentativosConIdiomas
 * @property EventosConIdioma[] $eventosConIdiomas
 * @property FuentesInformacionDuranteViajeConIdioma[] $fuentesInformacionDuranteViajeConIdiomas
 * @property MotivosViajeConIdioma[] $motivosViajeConIdiomas
 * @property PaisesConIdioma[] $paisesConIdiomas
 * @property PerfilesUsuariosConIdioma[] $perfilesUsuariosConIdiomas
 * @property ProveedoresConIdioma[] $proveedoresConIdiomas
 * @property RubrosConIdioma[] $rubrosConIdiomas
 * @property RutasConIdioma[] $rutasConIdiomas
 * @property PublicacionesIdioma[] $publicacionesIdiomas
 * @property TipoAtraccionesConIdioma[] $tipoAtraccionesConIdiomas
 * @property SitiosConIdioma[] $sitiosConIdiomas
 * @property ServiciosPaqueteConIdioma[] $serviciosPaqueteConIdiomas
 * @property TipoCaracteristicaConIdioma[] $tipoCaracteristicaConIdiomas
 * @property TipoProveedoresConIdioma[] $tipoProveedoresConIdiomas
 * @property TipoSitiosConIdioma[] $tipoSitiosConIdiomas
 * @property TipoTurismoConIdioma[] $tipoTurismoConIdiomas
 * @property TipoProveedorPaqueteConIdioma[] $tipoProveedorPaqueteConIdiomas
 * @property TiposAlojamientoConIdioma[] $tiposAlojamientoConIdiomas
 * @property TiposAtencionSaludConIdioma[] $tiposAtencionSaludConIdiomas
 * @property TiposAcompañantesVisitantesConIdioma[] $tiposAcompañantesVisitantesConIdiomas
 * @property TipoEventosConIdioma[] $tipoEventosConIdiomas
 * @property VolveriaVisitarConIdioma[] $volveriaVisitarConIdiomas
 * @property ActividadesConIdioma[] $actividadesConIdiomas
 * @property DivisasConIdioma[] $divisasConIdiomas
 * @property CaracteristicasConIdioma[] $caracteristicasConIdiomas
 * @property TiposTransporteConIdioma[] $tiposTransporteConIdiomas
 * @property CategoriaDocumentoIdioma[] $categoriaDocumentoIdiomas
 * @property OpcionesLugaresConIdioma[] $opcionesLugaresConIdiomas
 * @property FinanciadoresViajesConIdioma[] $financiadoresViajesConIdiomas
 * @property TipoDestinoConIdioma[] $tipoDestinoConIdiomas
 * @property ItemsEvaluarConIdioma[] $itemsEvaluarConIdiomas
 * @property SectoresConIdioma[] $sectoresConIdiomas
 * @property TipoDocumentoIdioma[] $tipoDocumentoIdiomas
 * @property TiposViajeConIdioma[] $tiposViajeConIdiomas
 * @property int $id
 * @property string $nombre
 * @property string $culture
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Idioma extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'culture', 'user_update', 'estado', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aspectosEvaluadosConIdiomas()
    {
        return $this->hasMany('App\AspectosEvaluadosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesConIdiomas()
    {
        return $this->hasMany('App\AtraccionesConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasConIdiomas()
    {
        return $this->hasMany('App\ActividadesRealizadasConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConIdiomas()
    {
        return $this->hasMany('App\CategoriaTurismoConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaProveedoresConIdiomas()
    {
        return $this->hasMany('App\CategoriaProveedoresConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinoConIdiomas()
    {
        return $this->hasMany('App\DestinoConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementosRepresentativosConIdiomas()
    {
        return $this->hasMany('App\ElementosRepresentativosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventosConIdiomas()
    {
        return $this->hasMany('App\EventosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fuentesInformacionDuranteViajeConIdiomas()
    {
        return $this->hasMany('App\FuentesInformacionDuranteViajeConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function motivosViajeConIdiomas()
    {
        return $this->hasMany('App\MotivosViajeConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paisesConIdiomas()
    {
        return $this->hasMany('App\PaisesConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConIdiomas()
    {
        return $this->hasMany('App\PerfilesUsuariosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresConIdiomas()
    {
        return $this->hasMany('App\ProveedoresConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rubrosConIdiomas()
    {
        return $this->hasMany('App\RubrosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rutasConIdiomas()
    {
        return $this->hasMany('App\RutasConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicacionesIdiomas()
    {
        return $this->hasMany('App\PublicacionesIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoAtraccionesConIdiomas()
    {
        return $this->hasMany('App\TipoAtraccionesConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConIdiomas()
    {
        return $this->hasMany('App\SitiosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviciosPaqueteConIdiomas()
    {
        return $this->hasMany('App\Models\ServiciosPaqueteConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoCaracteristicaConIdiomas()
    {
        return $this->hasMany('App\TipoCaracteristicaConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoProveedoresConIdiomas()
    {
        return $this->hasMany('App\TipoProveedoresConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoSitiosConIdiomas()
    {
        return $this->hasMany('App\TipoSitiosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoTurismoConIdiomas()
    {
        return $this->hasMany('App\TipoTurismoConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoProveedorPaqueteConIdiomas()
    {
        return $this->hasMany('App\TipoProveedorPaqueteConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposAlojamientoConIdiomas()
    {
        return $this->hasMany('App\TiposAlojamientoConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposAtencionSaludConIdiomas()
    {
        return $this->hasMany('App\TiposAtencionSaludConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposAcompañantesVisitantesConIdiomas()
    {
        return $this->hasMany('App\TiposAcompañantesVisitantesConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoEventosConIdiomas()
    {
        return $this->hasMany('App\TipoEventosConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function volveriaVisitarConIdiomas()
    {
        return $this->hasMany('App\VolveriaVisitarConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesConIdiomas()
    {
        return $this->hasMany('App\ActividadesConIdioma', 'idiomas');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisasConIdiomas()
    {
        return $this->hasMany('App\Models\DivisasConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caracteristicasConIdiomas()
    {
        return $this->hasMany('App\CaracteristicasConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposTransporteConIdiomas()
    {
        return $this->hasMany('App\TiposTransporteConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaDocumentoIdiomas()
    {
        return $this->hasMany('App\CategoriaDocumentoIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionesLugaresConIdiomas()
    {
        return $this->hasMany('App\Models\OpcionesLugaresConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financiadoresViajesConIdiomas()
    {
        return $this->hasMany('App\Models\FinanciadoresViajesConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoDestinoConIdiomas()
    {
        return $this->hasMany('App\TipoDestinoConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemsEvaluarConIdiomas()
    {
        return $this->hasMany('App\ItemsEvaluarConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresConIdiomas()
    {
        return $this->hasMany('App\SectoresConIdioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoDocumentoIdiomas()
    {
        return $this->hasMany('App\TipoDocumentoIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposViajeConIdiomas()
    {
        return $this->hasMany('App\TiposViajeConIdioma', 'idiomas_id');
    }
}
