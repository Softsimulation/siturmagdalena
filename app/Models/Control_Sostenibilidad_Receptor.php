<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property boolean $activado
 * @property string $fecha_inicial
 * @property string $fecha_final
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Control_Sostenibilidad_Receptor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'control_sostenibilidad_receptor';

    /**
     * @var array
     */
    protected $fillable = ['activado', 'fecha_inicial', 'fecha_final', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

}
