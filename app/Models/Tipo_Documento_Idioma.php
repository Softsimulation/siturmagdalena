<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoDocumento $tipoDocumento
 * @property int $tipo_documento_id
 * @property int $idioma_id
 * @property string $nombre
 */
class Tipo_Documento_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_documento_idioma';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDocumento()
    {
        return $this->belongsTo('App\Models\Tipo_Documento');
    }
}
