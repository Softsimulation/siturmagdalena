<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property Digitadore $digitadore
 * @property FrecuenciaViaje $frecuenciaViaje
 * @property MotivosViaje $motivosViaje
 * @property Persona $persona
 * @property TiposTransporte $tiposTransporte
 * @property ActividadesRealizadasInterno[] $actividadesRealizadasInternos
 * @property ActividadesRealizadasViajero[] $actividadesRealizadasViajeros
 * @property AlquilaVehiculoInterno $alquilaVehiculoInterno
 * @property AtraccionesVisitadasInterno[] $atraccionesVisitadasInternos
 * @property CiudadesVisitada[] $ciudadesVisitadas
 * @property EmpresaTerrestreInterno $empresaTerrestreInterno
 * @property FuentesInformacionAntesViaje[] $fuentesInformacionAntesViajes
 * @property FuentesInformacionDuranteViaje[] $fuentesInformacionDuranteViajes
 * @property HistorialEncuestaInterno[] $historialEncuestaInternos
 * @property LugaresVisitadosInterno[] $lugaresVisitadosInternos
 * @property OtrasFuentesInformacionAntesViajeInterno $otrasFuentesInformacionAntesViajeInterno
 * @property OtrasFuentesInformacionDuranteViajeInterno $otrasFuentesInformacionDuranteViajeInterno
 * @property OtrosFinanciadore $otrosFinanciadore
 * @property OtrosTuristasInterno $otrosTuristasInterno
 * @property RedesSociale[] $redesSociales
 * @property ViajeroRedesSociale $viajeroRedesSociale
 * @property ViajeExcursion $viajeExcursion
 * @property ViajesGastosInterno[] $viajesGastosInternos
 * @property AcompañantesViaje[] $acompañantesViajes
 * @property FinanciadoresViaje[] $financiadoresViajes
 * @property AcompañantesViajesHogar $acompañantesViajesHogar
 * @property CalificacionExperienciaInterno[] $calificacionExperienciaInternos
 * @property int $id
 * @property int $digitada_por
 * @property int $creada_por
 * @property int $frecuencia_id
 * @property int $motivo_viaje_id
 * @property int $personas_id
 * @property int $tipo_transporte_id
 * @property string $fecha_inicio
 * @property string $fecha_final
 * @property int $tamaño_grupo
 * @property boolean $invitacion_correo
 * @property int $ultima_sesion
 * @property boolean $es_principal
 */
class Viaje extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['digitada_por', 'creada_por', 'frecuencia_id', 'motivo_viaje_id', 'personas_id', 'tipo_transporte_id', 'fecha_inicio', 'fecha_final', 'tamaño_grupo', 'invitacion_correo', 'ultima_sesion', 'es_principal'];

    
    public $timestamps=false;
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Models\Digitadore', 'digitada_por');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creadore()
    {
        return $this->belongsTo('App\Models\Digitador', 'creada_por');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function frecuenciaViaje()
    {
        return $this->belongsTo('App\Models\FrecuenciaViaje', 'frecuencia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motivosViaje()
    {
        return $this->belongsTo('App\Models\Motivos_Viaje', 'motivo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'personas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposTransporte()
    {
        return $this->belongsTo('App\Models\TiposTransporte', 'tipo_transporte_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasInternos()
    {
        return $this->hasMany('App\Models\ActividadesRealizadasInterno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasViajeros()
    {
        return $this->hasMany('App\Models\ActividadesRealizadasViajero', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alquilaVehiculoInterno()
    {
        return $this->hasOne('App\Models\AlquilaVehiculoInterno', 'viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesVisitadasInternos()
    {
        return $this->hasMany('App\Models\Atraccion_Visitada_Interno', 'viajes_id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ciudadesVisitadas()
    {
        return $this->hasMany('App\Models\CiudadesVisitada', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empresaTerrestreInterno()
    {
        return $this->hasOne('App\Models\EmpresaTerrestreInterno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fuentesInformacionAntesViajes()
    {
        return $this->hasMany('App\Models\Fuente_Informacion_Antes_Viaje_Interno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fuentesInformacionDuranteViajes()
    {
        return $this->hasMany('App\Models\Fuente_Informacion_Durante_Viaje_Interno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestaInternos()
    {
        return $this->hasMany('App\Models\HistorialEncuestaInterno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lugaresVisitadosInternos()
    {
        return $this->hasMany('App\Models\LugaresVisitadosInterno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrasFuentesInformacionAntesViajeInterno()
    {
        return $this->hasOne('App\Models\Otra_Fuente_Informacion_Antes_Viaje_Interno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrasFuentesInformacionDuranteViajeInterno()
    {
        return $this->hasOne('App\Models\Otra_Fuente_Informacion_Durante_Viaje_Interno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosFinanciadore()
    {
        return $this->hasOne('App\Models\OtrosFinanciadore', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosTuristasInterno()
    {
        return $this->hasOne('App\Models\OtrosTuristasInterno', 'viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function redesSociales()
    {
        return $this->hasMany('App\Models\Redes_Sociales_Viajero','viajero_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viajeroRedesSociale()
    {
        return $this->hasMany('App\Models\Viajero_Redes_Sociales', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viajeExcursion()
    {
        return $this->hasOne('App\Models\Viaje_Excursion', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajesGastosInternos()
    {
        return $this->hasMany('App\Models\Viaje_Gasto_Interno', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acompanantesViajes()
    {
        return $this->belongsToMany('App\Models\Acompaniante_Viaje', 'viajes_acompañantes_viajes', 'viajes_id', 'acompañantes_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
public function financiadoresViajes()
    {
        return $this->belongsToMany('App\Models\Financiador_Viaje', 'viajes_financiadores', "viaje_id", 'financiadores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function acompañantesViajesHogar()
    {
        return $this->hasOne('App\AcompañantesViajesHogar', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calificacionExperienciaInternos()
    {
        return $this->hasMany('App\Models\Calificacion_Experiencia_Interno', 'viajes_id');
    }
}
