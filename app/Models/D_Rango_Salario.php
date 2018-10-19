<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HPromedioSalarialGrupo[] $hPromedioSalarialGrupos
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class D_Rango_Salario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_rangos_salario';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hPromedioSalarialGrupos()
    {
        return $this->hasMany('App\HPromedioSalarialGrupo', 'rango_salario_id');
    }
}
