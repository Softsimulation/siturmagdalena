<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProvisionesAlimento[] $provisionesAlimentos
 * @property int $id
 * @property string $nombre
 */
class Especialidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'especialidades';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provisionesAlimentos()
    {
        return $this->hasMany('App\ProvisionesAlimento', 'especialidades_id');
    }
}
