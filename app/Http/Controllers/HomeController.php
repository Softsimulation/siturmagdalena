<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Noticia;
use App\Models\Idioma;
use App\Models\Noticia_Idioma;
use App\Models\Multimedia_noticia;
use App\Models\Multimedia_noticia_Idioma;
use App\Models\Tipo_noticia;
use App\Models\Tipo_noticia_Idioma;
use App\Models\User;
use App;

class HomeController extends Controller
{


    /**
     * 
     * Los tipos de entidad son:
     * tipo: 1 -> Actividades
     * tipo: 2 -> Atracciones
     * tipo: 3 -> Destinos
     * tipo: 4 -> Eventos
     * tipo: 5 -> Rutas
     * 
     * La fecha inicial y final solo aplica para el tipo 4 (Eventos)
     * para el resto de tipos las fechas tienen por default 'NOW()'
     * */	
	public function getIndex(Request $request) {
	    
	    $noticias = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        ->where('noticias_has_idiomas.idiomas_id',1)->where('tipos_noticias_has_idiomas.idiomas_id',1)
        ->where('tipos_noticias.estado',1)
        ->select("noticias.id as idNoticia","noticias.enlace_fuente","noticias.es_interno","noticias.estado", "noticias.created_at as fecha",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen","noticias_has_idiomas.texto",
        "tipos_noticias.id as idTipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia")->
        orderBy('fecha','DESC')->take(4)->get();
        
        $idIdioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $query = DB::select("(SELECT actividades.id AS id,  
                 actividades.calificacion_legusto AS calificacion_legusto, 
                 1 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 actividades_con_idiomas.nombre AS nombre,
                 multimedias_actividades.ruta AS portada 
             FROM actividades INNER JOIN actividades_con_idiomas ON actividades_con_idiomas.actividades_id = actividades.id AND actividades_con_idiomas.idiomas = ?
                 INNER JOIN multimedias_actividades ON actividades.id = multimedias_actividades.actividades_id AND multimedias_actividades.portada = true 
             WHERE actividades.estado = true AND actividades.sugerido = true) UNION 
             (SELECT atracciones.id AS id,  
                 atracciones.calificacion_legusto AS calificacion_legusto, 
                 2 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 sitios_con_idiomas.nombre AS nombre,
                 multimedia_sitios.ruta AS portada 
             FROM atracciones INNER JOIN sitios ON sitios.id = atracciones.sitios_id 
                 INNER JOIN sitios_con_idiomas ON sitios.id = sitios_con_idiomas.sitios_id AND sitios_con_idiomas.idiomas_id = ?
                 INNER JOIN multimedia_sitios ON sitios.id = multimedia_sitios.sitios_id AND multimedia_sitios.portada = true 
             WHERE atracciones.estado = true AND atracciones.sugerido = true) UNION 
             (SELECT destino.id AS id,  
                 destino.calificacion_legusto AS calificacion_legusto, 
                 3 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 destino_con_idiomas.nombre AS nombre, 
                 multimedia_destino.ruta AS portada 
             FROM destino INNER JOIN destino_con_idiomas ON destino.id = destino_con_idiomas.destino_id AND destino_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_destino ON destino.id = multimedia_destino.destino_id AND multimedia_destino.portada = true 
             WHERE destino.estado = true AND destino.sugerido = true) UNION 
             (SELECT eventos.id AS id,  
                 null AS calificacion_legusto, 
                 4 AS tipo, 
                 eventos.fecha_in AS fecha_inicio, 
                 eventos.fecha_fin AS fecha_fin, 
                 eventos_con_idiomas.nombre AS nombre,
                 multimedia_evento.ruta AS portada 
             FROM eventos INNER JOIN eventos_con_idiomas ON eventos.id = eventos_con_idiomas.eventos_id AND eventos_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_evento ON eventos.id = multimedia_evento.eventos_id AND multimedia_evento.portada = true 
             WHERE eventos.estado = true AND eventos.sugerido = true) UNION 
             (SELECT rutas.id AS id,  
                 null AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true AND rutas.sugerido = true) ORDER BY tipo", [$idIdioma, $idIdioma, $idIdioma, $idIdioma, $idIdioma]);
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        return view('home.index',array('noticias' => $noticias,"tiposNoticias"=>$tiposNoticias, 'sugeridos' => $query));
	}
	
	public function getSliders() {
	    /*Slider_Idioma::where('id','>',1)->delete();
	    Slider::where('id','>',0)->delete();*/
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)->where('estado',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        
        return ["sliders"=>$sliderss];
	}
	
}