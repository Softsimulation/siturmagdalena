<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OfertasVacante[] $ofertasVacantes
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 */
class Tipo_Cargo_Vacante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_cargos_vacantes';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'user_create', 'user_update', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ofertasVacantes()
    {
        return $this->hasMany('App\Models\Oferta_Vacante', 'tipo_cargo_vacante_id');
    }
}
