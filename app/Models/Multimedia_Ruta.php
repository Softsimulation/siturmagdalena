<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Ruta $ruta
 * @property int $id
 * @property int $ruta_id
 * @property string $ruta
 */
class Multimedia_Ruta extends Model
{
    /**
     * The timestamps.
     * 
     * @var bool
     */   
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedia_rutas';

    /**
     * @var array
     */
    protected $fillable = ['ruta_id', 'ruta'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruta()
    {
        return $this->belongsTo('App\Models\Ruta');
    }
}
