<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TiposAtencionSalud $tiposAtencionSalud
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipos_atencion_salud_id
 * @property string $nombre
 */
class Tipo_Atencion_Salud_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_atencion_salud_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipos_atencion_salud_id', 'nombre'];

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
    public function tiposAtencionSalud()
    {
        return $this->belongsTo('App\TiposAtencionSalud');
    }
}
