<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoProveedorPaquete $tipoProveedorPaquete
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_proveedor_paquete_id
 * @property string $nombre
 */
class Tipo_Proveedor_Paquete_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_proveedor_paquete_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_proveedor_paquete_id', 'nombre'];

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
    public function tipoProveedorPaquete()
    {
        return $this->belongsTo('App\Models\TipoProveedorPaquete');
    }
}
