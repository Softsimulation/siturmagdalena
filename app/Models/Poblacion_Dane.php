<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Año $año
 * @property int $id
 * @property int $valor
 * @property int $años_id
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 */
class Poblacion_Dane extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'poblacion_dane';

    /**
     * @var array
     */
    protected $fillable = ['valor', 'años_id', 'created_at', 'user_create', 'user_update', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function año()
    {
        return $this->belongsTo('App\Año', '"años_id"');
    }
}
