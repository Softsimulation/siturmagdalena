<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property OpcionesLugare $opcionesLugare
 * @property int $id
 * @property int $idiomas_id
 * @property int $opciones_lugares_id
 * @property string $nombre
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $updated_at
 */
class Opcion_Lugar_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_lugares_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'opciones_lugares_id', 'nombre','user_create', 'user_update', 'estado'];

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
    public function opcionesLugare()
    {
        return $this->belongsTo('App\Models\OpcionesLugare', 'opciones_lugares_id');
    }
}
