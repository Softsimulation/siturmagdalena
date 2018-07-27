<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TiempoIndicador[] $tiempoIndicadors
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property int $dia_inicio
 * @property int $dia_final
 */
class Mes_Indicador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'mes_indicador';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'dia_inicio', 'dia_final'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiempoIndicadors()
    {
        return $this->hasMany('App\TiempoIndicador');
    }
}
