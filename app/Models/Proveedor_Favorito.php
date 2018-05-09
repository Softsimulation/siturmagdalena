<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Proveedore $proveedore
 * @property string $usuario_id
 * @property int $proveedores_id
 */
class Proveedor_Favorito extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proveedores_favoritos';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspNetUser()
    {
        return $this->belongsTo('App\AspNetUser', 'usuario_id', '"Id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedores_id');
    }
}
