<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $fecha_realizacion
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property int $estado
 * @property string $usuario_realizado
 * @property string $ruta
 * @property string $hora_comienzo
 * @property string $hora_fin
 * @property string $periodo
 */
class Exportacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
     
    protected $table = 'exportaciones';
    public $timestamps=false;
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'fecha_realizacion', 'fecha_inicio', 'fecha_fin', 'estado', 'usuario_realizado', 'ruta', 'hora_comienzo', 'hora_fin', 'periodo'];

}
