<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Destino $destino
 * @property Idioma $idioma
 * @property int $id
 * @property int $destino_id
 * @property int $idiomas_id
 * @property string $nombre
 * @property string $descripcion
 * @property string informacion_practica
 * @property string reglas
 * @property string como_llegar
 */
class Destino_Con_Idioma extends Model
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
    protected $table = 'destino_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['destino_id', 'idiomas_id', 'nombre', 'descripcion', 'informacion_practica', 'reglas', 'como_llegar'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destino()
    {
        return $this->belongsTo('App\Models\Destino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
