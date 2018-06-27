<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AgenciasOperadora $agenciasOperadora
 * @property int $id
 * @property int $agencia_operadora_id
 * @property string $nombre
 */
class Otra_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'otra_actividad';
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['agencia_operadora_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agenciasOperadora()
    {
        return $this->belongsTo('App\AgenciasOperadora', 'agencia_operadora_id');
    }
}
