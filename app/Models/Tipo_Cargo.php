<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AsignacionesSalariale[] $asignacionesSalariales
 * @property Dominiosingle[] $dominiosingles
 * @property int $id
 * @property string $nombre
 */
class Tipo_Cargo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_cargos';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignacionesSalariales()
    {
        return $this->hasMany('App\Models\AsignacionesSalariale', 'tipos_cargos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dominiosingles()
    {
        return $this->hasMany('App\Models\Dominiosingle', 'tipos_cargos_id');
    }
}
