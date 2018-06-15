<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora[] $agenciasOperadoras
 * @property int $id
 * @property string $nombre
 */
class Actividad_Deportiva extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_deportivas';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agenciasOperadoras()
    {
        return $this->belongsToMany('App\AgenciasOperadora', 'agencias_operadoras_con_actividades_deportivas', 'actividades_deportivas_id', 'agencias_operadoras_id');
    }
}
