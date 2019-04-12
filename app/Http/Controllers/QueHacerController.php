<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

use App\Models\Destino;
use App\Models\Idioma;
use App\Models\Tipo_Turismo;
use App\Models\Categoria_Turismo;
use App\Models\Perfil_Usuario;
use App\Models\Tipo_Atraccion;
use App\Models\Tipo_Evento;
use App\Models\Tipo_Proveedor;
use App\Models\Categoria_Proveedor;
use Illuminate\Pagination\LengthAwarePaginator;
use Route;
use Illuminate\Input;

use App\Models\Actividades;
use App\Models\Atracciones;
use App\Models\Evento;

class QueHacerController extends Controller
{
    public function getIndex(Request $request){
        
        $lang = \Config::get('app.locale') == 'es' ? 1 : 2;
        $result = null;

        if($request->has('tipo') && $request->input('tipo') != ""){
            switch($request->input('tipo')){
                case 1:
                    $actividades = Actividades::with(
                        ['categoriaTurismoConActividades',
                        'langContent' => function($langContent) use ($lang){
                            $langContent->where('idiomas', $lang);
                        }]
                    )->where('estado',true)->paginate(9);
                    
                    $result = $actividades;
                    break;
                case 2:
                    $atracciones = Atracciones::with(
                        ['langContent' => function($langContent) use ($lang){
                            $langContent->where('idiomas_id', $lang);
                        }]
                    )->where('estado',true)->paginate(9);
                    //return $atracciones;
                    $result = $atracciones;
                    break;
                case 3:
                    $destinos = Destino::with(
                        ['langContent' => function($langContent) use ($lang){
                            $langContent->where('idiomas_id', $lang);
                        }]
                    )->where('estado',true)->orderBy('calificacion_volveria', 'desc')->paginate(9);
                    $result = $destinos;
                    break;
                case 4:
                    $eventos = Evento::with(
                        ['langContent' => function($langContent) use ($lang){
                            $langContent->where('idiomas_id', $lang);
                        }]
                    )->where('estado',true)->orderBy('fecha_in', 'asc')->paginate(9);
                    $result = $eventos;
                    break;
            }
            foreach($result as $r)
            {
                $r->tipo = $request->input('tipo');
            }
            //return $result;
        }
        
        $idIdioma = Idioma::where('culture', \Config::get('app.locale'))->pluck('id')->first();
        
        $destinos = Destino::with(['destinoConIdiomas' => function ($queryDestinoConIdiomas) use ($idIdioma){
            $queryDestinoConIdiomas->select('nombre', 'destino_id')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $experiencias = Tipo_Turismo::with(['tipoTurismoConIdiomas' => function ($queryTipoTurismoConIdiomas) use ($idIdioma){
            $queryTipoTurismoConIdiomas->select('nombre', 'tipo_turismo_id')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $categorias = Categoria_Turismo::with(['categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas) use ($idIdioma){
            $queryCategoriaTurismoConIdiomas->select('categoria_turismo_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $perfiles = Perfil_Usuario::with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdiomas) use ($idIdioma){
            $queryPerfilesUsuariosConIdiomas->select('perfiles_usuarios_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $tipoAtraccion = Tipo_Atraccion::with(['tipoAtraccionesConIdiomas' => function ($queryTipoAtraccionesConIdiomas) use ($idIdioma){
            $queryTipoAtraccionesConIdiomas->select('tipo_atracciones_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $tipoEvento = Tipo_Evento::with(['tipoEventosConIdiomas' => function ($queryTipoEventosConIdiomas) use ($idIdioma){
            $queryTipoEventosConIdiomas->select('tipo_evento_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $tipoProveedor = Tipo_Proveedor::with(['tipoProveedoresConIdiomas' => function ($queryTipoProveedoresConIdiomas) use ($idIdioma){
            $queryTipoProveedoresConIdiomas->select('tipo_proveedores_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        $categoriaProveedor = Categoria_Proveedor::with(['categoriaProveedoresConIdiomas' => function ($queryCategoriaProveedoresConIdiomas) use ($idIdioma){
            $queryCategoriaProveedoresConIdiomas->select('categoria_proveedores_id', 'nombre')->where('idiomas_id', $idIdioma);
        }])->select('id')->where('estado', true)->get();
        
        
        // $queryBasic = collect(DB::select(DB::raw('SELECT * FROM public.listado_promocion(?, null, null)'), array($idIdioma)));
        // $count = count($queryBasic);
        // if ($request->has('page')){
        //     $query = array_slice( $queryBasic->toArray(), ($request->page-1)*9, 9);
        //     $paginator = new LengthAwarePaginator($query, $count, 9, $request->page);
        // }else{
        //     $query = $queryBasic->take(9);
        //     $paginator = new LengthAwarePaginator($query, $count, 9);
        // }
        // $paginator->setPath(url()->current());
        
        //return [$paginator];
        return view('quehacer.Index', 
        ['result' => $result, 
            'destinos' => $destinos, 
            'experiencias' => $experiencias,
            'categorias' => $categorias,
            'perfiles' => $perfiles,
            'tiposAtraccion' => $tipoAtraccion,
            'tiposEvento' => $tipoEvento,
            'tiposProveedor' => $tipoProveedor,
            'categoriasProveedor' => $categoriaProveedor,
            'success' => true]);
    }
    
    public function getReset(){
        $idIdioma = Idioma::where('culture', \Config::get('app.locale'))->pluck('id')->first();
        $query = DB::select('SELECT * FROM public.listado_promocion(?, null, null) LIMIT 9', array($idIdioma));
        
        return ['query' => $query];
    }
    
    public function postSearch(Request $request){
        //return ['query' => $request->search];
        $query = $this->queHacerData($request->search);
        
        
        return ['query' => $query['success'] ? $query['query']: $this->queHacerData($search = null)['query'], 'success' => $query['success']];
        
    }
    
    public function postFiltrar(Request $request){
        $idIdioma = \Config::get('app.locale');
        
        $actividades = DB::select('SELECT * FROM public.busqueda_actividades(?, ?, ?, ?, ?, ?, ?)', array($idIdioma, 
            $this->arrayToString($request->destinos),
            $request->experiencia,
            $this->arrayToString($request->categorias),
            $request->valor_inicial == '' ? null : $request->valor_inicial,
            $request->valor_final == '' ? null : $request->valor_final,
            $this->arrayToString($request->perfiles)));
            
        $atracciones = DB::select('SELECT * FROM public.busqueda_atracciones(?, ?, ?, ?, ?, ?, ?, null)', array($idIdioma, 
            $this->arrayToString($request->destinos),
            $request->experiencia,
            $this->arrayToString($request->categorias),
            $request->valor_inicial == '' ? null : $request->valor_inicial,
            $request->valor_final == '' ? null : $request->valor_final,
            $this->arrayToString($request->perfiles)));
            
        $destinos = DB::select('SELECT * FROM public.busqueda_destino(?, ?, ?, ?)', array($idIdioma, 
            $request->experiencia,
            $this->arrayToString($request->categorias),
            $this->arrayToString($request->perfiles)));    
            
        $eventos = DB::select('SELECT * FROM public.busqueda_eventos(?, ?, null, null, null, ?, ?, ?, ?, ?)', array($idIdioma, 
            $this->arrayToString($request->categorias),
            $this->arrayToString($request->destinos),
            $request->experiencia,
            $request->valor_inicial == '' ? null : $request->valor_inicial,
            $request->valor_final == '' ? null : $request->valor_final,
            $this->arrayToString($request->perfiles))); 
            
        $proveedores = DB::select('SELECT * FROM public.busqueda_proveedor(?, ?, ?, null, null, ?, ?, ?, ?)', array($idIdioma, 
            $request->experiencia,
            $this->arrayToString($request->categorias),
            $request->valor_inicial == '' ? null : $request->valor_inicial,
            $request->valor_final == '' ? null : $request->valor_final,
            $this->arrayToString($request->destinos),
            $this->arrayToString($request->perfiles)));    
        return ['success' => true, 'query' => array_merge($actividades, $atracciones, $destinos, $eventos, $proveedores)];
    }
    
    private function arrayToString($array){
        $string = "0";
        
        if ($array == null){
            return null;
        }
        
        for ($i = 0;$i < count($array); $i++){
            $string .= ",".$array[$i]."";
        }
        
        return $string;
    }
    /**La función queHacerData pide como parámetro el idioma de la página.
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
    private function queHacerData ($search){
        $idIdioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        
        if ($search == null){
            $query = DB::select("(SELECT actividades.id AS id,  
                 actividades.calificacion_legusto AS calificacion_legusto, 
                 1 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 actividades_con_idiomas.nombre AS nombre,
                 multimedias_actividades.ruta AS portada 
             FROM actividades INNER JOIN actividades_con_idiomas ON actividades_con_idiomas.actividades_id = actividades.id AND actividades_con_idiomas.idiomas = ?
                 INNER JOIN multimedias_actividades ON actividades.id = multimedias_actividades.actividades_id AND multimedias_actividades.portada = true 
             WHERE actividades.estado = true) UNION 
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
             WHERE atracciones.estado = true) UNION 
             (SELECT destino.id AS id,  
                 destino.calificacion_legusto AS calificacion_legusto, 
                 3 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 destino_con_idiomas.nombre AS nombre, 
                 multimedia_destino.ruta AS portada 
             FROM destino INNER JOIN destino_con_idiomas ON destino.id = destino_con_idiomas.destino_id AND destino_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_destino ON destino.id = multimedia_destino.destino_id AND multimedia_destino.portada = true 
             WHERE destino.estado = true) UNION 
             (SELECT eventos.id AS id,  
                 null AS calificacion_legusto, 
                 4 AS tipo, 
                 eventos.fecha_in AS fecha_inicio, 
                 eventos.fecha_fin AS fecha_fin, 
                 eventos_con_idiomas.nombre AS nombre,
                 multimedia_evento.ruta AS portada 
             FROM eventos INNER JOIN eventos_con_idiomas ON eventos.id = eventos_con_idiomas.eventos_id AND eventos_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_evento ON eventos.id = multimedia_evento.eventos_id AND multimedia_evento.portada = true 
             WHERE eventos.estado = true) UNION 
             (SELECT rutas.id AS id,  
                 null AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true) ORDER BY tipo", [$idIdioma, $idIdioma, $idIdioma, $idIdioma, $idIdioma]);
           
             
        }else {
            //$query = DB::select('SELECT * FROM public.busqueda_promocion(?, ?)', [DB::raw("$idIdioma"), DB::raw("'%$search%'")]);
            $atributo = "%".$search."%";
            $query = DB::select('SELECT * FROM public.busqueda_promocion(?, ?)', array($idIdioma, $atributo));
            
        }
             
        /*$query = DB::select("SELECT rutas.id AS id,  
                 null AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true", [$idIdioma]);*/
             
             return ['query' => $query, 'success' => count($query) > 0];
    }
    
    public function getConsulta(){
        return $this->actividadesFilter();
    }
    
    private function actividadesFilter(){
        $idIdioma = \Config::get('app.locale');
        //$atributo = "%".$search."%";
        $busqueda = "0";
        $busqueda2 = "null";
        $proveedores = DB::select('SELECT * FROM public.busqueda_actividades(?, ?, null, null, null, null, null)', array($idIdioma, $busqueda));
        $eventos = DB::select('SELECT * FROM public.busqueda_eventos(?, null, null, null, null, null, null, null, null, null)', array($idIdioma));
        
        dd (array_merge($proveedores, $eventos));
    }
}
