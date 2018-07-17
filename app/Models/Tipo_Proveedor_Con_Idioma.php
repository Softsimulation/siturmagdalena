<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoProveedore $tipoProveedore
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_proveedores_id
 * @property string $nombre
 */
class Tipo_Proveedor_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_proveedores_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_proveedores_id', 'nombre'];

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
    public function tipoProveedore()
    {
        return $this->belongsTo('App\TipoProveedore', 'tipo_proveedores_id');
    }
}
