<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Barrio $barrio
 * @property Estrato $estrato
 * @property Temporada $temporada
 * @property Hogare[] $hogares
 * @property int $id
 * @property int $barrio_id
 * @property int $estrato_id
 * @property int $temporada_id
 * @property string $direccion
 * @property string $nombre_entrevistado
 * @property string $telefono_entrevistado
 * @property string $email_entrevistado
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 */
class Edificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'edificaciones';

    /**
     * @var array
     */
    protected $fillable = ['barrio_id', 'estrato_id', 'temporada_id', 'direccion', 'nombre_entrevistado', 'telefono_entrevistado', 'email_entrevistado', 'user_update', 'updated_at', 'estado', 'created_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barrio()
    {
        return $this->belongsTo('App\Models\Barrio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estrato()
    {
        return $this->belongsTo('App\Models\Estrato');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function temporada()
    {
        return $this->belongsTo('App\Models\Temporada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hogares()
    {
        return $this->hasMany('App\Models\Hogar', 'edificaciones_id');
    }
}
