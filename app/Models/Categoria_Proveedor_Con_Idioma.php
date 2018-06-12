<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property CategoriaProveedore $categoriaProveedore
 * @property int $id
 * @property int $idiomas_id
 * @property int $categoria_proveedores_id
 * @property string $nombre
 */
class Categoria_Proveedor_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_proveedores_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'categoria_proveedores_id', 'nombre'];

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
    public function categoriaProveedore()
    {
        return $this->belongsTo('App\CategoriaProveedore', 'categoria_proveedores_id');
    }
}
