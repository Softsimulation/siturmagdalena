<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Encuesta $encuesta
 * @property EstadosEncuestum $estadosEncuestum
 * @property int $id
 * @property string $user_id
 * @property int $encuesta_id
 * @property int $estado_encuesta_id
 * @property string $fecha_cambio
 */
class Historial_Encuesta_Oferta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_encuesta_oferta';
     public $timestamps = false;
     

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'encuesta_id', 'estado_encuesta_id', 'fecha_cambio'];


    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function estadosEncuesta()
    {
        return $this->belongsTo('App\Models\Estados_Encuesta', 'estado_encuesta_id');
    }

}
