<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProveedoresRnt $proveedoresRnt
 * @property Idioma $idioma
 * @property int $id
 * @property int $proveedor_rnt_id
 * @property int $idioma_id
 * @property string $nombre
 * @property string $descripcion
 */
class Proveedores_rnt_idioma extends Model
{
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['proveedor_rnt_id', 'idioma_id', 'nombre', 'descripcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedoresRnt()
    {
        return $this->belongsTo('App\Models\Proveedores_rnt', 'proveedor_rnt_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma');
    }
}
