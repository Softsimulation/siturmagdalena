<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PlanesMitigacionPst[] $planesMitigacionPsts
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $created_at
 */
class Plan_Mitigacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planes_mitigacion';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'updated_at', 'estado', 'user_create', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planesMitigacionPsts()
    {
        return $this->hasMany('App\PlanesMitigacionPst');
    }
}
