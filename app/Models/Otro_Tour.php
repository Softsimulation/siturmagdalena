<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora $agenciasOperadora
 * @property int $id
 * @property int $agencias_operadoras_id
 * @property string $nombre
 */
class Otro_Tour extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'otro_tour';
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['agencias_operadoras_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agenciasOperadora()
    {
        return $this->belongsTo('App\AgenciasOperadora', 'agencias_operadoras_id');
    }
}
