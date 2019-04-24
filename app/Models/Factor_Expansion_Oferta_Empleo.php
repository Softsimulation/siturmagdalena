<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factor_Expansion_Oferta_Empleo extends Model
{
    public $timestamps = false;
    protected $table = 'factor_expansion_oferta_empleo';

    public function d_municipioInterno()
    {
        return $this->belongsTo('App\Models\D_Municipios_Interno');
    }
    public function d_tamanioEmpresa()
    {
        return $this->belongsTo('App\Models\D_Tamanio_Empresa');
    }
    public function mesAnio()
    {
        return $this->belongsTo('App\Models\Mes_Anio');
    }
    public function tipoProveedor()
    {
        return $this->belongsTo('App\Models\Tipo_Proveedor');
    }
    
}