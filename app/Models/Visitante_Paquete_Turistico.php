<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Divisa $divisa
 * @property TipoProveedorPaquete $tipoProveedorPaquete
 * @property Visitante $visitante
 * @property OpcionesLugare[] $opcionesLugares
 * @property Municipio[] $municipios
 * @property ServiciosPaquete[] $serviciosPaquetes
 * @property int $visitante_id
 * @property int $divisas_id
 * @property int $tipo_proveedor_paquete_id
 * @property float $costo_paquete
 * @property int $personas_cubrio
 */
class Visitante_Paquete_Turistico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitante_paquete_turistico';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'visitante_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
       'costo_paquete' => 'float',
   ];
    /**
     * @var array
     */
    protected $fillable = ['divisas_id', 'tipo_proveedor_paquete_id', 'costo_paquete', 'personas_cubrio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisa()
    {
        return $this->belongsTo('App\Models\Divisa', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoProveedorPaquete()
    {
        return $this->belongsTo('App\Models\TipoProveedorPaquete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opcionesLugares()
    {
        return $this->belongsToMany('App\Models\Opcion_Lugar', 'localizacion_agencia_viaje', 'visitante_id', 'opcion_lugar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function municipios()
    {
        return $this->belongsToMany('App\Models\Municipio', 'municipios_paquete_turistico', 'visitante_id', 'municipios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviciosPaquetes()
    {
        return $this->belongsToMany('App\Models\Servicio_Paquete', 'servicios_incluidos_paquete', 'visitante_id','servicios_paquete_id');
    }
}
