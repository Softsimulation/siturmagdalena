<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaTurismo $categoriaTurismo
 * @property Proveedore $proveedore
 * @property int $id
 * @property int $categoria_turismo_id
 * @property int $proveedores_id
 */
class Categoria_Turismo_Con_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo_con_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['categoria_turismo_id', 'proveedores_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaTurismo()
    {
        return $this->belongsTo('App\CategoriaTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedores_id');
    }
}
