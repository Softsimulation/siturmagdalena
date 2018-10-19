<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property VisitantePaqueteTuristico[] $visitantePaqueteTuristicos
 * @property Visitante[] $visitantes
 * @property Visitante[] $visitantes
 * @property OpcionesLugaresConIdioma[] $opcionesLugaresConIdiomas
 * @property int $id
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $updated_at
 */
class Opcion_Lugar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_lugares';

    /**
     * @var array
     */
    protected $fillable = [ 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->belongsToMany('App\VisitantePaqueteTuristico', 'localizacion_agencia_viaje', 'opcion_lugar_id', 'visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Models\Visitante', 'opciones_lugares_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes2()
    {
        return $this->belongsToMany('App\Models\Visitante', 'visitante_alquila_vehiculo', 'opciones_lugares_id');
    }
    
    public function visitanteG(){
        return $this->belongsToMany('App\Models\Visitante', 'opciones_gasto_visitantes', 'opciones_lugare_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionesLugaresConIdiomas()
    {
        return $this->hasMany('App\Models\Opcion_Lugar_Con_Idioma', 'opciones_lugares_id');
    }
}
