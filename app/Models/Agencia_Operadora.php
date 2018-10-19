<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property OtraActividad[] $otraActividads
 * @property OtroTour[] $otroTours
 * @property PrestamosServicio[] $prestamosServicios
 * @property Tour[] $tours
 * @property ActividadesDeportiva[] $actividadesDeportivas
 * @property int $id
 * @property int $encuestas_id
 * @property int $numero_planes
 * @property string $otras_actividades
 */
class Agencia_Operadora extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'agencias_operadoras';
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'numero_planes', 'otras_actividades'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otraActividads()
    {
        return $this->hasMany('App\Models\Otra_Actividad', 'agencia_operadora_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otroTours()
    {
        return $this->hasMany('App\Models\Otro_Tour', 'agencias_operadoras_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prestamosServicios()
    {
        return $this->hasMany('App\Models\Prestamo_Servicio', 'agencia_operadora_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tours()
    {
        return $this->belongsToMany('App\Models\Tour', 'tours_con_agencias_deportivas', 'agencia_operadora_id', 'tours_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividadesDeportivas()
    {
        return $this->belongsToMany('App\Models\Actividad_Deportiva', 'agencias_operadoras_con_actividades_deportivas', 'agencias_operadoras_id', 'actividades_deportivas_id');
    }
}
