<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProgramasConservacionPst[] $programasConservacionPsts
 * @property int $id
 * @property string $nombre
 * @property string $updated_at
 * @property string $user_update
 * @property string $user_create
 * @property string $created_at
 * @property boolean $estado
 */
class Programa_Conservacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'programas_conservacion';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'updated_at', 'user_update', 'user_create', 'created_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programasConservacionPsts()
    {
        return $this->hasMany('App\ProgramasConservacionPst');
    }
}
