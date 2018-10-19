<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Sitio $sitio
 * @property int $id
 * @property int $idiomas_id
 * @property int $sitios_id
 * @property string $nombre
 * @property string $descripcion
 */
class Sitio_Con_Idioma extends Model
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
    protected $table = 'sitios_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'sitios_id', 'nombre', 'descripcion'];

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
    public function sitio()
    {
        return $this->belongsTo('App\Models\Sitio', 'sitios_id');
    }
}
