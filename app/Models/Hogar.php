<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property Edificacione $edificacione
 * @property Persona[] $personas
 * @property int $id
 * @property int $digitadores_id
 * @property int $edificaciones_id
 * @property string $fecha_realizacion
 * @property string $telefono
 */
class Hogar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hogares';
    public $timestamps=false;

    /**
     * @var array
     */
    protected $fillable = ['digitadores_id', 'edificaciones_id', 'fecha_realizacion', 'telefono'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Models\Digitador', 'digitadores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function edificacione()
    {
        return $this->belongsTo('App\Models\Edificacion', 'edificaciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Models\Persona', 'hogar_id');
    }
}
