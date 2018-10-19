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
class Empleado_Vinculacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empleados_vinculacion';

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'contrato_direto', 'personal_agencia', 'personal_permanente', 'aprendiz'];
 public $timestamps = false;
     
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }
}
