<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        
        '/temporada/guardartemporada',
        '/temporada/cambiarestado',
        '/turismointerno/barrios',
        '/turismointerno/hogar',
        '/turismointerno/datoshogar',
        '/turismointerno/eliminarpersona',
        '/turismointerno/guardareditarhogar',
        '/turismointerno/guardartransporte',
        '/turismointerno/datagastos',
        '/turismointerno/guardargastos',
        '/turismointerno/guardarfuentesinformacion',
        '/turismointerno/crearestancia',
        '/turismointerno/datoseditar',
        '/turismointerno/guardarhogar',
        '/turismointerno/createviaje',
        '/turismointerno/siguienteviaje'
    ];
}
