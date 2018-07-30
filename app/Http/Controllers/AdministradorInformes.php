<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use File;

use App\Models\Atracciones;
use App\Models\Idioma;
use App\Models\Tipo_Atraccion;
use App\Models\Destino;
use App\Models\Sector;
use App\Models\Perfil_Usuario;
use App\Models\Categoria_Turismo;
use App\Models\Actividades;
use App\Models\Sitio;
use App\Models\Sitio_Con_Idioma;
use App\Models\Atraccion_Con_Idioma;
use App\Models\Multimedia_Sitio;

class AdministradorAtraccionController extends Controller
{
    public function getListado(){
        return view('administradorInforme.Listado');
    }
    
    public function getListadoinformes(){
        
        $informes = Publicacion::with(["publicacionesIdiomas","categoriaDocumento","tipoDocumento"])->orderBy('fecha_publicacion')->get();
        $tipos = Tipo_Documento
        
        return ["informes"=>$informes;];
        
    }
    
    
    
}
