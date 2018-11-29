<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Evento $evento
 * @property string $usuario_id
 * @property int $eventos_id
 */
class Evento_Favorita extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'eventos_favoritas';

    /**
     * @var array
     */
    protected $fillable = ['usuario_id','eventos_id'];
    
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
    public function evento()
    {
        return $this->belongsTo('App\Evento', 'eventos_id');
    }
}
