<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Tipo_Transporte_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_transporte_interno';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

}
