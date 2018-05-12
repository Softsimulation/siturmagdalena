<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property Digitadore $digitadore
 * @property GruposViaje $gruposViaje
 * @property MotivosViaje $motivosViaje
 * @property Municipio $municipio
 * @property Municipio $municipio
 * @property OpcionesLugare $opcionesLugare
 * @property Paise $paise
 * @property TiposTransporte $tiposTransporte
 * @property TiposTransporte $tiposTransporte
 * @property ActividadesHechasVisitante[] $actividadesHechasVisitantes
 * @property ActividadesRealizadasPorVisitante[] $actividadesRealizadasPorVisitantes
 * @property Atraccione[] $atracciones
 * @property AtraccionesVisitada[] $atraccionesVisitadas
 * @property Calificacion[] $calificacions
 * @property ElementosRepresentativo[] $elementosRepresentativos
 * @property EnviosCorreo[] $enviosCorreos
 * @property GastosVisitante[] $gastosVisitantes
 * @property TiposAcompañantesVisitante[] $tiposAcompañantesVisitantes
 * @property HistorialEncuestum[] $historialEncuestas
 * @property FuentesInformacionAntesViaje[] $fuentesInformacionAntesViajes
 * @property FuentesInformacionDuranteViaje[] $fuentesInformacionDuranteViajes
 * @property LugaresVisitado[] $lugaresVisitados
 * @property MunicipiosVisitadosMagdalena[] $municipiosVisitadosMagdalenas
 * @property OtrasFuenteInformacionAntesViaje $otrasFuenteInformacionAntesViaje
 * @property OtrasFuenteInformacionDuranteViaje $otrasFuenteInformacionDuranteViaje
 * @property OtrosAcompañantesViaje $otrosAcompañantesViaje
 * @property OtrosElementosRepresentativo $otrosElementosRepresentativo
 * @property OtrosFinanciadoresViaje $otrosFinanciadoresViaje
 * @property OtrosMotivo $otrosMotivo
 * @property OtrosTurista $otrosTurista
 * @property RedesSociale[] $redesSociales
 * @property ValoracionGeneral $valoracionGeneral
 * @property VisitanteTransporteTerrestre $visitanteTransporteTerrestre
 * @property VisitanteCompartirRede $visitanteCompartirRede
 * @property OpcionesLugare[] $opcionesLugares
 * @property VisitantePaqueteTuristico $visitantePaqueteTuristico
 * @property FinanciadoresViaje[] $financiadoresViajes
 * @property VisitantesTransito $visitantesTransito
 * @property TiposAtencionSalud[] $tiposAtencionSaluds
 * @property int $id
 * @property int $encuestador_creada
 * @property int $digitada
 * @property int $grupo_viaje_id
 * @property int $motivo_viaje
 * @property int $municipio_residencia
 * @property int $destino_principal
 * @property int $opciones_lugares_id
 * @property int $pais_nacimiento
 * @property int $transporte_interno
 * @property int $transporte_llegada
 * @property string $nombre
 * @property int $edad
 * @property boolean $sexo
 * @property string $email
 * @property string $telefono
 * @property string $celular
 * @property string $fecha_llegada
 * @property string $fecha_salida
 * @property int $ultima_sesion
 * @property int $tamaño_grupo_visitante
 * @property boolean $invitacion_correo
 * @property string $token
 * @property boolean $es_ingles
 * @property boolean $es_verificado
 * @property boolean $facilidad
 */
