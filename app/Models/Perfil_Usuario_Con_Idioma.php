<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property PerfilesUsuario $perfilesUsuario
 * @property int $id
 * @property int $idiomas_id
 * @property int $perfiles_usuarios_id
 * @property string $nombre
 */
class Perfil_Usuario_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'perfiles_usuarios_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfilesUsuario()
    {
        return $this->belongsTo('App\Models\PerfilesUsuario', 'perfiles_usuarios_id');
    }
}
