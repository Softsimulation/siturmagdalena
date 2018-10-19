<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Departamento $departamento
 * @property Barrio[] $barrios
 * @property CiudadesVisitada[] $ciudadesVisitadas
 * @property MunicipiosVisitadosMagdalena[] $municipiosVisitadosMagdalenas
 * @property VisitantePaqueteTuristico[] $visitantePaqueteTuristicos
 * @property Visitante[] $visitantes
 * @property Visitante[] $visitantes
 * @property int $id
 * @property int $departamento_id
 * @property string $nombre
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Municipio extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['departamento_id', 'nombre', 'updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barrios()
    {
        return $this->hasMany('App\Barrio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ciudadesVisitadas()
    {
        return $this->hasMany('App\CiudadesVisitada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipiosVisitadosMagdalenas()
    {
        return $this->hasMany('App\MunicipiosVisitadosMagdalena', 'municipios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->belongsToMany('App\VisitantePaqueteTuristico', 'municipios_paquete_turistico', 'municipios_id', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'municipio_residencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantesdestino()
    {
        return $this->hasMany('App\Visitante', 'destino_principal');
    }
}
