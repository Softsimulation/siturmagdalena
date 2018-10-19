<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ValoracionGeneral[] $valoracionGenerals
 * @property ValoracionGeneral[] $valoracionGenerals
 * @property VolveriaVisitarConIdioma[] $volveriaVisitarConIdiomas
 * @property int $id
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 */
class Volveria_Visitar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'volveria_visitar';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'updated_at', 'estado', 'created_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function valoracionGeneralsRecomendaria()
    {
        return $this->hasMany('App\ValoracionGeneral', 'recomendaria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function valoracionGeneralsVolveria()
    {
        return $this->hasMany('App\ValoracionGeneral', 'volveria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function volveriaVisitarConIdiomas()
    {
        return $this->hasMany('App\Models\Volveria_Visitar_Con_Idioma','volveria_visitar_id');
    }
}
