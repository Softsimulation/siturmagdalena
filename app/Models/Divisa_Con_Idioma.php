<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Divisa $divisa
 * @property Idioma $idioma
 * @property int $id
 * @property int $divisas_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Divisa_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'divisas_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['divisas_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisa()
    {
        return $this->belongsTo('App\Models\Divisa', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
