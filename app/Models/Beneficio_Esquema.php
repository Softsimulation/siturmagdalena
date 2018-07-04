<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property BeneficiosEsquemasPst[] $beneficiosEsquemasPsts
 * @property int $id
 * @property string $nombre
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_update
 * @property string $user_create
 */
class Beneficio_Esquema extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'beneficios_esquemas';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'updated_at', 'estado', 'created_at', 'user_update', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEsquemasPsts()
    {
        return $this->hasMany('App\BeneficiosEsquemasPst');
    }
}
