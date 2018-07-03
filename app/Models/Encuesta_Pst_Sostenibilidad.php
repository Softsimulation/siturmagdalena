<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProveedoresRnt $proveedoresRnt
 * @property ComponenteSocialPst $componenteSocialPst
 * @property AccionesCulturalesPst[] $accionesCulturalesPsts
 * @property EsquemasPst[] $esquemasPsts
 * @property BeneficiosEsquemasPst[] $beneficiosEsquemasPsts
 * @property ComponenteAmbientalPst $componenteAmbientalPst
 * @property ActividadesAmbientalesPst[] $actividadesAmbientalesPsts
 * @property ProgramasConservacionPst[] $programasConservacionPsts
 * @property PlanesMitigacionPst[] $planesMitigacionPsts
 * @property InformesGestionPst $informesGestionPst
 * @property ActividadesResiduosPst[] $actividadesResiduosPsts
 * @property AccionesReducirEnergiaPst[] $accionesReducirEnergiaPsts
 * @property EnergiasRenovablesPst $energiasRenovablesPst
 * @property ComponenteEconomicoPst $componenteEconomicoPst
 * @property ClasificacionesProveedoresPst[] $clasificacionesProveedoresPsts
 * @property AspectosSeleccionPst[] $aspectosSeleccionPsts
 * @property BeneficiosEconomicosPst[] $beneficiosEconomicosPsts
 * @property BeneficiosEconomicosTemporadaPst[] $beneficiosEconomicosTemporadaPsts
 * @property EspaciosAlojamiento $espaciosAlojamiento
 * @property ResponsabilidadesSociale $responsabilidadesSociale
 * @property int $id
 * @property int $proveedores_rnt_id
 * @property string $nombre_contacto
 * @property string $lugar_encuesta
 * @property string $cargo
 * @property string $fecha_aplicacion
 * @property boolean $conoce_marca
 * @property boolean $autoriza_tratamiento
 * @property boolean $autorizacion
 */
class Encuesta_Pst_Sostenibilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'encuestas_pst_sostenibilidad';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['proveedores_rnt_id', 'nombre_contacto', 'lugar_encuesta', 'cargo', 'fecha_aplicacion', 'conoce_marca', 'autoriza_tratamiento', 'autorizacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedoresRnt()
    {
        return $this->belongsTo('App\ProveedoresRnt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteSocialPst()
    {
        return $this->hasOne('App\ComponenteSocialPst', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesCulturalesPsts()
    {
        return $this->hasMany('App\AccionesCulturalesPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function esquemasPsts()
    {
        return $this->hasMany('App\EsquemasPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEsquemasPsts()
    {
        return $this->hasMany('App\BeneficiosEsquemasPst', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteAmbientalPst()
    {
        return $this->hasOne('App\ComponenteAmbientalPst', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesAmbientalesPsts()
    {
        return $this->hasMany('App\ActividadesAmbientalesPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programasConservacionPsts()
    {
        return $this->hasMany('App\ProgramasConservacionPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planesMitigacionPsts()
    {
        return $this->hasMany('App\PlanesMitigacionPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informesGestionPst()
    {
        return $this->hasOne('App\InformesGestionPst', 'encuestas_pst_sosteniblidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesResiduosPsts()
    {
        return $this->hasMany('App\ActividadesResiduosPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesReducirEnergiaPsts()
    {
        return $this->hasMany('App\AccionesReducirEnergiaPst', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function energiasRenovablesPst()
    {
        return $this->hasOne('App\EnergiasRenovablesPst', 'encuestas_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteEconomicoPst()
    {
        return $this->hasOne('App\ComponenteEconomicoPst', 'encuestas_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clasificacionesProveedoresPsts()
    {
        return $this->hasMany('App\ClasificacionesProveedoresPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aspectosSeleccionPsts()
    {
        return $this->hasMany('App\AspectosSeleccionPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosPsts()
    {
        return $this->hasMany('App\BeneficiosEconomicosPst', 'encuestas_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosTemporadaPsts()
    {
        return $this->hasMany('App\BeneficiosEconomicosTemporadaPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function espaciosAlojamiento()
    {
        return $this->hasOne('App\EspaciosAlojamiento', 'encuestas_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsabilidadesSociale()
    {
        return $this->hasOne('App\ResponsabilidadesSociale', 'encuestas_pst_sostenibilidad_id');
    }
}
