<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property InformesGestionPst[] $informesGestionPsts
 * @property int $id
 * @property string $nombre
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $created_at
 * @property string $user_update
 */
class Periodo_Informe extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'periodos_informes';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'updated_at', 'estado', 'user_create', 'created_at', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function informesGestionPsts()
    {
        return $this->hasMany('App\InformesGestionPst');
    }
}
