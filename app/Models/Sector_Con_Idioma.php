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
        return $this->belongsTo('App\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sectore()
    {
        return $this->belongsTo('App\Sectore', 'sectores_id');
    }
}
