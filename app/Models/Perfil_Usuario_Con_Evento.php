<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento $evento
 * @property PerfilesUsuario $perfilesUsuario
 * @property int $id
 * @property int $eventos_id
 * @property int $perfiles_usuarios_id
 */
class Perfil_Usuario_Con_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios_con_eventos';

    /**
     * @var array
     */
    protected $fillable = ['eventos_id', 'perfiles_usuarios_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfilesUsuario()
    {
        return $this->belongsTo('App\Models\Perfil_Usuario', 'perfiles_usuarios_id');
    }
}
