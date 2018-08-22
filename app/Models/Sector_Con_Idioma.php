<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Sectore $sectore
 * @property int $id
 * @property int $idiomas_id
 * @property int $sectores_id
 * @property string $nombre
 */
class Sector_Con_Idioma extends Model
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
    protected $table = 'sectores_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'sectores_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sectore()
    {
        return $this->belongsTo('App\Models\Sector', 'sectores_id');
    }
}
