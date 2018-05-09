<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesDeportiva $actividadesDeportiva
 * @property AgenciasOperadora $agenciasOperadora
 * @property int $agencias_operadoras_id
 * @property int $actividades_deportivas_id
 */
class Agencia_Operadora_Con_Actividad_Deportiva extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'agencias_operadoras_con_actividades_deportivas';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadesDeportiva()
    {
        return $this->belongsTo('App\ActividadesDeportiva', 'actividades_deportivas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agenciasOperadora()
    {
        return $this->belongsTo('App\AgenciasOperadora', 'agencias_operadoras_id');
    }
}
