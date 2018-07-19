<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mes_Anio extends Model
{
    protected $table = 'meses_de_anio';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['anio_id', 'mes_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mes()
    {
        return $this->belongsTo('App\Models\Mes', 'mes_id');
    }
    public function anio()
    {
        return $this->belongsTo('App\Models\Anio', 'anio_id');
    }
}
