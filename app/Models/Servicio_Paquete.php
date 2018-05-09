<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property VisitantePaqueteTuristico[] $visitantePaqueteTuristicos
 * @property ServiciosPaqueteConIdioma[] $serviciosPaqueteConIdiomas
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Servicio_Paquete extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_paquete';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->belongsToMany('App\VisitantePaqueteTuristico', 'servicios_incluidos_paquete', null, 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviciosPaqueteConIdiomas()
    {
        return $this->hasMany('App\ServiciosPaqueteConIdioma');
    }
}
