<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Transporte[] $transportes
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Tipo_Transporte_Oferta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_transporte_oferta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'user_update', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transportes()
    {
        return $this->hasMany('App\Models\Transporte', 'tipos_transporte_oferta_id');
    }
}
