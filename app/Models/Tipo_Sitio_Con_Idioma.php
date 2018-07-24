<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoSitio $tipoSitio
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_sitios_id
 * @property string $nombe
 * @property string $descripcion
 */
class Tipo_Sitio_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_sitios_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_sitios_id', 'nombe', 'descripcion'];

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
    public function tipoSitio()
    {
        return $this->belongsTo('App\Models\Tipo_Sitio', 'tipo_sitios_id');
    }
}
