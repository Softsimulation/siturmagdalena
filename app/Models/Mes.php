<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MesesDeAño[] $mesesDeAños
 * @property int $id
 * @property string $nombre
 */
class Mes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'meses';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mesesDeAños()
    {
        return $this->hasMany('App\MesesDeAño', 'mes_id');
    }
}
