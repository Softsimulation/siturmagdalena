<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Año $año
 * @property CategoriaProveedore $categoriaProveedore
 * @property DTamañoEmpresa $dTamañoEmpresa
 * @property Destino $destino
 * @property int $id
 * @property int $tipos_proveedor_id
 * @property int $destino_id
 * @property int $años_id
 * @property int $tamaño_empresa_id
 * @property float $valor
 * @property boolean $es_calculado
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Dato_Rnt extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dato_rnt';

    /**
     * @var array
     */
    protected $fillable = ['tipos_proveedor_id', 'destino_id', 'años_id', 'tamaño_empresa_id', 'valor', 'es_calculado', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function año()
    {
        return $this->belongsTo('App\Año', '"años_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaProveedore()
    {
        return $this->belongsTo('App\CategoriaProveedore', 'tipos_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTamañoEmpresa()
    {
        return $this->belongsTo('App\DTamañoEmpresa', '"tamaño_empresa_id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destino()
    {
        return $this->belongsTo('App\Destino');
    }
}
