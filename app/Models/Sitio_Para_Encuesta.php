<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Sitio $sitio
 * @property EnvioCorreosOfertum[] $envioCorreosOfertas
 * @property Encuesta[] $encuestas
 * @property int $id
 * @property string $user_id
 * @property int $sitios_id
 * @property int $ano_fundacion
 * @property string $nombre_contacto
 * @property string $cargo_contacto
 * @property string $telefono_fijo
 * @property string $extension
 * @property string $celular
 * @property string $email
 * @property integer $camara_comercio
 * @property integer $registro_turismo
 * @property boolean $es_verificado
 */
class Sitio_Para_Encuesta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sitios_para_encuestas';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'sitios_id', 'ano_fundacion', 'nombre_contacto', 'cargo_contacto', 'telefono_fijo', 'extension', 'celular', 'email', 'camara_comercio', 'registro_turismo', 'es_verificado'];

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
    public function sitio()
    {
        return $this->belongsTo('App\Sitio', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function envioCorreosOfertas()
    {
        return $this->hasMany('App\EnvioCorreosOfertum');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encuestas()
    {
        return $this->hasMany('App\Encuesta', 'sitios_para_encuestas_id');
    }
}
