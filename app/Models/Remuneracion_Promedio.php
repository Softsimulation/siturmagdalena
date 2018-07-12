<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $contrato_direto
 * @property int $personal_agencia
 * @property int $personal_permanente
 * @property int $aprendiz
 */
class Remuneracion_Promedio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'remuneracion_promedio';


    /**
     * @var array
     */
    protected $fillable = ['encuesta_id','valor'];

   
   protected $casts = [
       'valor' => 'float',

   ];
 public $timestamps = false;
     
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuesta_id');
    }
}