<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaTurismo $categoriaTurismo
 * @property Idioma $idioma
 * @property int $id
 * @property int $categoria_turismo_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Categoria_Turismo_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['categoria_turismo_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaTurismo()
    {
        return $this->belongsTo('App\CategoriaTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'idiomas_id');
    }
}
