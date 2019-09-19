<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Actividade $actividade
 * @property int $id
 * @property string $user_id
 * @property int $actividad_id
 * @property string $fecha
 * @property string $titulo
 * @property string $comentario
 * @property float $le_gusto
 * @property float $llegar
 * @property float $recomendar
 * @property float $volveria
 */
class Comentario_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comentarios_actividad';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'actividad_id', 'fecha', 'titulo', 'comentario', 'le_gusto', 'llegar', 'recomendar', 'volveria'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspNetUser()
    {
        return $this->belongsTo('App\AspNetUser', 'user_id', '"Id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'actividad_id');
    }
}
