<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FinanciadoresViaje $financiadoresViaje
 * @property Idioma $idioma
 * @property int $id
 * @property int $financiadores_viaje_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Financiador_Viaje_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'financiadores_viajes_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['financiadores_viaje_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financiadoresViaje()
    {
        return $this->belongsTo('App\Models\FinanciadoresViaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
