<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Barrio $barrio
 * @property Estrato $estrato
 * @property FactoresPostivosHogare[] $factoresPostivosHogares
 * @property AccionesCulturaresCasa[] $accionesCulturaresCasas
 * @property RiesgosTurismo[] $riesgosTurismos
 * @property FactoresCalidadTurismo[] $factoresCalidadTurismos
 * @property BeneficiosSocioculturale[] $beneficiosSocioculturales
 * @property ActividadesAmbientalesCasa[] $actividadesAmbientalesCasas
 * @property AccionesAmbientalesCasa[] $accionesAmbientalesCasas
 * @property ComponenteTecnico $componenteTecnico
 * @property SectoresTurismosSostenibilidad[] $sectoresTurismosSostenibilidads
 * @property SectoresEconomiaSostenibilidad[] $sectoresEconomiaSostenibilidads
 * @property ComponentesSociale $componentesSociale
 * @property ComponentesAmbientale[] $componentesAmbientales
 * @property ComponentesAmbientale $componentesAmbientale
 * @property int $id
 * @property int $barrio_id
 * @property int $estrato_id
 * @property string $fecha_aplicacion
 * @property string $nombre_encuestado
 * @property string $direccion
 * @property boolean $sexo
 * @property string $celular
 * @property string $email
 * @property boolean $conoce_marca
 * @property boolean $autoriza_tratamiento
 * @property boolean $autorizacion
 */
class Casa_Sostenibilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'casas_sostenibilidad';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['barrio_id', 'estrato_id', 'fecha_aplicacion', 'nombre_encuestado', 'direccion', 'sexo', 'celular', 'email', 'conoce_marca', 'autoriza_tratamiento', 'autorizacion','numero_sesion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barrio()
    {
        return $this->belongsTo('App\Barrio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estrato()
    {
        return $this->belongsTo('App\Estrato');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factoresPostivosHogares()
    {
        return $this->hasMany('App\FactoresPostivosHogare');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesCulturales()
    {
        return $this->belongsToMany('App\Models\Accion_Cultural','acciones_culturares_casas','casas_sostenibilidad_id','acciones_culturales_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riesgosTurismos()
    {
        return $this->hasMany('App\RiesgosTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factoresCalidadTurismos()
    {
        return $this->hasMany('App\FactoresCalidadTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosSocioculturales()
    {
        return $this->hasMany('App\BeneficiosSocioculturale');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesAmbientales()
    {
        return $this->belongsToMany('App\Models\Actividad_Medio_Ambiente','actividades_ambientales_casas','casas_sostenibilidad_id','actividades_medio_ambiente_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesAmbientales()
    {
        return $this->belongsToMany('App\Models\Accion_Ambiental','acciones_ambientales_casas','casas_sostenibilidad_id','acciones_ambiental_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componenteTecnico()
    {
        return $this->hasOne('App\Models\Componente_Tecnico', 'casas_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresTurismosSostenibilidads()
    {
        return $this->belongsToMany('App\Models\Sectores_Turismo','sectores_turismos_sostenibilidad','casas_sostenibilidad_id','sectores_turismos_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectoresEconomiaSostenibilidads()
    {
        return $this->belongsToMany('App\Models\Sectores_Economia','sectores_economia_sostenibilidad', 'casas_sostenibilidad_id' ,'sectores_economia_id')->withPivot('otro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componentesSociale()
    {
        return $this->hasOne('App\ComponentesSociale', 'casas_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function componentesAmbientales()
    {
        return $this->hasMany('App\ComponentesAmbientale', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function componentesAmbientale()
    {
        return $this->hasOne('App\ComponentesAmbientale', 'casas_sostenibilidad_id');
    }
}
