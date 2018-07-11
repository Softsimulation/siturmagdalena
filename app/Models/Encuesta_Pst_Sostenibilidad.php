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
    protected $fillable = ['proveedores_rnt_id', 'nombre_contacto', 'lugar_encuesta', 'cargo', 'fecha_aplicacion', 'conoce_marca', 'autoriza_tratamiento', 'autorizacion','estado_encuesta_id','numero_seccion','digitador_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedoresRnt()
    {
        return $this->belongsTo('App\Models\Proveedores_rnt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteSocialPst()
    {
        return $this->hasOne('App\Models\Componente_Social_Pst', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesCulturalesPsts()
    {
        return $this->belongsToMany('App\Models\Accion_Cultural','acciones_culturales_pst','encuestas_pst_sostenibilidad_id','acciones_culturales_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function esquemasAccesibles()
    {
        return $this->belongsToMany('App\Models\Esquema_Accesible','esquemas_pst','encuestas_pst_sostenibilidad_id','esquemas_accesible_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEsquemas()
    {
        return $this->belongsToMany('App\Models\Beneficio_Esquema', 'beneficios_esquemas_pst','encuesta_pst_sostenibilidad_id','beneficios_esquema_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteAmbientalPst()
    {
        return $this->hasOne('App\Models\Componente_Ambiental_Pst', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesAmbientalesPsts()
    {
        return $this->belongsToMany('App\Models\Actividad_Medio_Ambiente','actividades_ambientales_pst','encuestas_pst_sostenibilidad_id','actividades_medio_ambiente_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programasConservacionPsts()
    {
        return $this->belongsToMany('App\Models\Programa_Conservacion','programas_conservacion_pst','encuestas_pst_sostenibilidad_id','programas_conservacion_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planesMitigacionPsts()
    {
        return $this->belongsToMany('App\Models\Plan_Mitigacion','planes_mitigacion_pst','encuestas_pst_sostenibilidad_id','planes_mitigacion_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informesGestionPst()
    {
        return $this->hasOne('App\Models\Informe_Gestion_Pst', 'encuestas_pst_sosteniblidad_id');
    }
    
    public function aguaReciclada()
    {
        return $this->hasOne('App\Models\Agua_Reciclada', 'encuesta_pst_sosteniblidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesResiduosPsts()
    {
        return $this->belongsToMany('App\Models\Actividad_Residuo','actividades_residuos_pst','encuestas_pst_sostenibilidad_id','actividades_residuo_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesReducirEnergiaPsts()
    {
        return $this->belongsToMany('App\Models\Accion_Reducir_Energia', 'acciones_reducir_energia_pst','id','acciones_reduccir_energia_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function energiasRenovablesPst()
    {
        return $this->belongsToMany('App\Models\Tipo_Energia_Renovable', 'energias_renovables_pst' ,'encuestas_pst_sostenibilidad_id', 'tipos_energias_renovable_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteEconomicoPst()
    {
        return $this->hasOne('App\Models\Componente_Economico_Pst', 'encuestas_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clasificacionesProveedoresPsts()
    {
        return $this->belongsToMany('App\Models\Clasificacion_Proveedor','clasificaciones_proveedores_pst','encuestas_pst_sostenibilidad_id','clasificaciones_proveedor_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aspectosSeleccionPsts()
    {
        return $this->belongsToMany('App\Models\Aspecto_Seleccion_Proveedor','aspectos_seleccion_pst','encuestas_pst_sostenibilidad_id','aspectos_seleccion_proveedor_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosPsts()
    {
        return $this->belongsToMany('App\Models\Beneficio_Economico', 'beneficios_economicos_pst' ,'encuestas_sostenibilidad_id','beneficios_economico_id')->withPivot('otro');
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
        return $this->hasOne('App\Models\Espacio_Alojamiento', 'encuestas_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsabilidadesSociale()
    {
        return $this->hasOne('App\Models\Responsabilidad_Social', 'encuestas_pst_sostenibilidad_id');
    }
}
