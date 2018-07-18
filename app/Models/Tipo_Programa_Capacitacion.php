<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProgramasCapaciacione[] $programasCapaciaciones
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class Tipo_Programa_Capacitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_programas_capacitaciones';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programasCapaciaciones()
    {
        return $this->hasMany('App\Models\ProgramasCapaciacione', 'tipo_programa_capacitacion_id');
    }
}