class Visitante extends Model
{
    
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['encuestador_creada', 'digitada', 'grupo_viaje_id', 'motivo_viaje', 'municipio_residencia', 'destino_principal', 'opciones_lugares_id', 'pais_nacimiento', 'transporte_interno', 'transporte_llegada', 'nombre', 'edad', 'sexo', 'email', 'telefono', 'celular', 'fecha_llegada', 'fecha_salida', 'ultima_sesion', 'tamaño_grupo_visitante', 'invitacion_correo', 'token', 'es_ingles', 'es_verificado', 'facilidad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Models\Digitadore', 'encuestador_creada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadoreDigitada()
    {
        return $this->belongsTo('App\Models\Digitadore', 'digitada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gruposViaje()
    {
        return $this->belongsTo('App\GruposViaje', 'grupo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motivosViaje()
    {
        return $this->belongsTo('App\MotivosViaje', 'motivo_viaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipioResidencia()
    {
        return $this->belongsTo('App\Municipio', 'municipio_residencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipioPrincipal()
    {
        return $this->belongsTo('App\Municipio', 'destino_principal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesLugare()
    {
        return $this->belongsTo('App\OpcionesLugare', 'opciones_lugares_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paise()
    {
        return $this->belongsTo('App\Paise', 'pais_nacimiento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposTransporteInterno()
    {
        return $this->belongsTo('App\TiposTransporte', 'transporte_interno');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposTransporteLlegada()
    {
        return $this->belongsTo('App\TiposTransporte', 'transporte_llegada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesHechasVisitantes()
    {
        return $this->hasMany('App\ActividadesHechasVisitante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasPorVisitantes()
    {
        return $this->hasMany('App\ActividadesRealizadasPorVisitante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function atracciones()
    {
        return $this->belongsToMany('App\Models\Atracciones', 'atracciones_favoritas_visitante', 'visitante_id', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesVisitadas()
    {
        return $this->hasMany('App\AtraccionesVisitada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calificacions()
    {
        return $this->hasMany('App\Calificacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function elementosRepresentativos()
    {
        return $this->belongsToMany('App\ElementosRepresentativo', 'elementos_representativos_favoritos', null, 'elementos_representativos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enviosCorreos()
    {
        return $this->hasMany('App\EnviosCorreo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastosVisitantes()
    {
        return $this->hasMany('App\Models\Gasto_Visitante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tiposAcompañantesVisitantes()
    {
        return $this->belongsToMany('App\TiposAcompañantesVisitante', 'grupo_viaje_acompañantes', null, 'tipo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestas()
    {
        return $this->hasMany('App\Models\Historial_Encuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fuentesInformacionAntesViajes()
    {
        return $this->belongsToMany('App\FuentesInformacionAntesViaje', 'informacion_visitante_antes_viaje', null, 'fuentes_informacion_antes_viaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fuentesInformacionDuranteViajes()
    {
        return $this->belongsToMany('App\FuentesInformacionDuranteViaje', 'informacion_visitante_durante_viaje', null, 'fuente_informacion_durante_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lugaresVisitados()
    {
        return $this->hasMany('App\LugaresVisitado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipiosVisitadosMagdalenas()
    {
        return $this->hasMany('App\MunicipiosVisitadosMagdalena');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrasFuenteInformacionAntesViaje()
    {
        return $this->hasOne('App\OtrasFuenteInformacionAntesViaje', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrasFuenteInformacionDuranteViaje()
    {
        return $this->hasOne('App\OtrasFuenteInformacionDuranteViaje', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosAcompañantesViaje()
    {
        return $this->hasOne('App\OtrosAcompañantesViaje', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosElementosRepresentativo()
    {
        return $this->hasOne('App\OtrosElementosRepresentativo', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosFinanciadoresViaje()
    {
        return $this->hasOne('App\OtrosFinanciadoresViaje', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosMotivo()
    {
        return $this->hasOne('App\Models\Otro_Motivo', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otrosTurista()
    {
        return $this->hasOne('App\OtrosTurista', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function redesSociales()
    {
        return $this->belongsToMany('App\RedesSociale', 'redes_sociales_visitante', null, 'redes_sociales_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function valoracionGeneral()
    {
        return $this->hasOne('App\ValoracionGeneral', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visitanteTransporteTerrestre()
    {
        return $this->hasOne('App\VisitanteTransporteTerrestre', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visitanteCompartirRede()
    {
        return $this->hasOne('App\VisitanteCompartirRede', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opcionesLugares()
    {
        return $this->belongsToMany('App\OpcionesLugare', 'visitante_alquila_vehiculo', null, 'opciones_lugares_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visitantePaqueteTuristico()
    {
        return $this->hasOne('App\VisitantePaqueteTuristico', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function financiadoresViajes()
    {
        return $this->belongsToMany('App\Models\Financiador_Viaje', 'visitante_gastos_pagados', null, 'financiadores_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visitantesTransito()
    {
        return $this->hasOne('App\Models\Visitante_Transito', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tiposAtencionSaluds()
    {
        return $this->belongsToMany('App\Models\Tipo_Atencion_Salud', 'visitantes_salud', 'visitante_id', 'tipo_atencion_salud');
    }
}
