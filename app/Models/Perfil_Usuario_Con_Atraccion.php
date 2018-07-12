<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property PerfilesUsuario $perfilesUsuario
 * @property int $id
 * @property int $atracciones_id
 * @property int $perfiles_usuarios_id
 */
class Perfil_Usuario_Con_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios_con_atracciones';

    /**
     * @var array
     */
    protected $fillable = ['atracciones_id', 'perfiles_usuarios_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Models\Atraccione', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfilesUsuario()
    {
        return $this->belongsTo('App\Models\Perfil_Usuario', 'perfiles_usuarios_id');
    }
}
