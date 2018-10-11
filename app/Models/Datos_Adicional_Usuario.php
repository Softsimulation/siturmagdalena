<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Municipio $municipio
 * @property User $user
 * @property PostulacionesVacante[] $postulacionesVacantes
 * @property int $users_id
 * @property int $municipio_id
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property boolean $sexo
 * @property string $updated_at
 * @property string $user_update
 * @property string $user_create
 * @property boolean $estado
 * @property string $created_at
 */
class Datos_Adicional_Usuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'datos_usuario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'users_id';
    
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['users_id','profesion','municipio_id', 'nombres', 'apellidos', 'fecha_nacimiento', 'sexo', 'updated_at', 'user_update', 'user_create', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Models\Municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postulaciones()
    {
        return $this->hasMany('App\Models\Postulaciones_Vacante', 'datos_usuario_id');
    }
}
