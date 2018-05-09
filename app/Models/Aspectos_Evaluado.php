<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspectosEvaluadosConIdioma[] $aspectosEvaluadosConIdiomas
 * @property ItemsEvaluar[] $itemsEvaluars
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Aspectos_Evaluado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aspectos_evaluados';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aspectosEvaluadosConIdiomas()
    {
        return $this->hasMany('App\AspectosEvaluadosConIdioma', 'aspectos_evaluados_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemsEvaluars()
    {
        return $this->hasMany('App\ItemsEvaluar', 'aspectos_evaluar_id');
    }
}
