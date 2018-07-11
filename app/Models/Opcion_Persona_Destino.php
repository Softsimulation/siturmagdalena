<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PersonasDestinoConViajesTurismo[] $personasDestinoConViajesTurismos
 * @property int $id
 * @property string $nombre
 */
class Opcion_Persona_Destino extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_personas_destinos';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personasDestinoConViajesTurismos()
    {
        return $this->hasMany('App\PersonasDestinoConViajesTurismo');
    }
    
}
