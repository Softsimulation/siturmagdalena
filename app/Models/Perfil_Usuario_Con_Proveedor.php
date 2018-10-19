<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PerfilesUsuario $perfilesUsuario
 * @property Proveedore $proveedore
 * @property int $id
 * @property int $perfiles_usuarios_id
 * @property int $proveedores_id
 */
class Perfil_Usuario_Con_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios_con_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['perfiles_usuarios_id', 'proveedores_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfilesUsuario()
    {
        return $this->belongsTo('App\PerfilesUsuario', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedores_id');
    }
}
