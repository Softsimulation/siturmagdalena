<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Indicadore[] $indicadores
 * @property int $id
 * @property string $nombre
 */
class Estado_Indicador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'estado_indicador';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indicadores()
    {
        return $this->hasMany('App\Indicadore');
    }
}
