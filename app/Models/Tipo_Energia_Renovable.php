<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EnergiasRenovablesPst[] $energiasRenovablesPsts
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class Tipo_Energia_Renovable extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_energias_renovables';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function energiasRenovablesPsts()
    {
        return $this->hasMany('App\EnergiasRenovablesPst');
    }
}
