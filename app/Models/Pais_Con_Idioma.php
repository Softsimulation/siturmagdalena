<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Paise $paise
 * @property int $id
 * @property int $idioma_id
 * @property int $pais_id
 * @property string $nombre
 */
class Pais_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'paises_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idioma_id', 'pais_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paise()
    {
        return $this->belongsTo('App\Models\Paise', 'pais_id');
    }
}
