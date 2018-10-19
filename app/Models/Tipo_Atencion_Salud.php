<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TiposAtencionSaludConIdioma[] $tiposAtencionSaludConIdiomas
 * @property Visitante[] $visitantes
 * @property int $id
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Atencion_Salud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_atencion_salud';

    /**
     * @var array
     */
    protected $fillable = ['updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposAtencionSaludConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Atencion_Salud_Con_Idioma','tipos_atencion_salud_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'visitantes_salud', 'tipo_atencion_salud');
    }
}
