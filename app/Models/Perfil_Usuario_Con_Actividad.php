<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property PerfilesUsuario $perfilesUsuario
 * @property int $id
 * @property int $actividades_id
 * @property int $perfiles_usuarios_id
 */
class Perfil_Usuario_Con_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios_con_actividades';

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'perfiles_usuarios_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividades()
    {
        return $this->belongsTo('App\Models\Actividades', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfilesUsuario()
    {
        return $this->belongsTo('App\Models\Perfil_Usuario', 'perfiles_usuarios_id');
    }
}
