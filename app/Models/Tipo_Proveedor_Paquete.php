<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoProveedorPaqueteConIdioma[] $tipoProveedorPaqueteConIdiomas
 * @property VisitantePaqueteTuristico[] $visitantePaqueteTuristicos
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Tipo_Proveedor_Paquete extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_proveedor_paquete';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoProveedorPaqueteConIdiomas()
    {
        return $this->hasMany('App\TipoProveedorPaqueteConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->hasMany('App\VisitantePaqueteTuristico');
    }
}
