<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora[] $agenciasOperadoras
 * @property int $id
 * @property string $nombre
 */
class Tour extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agenciasOperadoras()
    {
        return $this->belongsToMany('App\AgenciasOperadora', 'tours_con_agencias_deportivas', 'tours_id', 'agencia_operadora_id');
    }
}
