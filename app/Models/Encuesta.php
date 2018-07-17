<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MesesDeAño $mesesDeAño
 * @property SitiosParaEncuesta $sitiosParaEncuesta
 * @property AlquilerVehiculo[] $alquilerVehiculos
 * @property AsignacionesSalariale[] $asignacionesSalariales
 * @property AgenciasOperadora[] $agenciasOperadoras
 * @property Alojamiento[] $alojamientos
 * @property CapacitacionEmpleado[] $capacitacionEmpleados
 * @property Empleo[] $empleos
 * @property EmpleadosVinculacion[] $empleadosVinculacions
 * @property EducacionEmpleado[] $educacionEmpleados
 * @property HistorialEncuestaOfertum[] $historialEncuestaOfertas
 * @property ProvisionesAlimento[] $provisionesAlimentos
 * @property SexosEmpleado[] $sexosEmpleados
 * @property Vacante[] $vacantes
 * @property Transporte[] $transportes
 * @property ViajesTurismo[] $viajesTurismos
 * @property Dominiosingle[] $dominiosingles
 * @property EdadEmpleado[] $edadEmpleados
 * @property int $id
 * @property int $sitios_para_encuestas_id
 * @property int $meses_años_id
 * @property integer $actividad_comercial
 * @property int $numero_dias
 */
class Encuesta extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sitios_para_encuestas_id', 'meses_años_id', 'actividad_comercial', 'numero_dias'];
    public $timestamps = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mesesDeAnio()
    {
        return $this->belongsTo('App\Models\Mes_Anio', '"meses_años_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitiosParaEncuesta()
    {
        return $this->belongsTo('App\Models\Sitio_Para_Encuesta', 'sitios_para_encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alquilerVehiculos()
    {
        return $this->hasMany('App\Models\Alquiler_Vehiculo', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignacionesSalariales()
    {
        return $this->hasMany('App\AsignacionesSalariale', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agenciasOperadoras()
    {
        return $this->hasMany('App\Models\Agencia_Operadora', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alojamientos()
    {
        return $this->hasMany('App\Alojamiento', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function capacitacionEmpleados()
    {
        return $this->hasMany('App\CapacitacionEmpleado', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleos()
    {
        return $this->hasMany('App\Empleo', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleadosVinculacions()
    {
        return $this->hasMany('App\EmpleadosVinculacion', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educacionEmpleados()
    {
        return $this->hasMany('App\EducacionEmpleado', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestaOfertas()
    {
        return $this->hasMany('App\HistorialEncuestaOfertum');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provisionesAlimentos()
    {
        return $this->hasMany('App\Models\Provision_Alimento', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sexosEmpleados()
    {
        return $this->hasMany('App\SexosEmpleado', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vacantes()
    {
        return $this->hasMany('App\Vacante', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transportes()
    {
        return $this->hasMany('App\Transporte', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajesTurismos()
    {
        return $this->hasMany('App\Models\Viaje_Turismo', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dominiosingles()
    {
        return $this->hasMany('App\Dominiosingle', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edadEmpleados()
    {
        return $this->hasMany('App\EdadEmpleado', 'encuestas_id');
    }
}
