<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property BeneficiosEconomicosPst[] $beneficiosEconomicosPsts
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property string $created_at
 * @property string $user_update
 * @property boolean $estado
 * @property string $updated_at
 */
class Beneficio_Economico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'beneficios_economicos';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'created_at', 'user_update', 'estado', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosPsts()
    {
        return $this->hasMany('App\BeneficiosEconomicosPst');
    }
}
