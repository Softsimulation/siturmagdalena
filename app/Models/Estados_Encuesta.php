<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HistorialEncuestaInterno[] $historialEncuestaInternos
 * @property HistorialEncuestaOfertum[] $historialEncuestaOfertas
 * @property HistorialEncuestum[] $historialEncuestas
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 */
class Estados_Encuesta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'estados_encuesta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'updated_at', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestaInternos()
    {
        return $this->hasMany('App\HistorialEncuestaInterno', 'estado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestaOfertas()
    {
        return $this->hasMany('App\HistorialEncuestaOfertum', 'estado_encuesta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestas()
    {
        return $this->hasMany('App\Models\HistorialEncuesta', 'estado_id');
    }
}
