<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Actividade $actividade
 * @property string $usuario_id
 * @property int $actividades_id
 */
class Actividad_Favorita extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_favoritas';

    /**
     * @var array
     */
    protected $fillable = ['usuario_id','actividades_id'];

    public $timestamps = false;
    public $incrementing = false;

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
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'actividades_id');
    }
}
