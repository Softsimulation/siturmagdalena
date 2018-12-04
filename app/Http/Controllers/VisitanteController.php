<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Atraccion_Favorita;
use App\Models\Atracciones;
use App\Models\Actividad_Favorita;
use App\Models\Actividad;
use App\Models\Proveedor_Favorito;
use App\Models\Proveedor;
use App\Models\Evento_Favorita;
use App\Models\Evento;
use App\Models\Planificador;

use App\Models\Planificador_Atraccion;
use App\Models\Planificador_Actividad;
use App\Models\Planificador_Proveedor;
use App\Models\Planificador_Evento;

class VisitanteController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth',['except' => ['getMiplanificador','getPlanificador', 'getMisfavoritos', 'getFavoritos'] ]);
        $this->user = \Auth::user();
        $this->idioma_id = \Config::get('app.locale') == "en" ? 2 : 1;
    }
    
    public function getMisfavoritos(){
        return view('visitante.misFavoritos');
    }
    
    
    public function getFavoritos(){
        
        if(\Auth::check()){
            $atracciones = Atraccion_Favorita::where('usuario_id', $this->user->id)
                            ->join('atracciones','atracciones_favoritas.atracciones_id','=','atracciones.id')
                            ->join('sitios_con_idiomas', function($join){
                                $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                            })
                            ->join('multimedia_sitios', function($join){
                                $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                            })
                            ->distinct()
                            ->get(['atracciones_favoritas.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen',\DB::raw(' 1  as "Tipo" ')])->toArray();
                            
            $actividades = Actividad_Favorita::where('usuario_id', $this->user->id)
                            ->join('actividades_con_idiomas', function($join){
                                $join->on('actividades_favoritas.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                            })
                            ->join('multimedias_actividades', function($join){
                                $join->on('multimedias_actividades.actividades_id', '=', 'actividades_favoritas.actividades_id')
                                ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                            })
                            ->distinct()
                            ->get(['actividades_favoritas.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen' ,\DB::raw(' 2  as "Tipo"')])->toArray();
                            
            $proveedores = Proveedor_Favorito::where('usuario_id', $this->user->id)
                            ->join('proveedores', 'proveedores_favoritos.proveedores_id', '=', 'proveedores.id')
                            ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                            ->join('proveedores_rnt_idiomas', function($join){
                                $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                            })
                            ->join('multimedias_proveedores', function($join){
                                $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                            })
                            ->distinct()
                            ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen' ,\DB::raw(' 3  as "Tipo"') ])->toArray();
                            
            $eventos = Evento_Favorita::where('usuario_id', $this->user->id)
                        ->join('eventos','eventos_favoritas.eventos_id', '=', 'eventos.id')
                        ->join('eventos_con_idiomas', function($join){
                            $join->on('eventos_con_idiomas.eventos_id', '=' , 'eventos_favoritas.eventos_id')
                            ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                        })
                        ->join('multimedia_evento', function($join){
                            $join->on('eventos_favoritas.eventos_id', '=', 'multimedia_evento.eventos_id')
                            ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                        })
                        ->distinct()
                        ->get(['eventos_favoritas.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen', \DB::raw(' 4  as "Tipo"'), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
                        
            $favoritos = array_merge($atracciones,$actividades,$proveedores,$eventos);
            
            $planificadores = Planificador::where('usuario_id', $this->user->id)->get();
            $listaPlanificadores = array();
            foreach($planificadores as $planificador){
                $plan['Id'] = $planificador->id;
                $plan['Nombre'] = $planificador->nombre;
                $plan['Fecha_inicio'] = $planificador->fecha_inicio;
                $plan['Fecha_fin'] = $planificador->fecha_fin;
                
                $diasMax = [$planificador->planificadorProveedores->max('dia'),$planificador->planificadorEventos->max('dia'),$planificador->planificadorAtracciones->max('dia'),$planificador->planificadorActividades->max('dia')];
                $plan['NumeroDias'] = max($diasMax);
                
                $dias = array();
                for($i = 1; $i <= $plan['NumeroDias']; $i++ ){
                    $atraccionesSeleccionadas = Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('atracciones','planificador_atracciones.atracciones_id','=','atracciones.id')
                                                ->join('sitios_con_idiomas', function($join){
                                                    $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                                    ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                                                })
                                                ->join('multimedia_sitios', function($join){
                                                    $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                                    ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                                                })
                                                ->distinct()
                                                ->get(['planificador_atracciones.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen','planificador_atracciones.orden_visita as Orden',\DB::raw(' 1  as "Tipo" ')])->toArray();
                    
                    $actividadesSeleccionadas = Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('actividades_con_idiomas', function($join){
                                                    $join->on('planificador_actividades.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                                    ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                                                })
                                                ->join('multimedias_actividades', function($join){
                                                    $join->on('multimedias_actividades.actividades_id', '=', 'planificador_actividades.actividades_id')
                                                    ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                                                })
                                                ->distinct()
                                                ->get(['planificador_actividades.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen','planificador_actividades.orden_dia as Orden' ,\DB::raw(' 2  as "Tipo"')])->toArray();
                                                
                    $proveedoresSeleccionados = Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('proveedores', 'planificador_proveedores.proveedor_id', '=', 'proveedores.id')
                                                ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                                                ->join('proveedores_rnt_idiomas', function($join){
                                                    $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                                    ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                                                })
                                                ->join('multimedias_proveedores', function($join){
                                                    $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                                    ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                                                })
                                                ->distinct()
                                                ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen','planificador_proveedores.orden_visita as Orden' ,\DB::raw(' 3  as "Tipo"') ])->toArray();
                                                
                    $eventosSeleccionados = Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $i)
                                            ->join('eventos','planificador_eventos.eventos_id', '=', 'eventos.id')
                                            ->join('eventos_con_idiomas', function($join){
                                                $join->on('eventos_con_idiomas.eventos_id', '=' , 'planificador_eventos.eventos_id')
                                                ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                                            })
                                            ->join('multimedia_evento', function($join){
                                                $join->on('planificador_eventos.eventos_id', '=', 'multimedia_evento.eventos_id')
                                                ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                                            })
                                            ->distinct()
                                            ->get(['planificador_eventos.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen','planificador_eventos.orden_visita as Orden', \DB::raw(' 4  as "Tipo"'), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
                    
                    $objeto['Items'] = array_merge($atraccionesSeleccionadas,$actividadesSeleccionadas,$proveedoresSeleccionados,$eventosSeleccionados);
                    array_push($dias,$objeto);
                }
                $plan['Dias'] = $dias;
                
                array_push($listaPlanificadores, $plan);
            }
        }else{
            $favoritos = array();
            $listaPlanificadores = array();
        }
        

        
        
        return ['favoritos' => $favoritos, 'listaPlanificadores' => $listaPlanificadores];
    }
    
    public function postGuardarplanificador(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'Fecha_fin' => 'required',
			'Fecha_inicio' => 'required',
			'Nombre' => 'required|max:250',
			'Dias'=> 'required|min:1',
			'Dias.*.Items' => 'required|min:1',
			'Dias.*.Items.*.Orden' => 'required|min:1'
    	],[
       		'Dias.*.Items.required' => 'Verifique que los días del planificador tenga por lo menos un ítem.',
       		'Dias.*.Items.min' => 'Verifique que los días del planificador tenga por lo menos un ítem.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$fechaFin = date('Y-m-d',strtotime($request->Fecha_fin));
		$fechaInicio = date('Y-m-d',strtotime($request->Fecha_inicio));
		
		if( $fechaInicio > $fechaFin ){
		    return ["success"=>false,"errores"=> [ ["La fecha de inicio del planificador no debe ser mayor a la de fin."] ] ];
		}
		
		foreach($request->Dias as $dia){
		    foreach($dia['Items'] as $item){
		        switch($item['Tipo']){
		            case 1:
		                if(Atracciones::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["La atracción " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
		                break;
	                case 2:
	                    if(Actividad::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["La actividad " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
	                    break;
                    case 3:
                        if(Proveedor::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["EL proveedor " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
                        break;
                    case 4:
                        if(Evento::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["El evento " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
                        break;
		        }
		    }
		}
		
		$userId = $this->user->id;
		$planificadorValidar = Planificador::where(function($query)use($fechaInicio,$userId){
		    $query->where('fecha_inicio', '<=', $fechaInicio)->where('fecha_fin', '>=', $fechaInicio)->where('usuario_id', $userId);
		})->orWhere(function($query)use($fechaFin,$userId){
		    $query->where('fecha_inicio', '<=', $fechaFin)->where('fecha_fin', '>=', $fechaFin)->where('usuario_id', $userId);
		})->orWhere(function($query)use($fechaInicio,$fechaFin,$userId){
		    $query->where('fecha_inicio', '>=', $fechaInicio)->where('fecha_fin', '<=', $fechaFin)->where('usuario_id', $userId);
		})->first();
		if( $planificadorValidar ){
		    return ["success" => false, "errores" => [["Ya existe un planificador en ese rango de fecha."]] ];
		}
		
		$planificador = Planificador::create([
	        'usuario_id' => $this->user->id,
	        'fecha_inicio' => $fechaInicio,
	        'fecha_fin' => $fechaFin,
	        'nombre' => $request->Nombre
	    ]);
	    
	    $index = 1;
	    foreach($request->Dias as $dia){
		    foreach($dia['Items'] as $item){
		        switch($item['Tipo']){
		            case 1:
		                Planificador_Atraccion::create([
	                        'atracciones_id' => $item['Id'],
	                        'planificador_id' => $planificador->id,
	                        'dia' => $index,
	                        'orden_visita' => $item['Orden']
	                    ]);
		                break;
	                case 2:
	                    Planificador_Actividad::create([
	                        'actividades_id' => $item['Id'],
	                        'planificador_id' => $planificador->id,
	                        'dia' => $index,
	                        'orden_dia' => $item['Orden']
	                    ]);
	                    break;
                    case 3:
                        Planificador_Proveedor::create([
	                        'proveedor_id' => $item['Id'],
	                        'planificador_id' => $planificador->id,
	                        'dia' => $index,
	                        'orden_visita' => $item['Orden']
	                    ]);
                        break;
                    case 4:
                        Planificador_Evento::create([
	                        'eventos_id' => $item['Id'],
	                        'planificador_id' => $planificador->id,
	                        'dia' => $index,
	                        'orden_visita' => $item['Orden']
	                    ]);
                        break;
		        }
		    }
		    $index++;
		}
	    
		
		return ["success" => true];
    }
    
    public function getMiplanificador($id){
        if(!Planificador::find($id)){
            return response('Not found.', 404);
        }
        
        return View('visitante.miPlanificador',['id' => $id]);
    }
    
    public function getPlanificador($id){
        $planificador = Planificador::find($id);
        
        $plan['Id'] = $planificador->id;
        $plan['Nombre'] = $planificador->nombre;
        $plan['Fecha_inicio'] = $planificador->fecha_inicio;
        $plan['Fecha_fin'] = $planificador->fecha_fin;
        
        $diasMax = [$planificador->planificadorProveedores->max('dia'),$planificador->planificadorEventos->max('dia'),$planificador->planificadorAtracciones->max('dia'),$planificador->planificadorActividades->max('dia')];
        $plan['NumeroDias'] = max($diasMax);
        
        $dias = array();
        for($i = 1; $i <= $plan['NumeroDias']; $i++ ){
            $atraccionesSeleccionadas = Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $i)
                                        ->join('atracciones','planificador_atracciones.atracciones_id','=','atracciones.id')
                                        ->join('sitios','atracciones.sitios_id', '=', 'sitios.id')
                                        ->join('sitios_con_idiomas', function($join){
                                            $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                            ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                                        })
                                        ->join('multimedia_sitios', function($join){
                                            $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                            ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                                        })
                                        ->distinct()
                                        ->get(['planificador_atracciones.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen','planificador_atracciones.orden_visita as Orden',\DB::raw(' 1  as "Tipo", sitios_con_idiomas.descripcion as Descripcion, sitios.direccion as Direccion, atracciones.telefono as Telefono ')])->toArray();
            
            $actividadesSeleccionadas = Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $i)
                                        ->join('actividades_con_idiomas', function($join){
                                            $join->on('planificador_actividades.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                            ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                                        })
                                        ->join('multimedias_actividades', function($join){
                                            $join->on('multimedias_actividades.actividades_id', '=', 'planificador_actividades.actividades_id')
                                            ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                                        })
                                        ->distinct()
                                        ->get(['planificador_actividades.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen','planificador_actividades.orden_dia as Orden' ,\DB::raw(' 2  as "Tipo", actividades_con_idiomas.descripcion as Descripcion ')])->toArray();
                                        
            $proveedoresSeleccionados = Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $i)
                                        ->join('proveedores', 'planificador_proveedores.proveedor_id', '=', 'proveedores.id')
                                        ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                                        ->join('proveedores_rnt_idiomas', function($join){
                                            $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                            ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                                        })
                                        ->join('multimedias_proveedores', function($join){
                                            $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                            ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                                        })
                                        ->distinct()
                                        ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen','planificador_proveedores.orden_visita as Orden' ,\DB::raw(' 3  as "Tipo", proveedores_rnt_idiomas.descripcion as Descripcion, proveedores_rnt.direccion as Direccion, proveedores_rnt.telefono as Telefono ') ])->toArray();
                                        
            $eventosSeleccionados = Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $i)
                                    ->join('eventos','planificador_eventos.eventos_id', '=', 'eventos.id')
                                    ->join('eventos_con_idiomas', function($join){
                                        $join->on('eventos_con_idiomas.eventos_id', '=' , 'planificador_eventos.eventos_id')
                                        ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                                    })
                                    ->join('multimedia_evento', function($join){
                                        $join->on('planificador_eventos.eventos_id', '=', 'multimedia_evento.eventos_id')
                                        ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                                    })
                                    ->distinct()
                                    ->get(['planificador_eventos.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen','planificador_eventos.orden_visita as Orden', \DB::raw(' 4  as "Tipo", eventos_con_idiomas.descripcion as Descripcion, eventos.telefono as Telefono '), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
            
            $objeto['Items'] = array_merge($atraccionesSeleccionadas,$actividadesSeleccionadas,$proveedoresSeleccionados,$eventosSeleccionados);
            array_push($dias,$objeto);
        }
        $plan['Dias'] = $dias;
        
        return['planificador' => $plan];
    }
    
    public function getEditarplanificador($id){
        if(!Planificador::find($id)){
            return response('Not found.', 404);
        }
        
        return View('visitante.editarPlanificador',['id' => $id]);
    }
    
    public function getCargareditarplanificador($id){
        if(\Auth::check()){
            $atracciones = Atraccion_Favorita::where('usuario_id', $this->user->id)
                            ->join('atracciones','atracciones_favoritas.atracciones_id','=','atracciones.id')
                            ->join('sitios_con_idiomas', function($join){
                                $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                            })
                            ->join('multimedia_sitios', function($join){
                                $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                            })
                            ->distinct()
                            ->get(['atracciones_favoritas.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen',\DB::raw(' 1  as "Tipo" ')])->toArray();
                            
            $actividades = Actividad_Favorita::where('usuario_id', $this->user->id)
                            ->join('actividades_con_idiomas', function($join){
                                $join->on('actividades_favoritas.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                            })
                            ->join('multimedias_actividades', function($join){
                                $join->on('multimedias_actividades.actividades_id', '=', 'actividades_favoritas.actividades_id')
                                ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                            })
                            ->distinct()
                            ->get(['actividades_favoritas.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen' ,\DB::raw(' 2  as "Tipo"')])->toArray();
                            
            $proveedores = Proveedor_Favorito::where('usuario_id', $this->user->id)
                            ->join('proveedores', 'proveedores_favoritos.proveedores_id', '=', 'proveedores.id')
                            ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                            ->join('proveedores_rnt_idiomas', function($join){
                                $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                            })
                            ->join('multimedias_proveedores', function($join){
                                $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                            })
                            ->distinct()
                            ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen' ,\DB::raw(' 3  as "Tipo"') ])->toArray();
                            
            $eventos = Evento_Favorita::where('usuario_id', $this->user->id)
                        ->join('eventos','eventos_favoritas.eventos_id', '=', 'eventos.id')
                        ->join('eventos_con_idiomas', function($join){
                            $join->on('eventos_con_idiomas.eventos_id', '=' , 'eventos_favoritas.eventos_id')
                            ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                        })
                        ->join('multimedia_evento', function($join){
                            $join->on('eventos_favoritas.eventos_id', '=', 'multimedia_evento.eventos_id')
                            ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                        })
                        ->distinct()
                        ->get(['eventos_favoritas.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen', \DB::raw(' 4  as "Tipo"'), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
                        
            $favoritos = array_merge($atracciones,$actividades,$proveedores,$eventos);
            
            $planificadores = Planificador::where('usuario_id', $this->user->id)->where('id', '<>' ,$id)->get();
            $listaPlanificadores = array();
            foreach($planificadores as $planificador){
                $plan['Id'] = $planificador->id;
                $plan['Nombre'] = $planificador->nombre;
                $plan['Fecha_inicio'] = date('d-m-Y', strtotime($planificador->fecha_inicio) );
                $plan['Fecha_fin'] = date('d-m-Y', strtotime($planificador->fecha_fin) );
                
                $diasMax = [$planificador->planificadorProveedores->max('dia'),$planificador->planificadorEventos->max('dia'),$planificador->planificadorAtracciones->max('dia'),$planificador->planificadorActividades->max('dia')];
                $plan['NumeroDias'] = max($diasMax);
                
                $dias = array();
                for($i = 1; $i <= $plan['NumeroDias']; $i++ ){
                    $atraccionesSeleccionadas = Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('atracciones','planificador_atracciones.atracciones_id','=','atracciones.id')
                                                ->join('sitios_con_idiomas', function($join){
                                                    $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                                    ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                                                })
                                                ->join('multimedia_sitios', function($join){
                                                    $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                                    ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                                                })
                                                ->distinct()
                                                ->get(['planificador_atracciones.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen','planificador_atracciones.orden_visita as Orden',\DB::raw(' 1  as "Tipo" ')])->toArray();
                    
                    $actividadesSeleccionadas = Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('actividades_con_idiomas', function($join){
                                                    $join->on('planificador_actividades.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                                    ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                                                })
                                                ->join('multimedias_actividades', function($join){
                                                    $join->on('multimedias_actividades.actividades_id', '=', 'planificador_actividades.actividades_id')
                                                    ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                                                })
                                                ->distinct()
                                                ->get(['planificador_actividades.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen','planificador_actividades.orden_dia as Orden' ,\DB::raw(' 2  as "Tipo"')])->toArray();
                                                
                    $proveedoresSeleccionados = Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $i)
                                                ->join('proveedores', 'planificador_proveedores.proveedor_id', '=', 'proveedores.id')
                                                ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                                                ->join('proveedores_rnt_idiomas', function($join){
                                                    $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                                    ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                                                })
                                                ->join('multimedias_proveedores', function($join){
                                                    $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                                    ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                                                })
                                                ->distinct()
                                                ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen','planificador_proveedores.orden_visita as Orden' ,\DB::raw(' 3  as "Tipo"') ])->toArray();
                                                
                    $eventosSeleccionados = Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $i)
                                            ->join('eventos','planificador_eventos.eventos_id', '=', 'eventos.id')
                                            ->join('eventos_con_idiomas', function($join){
                                                $join->on('eventos_con_idiomas.eventos_id', '=' , 'planificador_eventos.eventos_id')
                                                ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                                            })
                                            ->join('multimedia_evento', function($join){
                                                $join->on('planificador_eventos.eventos_id', '=', 'multimedia_evento.eventos_id')
                                                ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                                            })
                                            ->distinct()
                                            ->get(['planificador_eventos.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen','planificador_eventos.orden_visita as Orden', \DB::raw(' 4  as "Tipo"'), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
                    
                    $objeto['Items'] = array_merge($atraccionesSeleccionadas,$actividadesSeleccionadas,$proveedoresSeleccionados,$eventosSeleccionados);
                    array_push($dias,$objeto);
                }
                $plan['Dias'] = $dias;
                
                array_push($listaPlanificadores, $plan);
            }
            
            $planificador = Planificador::find($id);
        
            $plan['Id'] = $planificador->id;
            $plan['Nombre'] = $planificador->nombre;
            $plan['Fecha_inicio'] = date('d-m-Y', strtotime($planificador->fecha_inicio) );
            $plan['Fecha_fin'] = date('d-m-Y', strtotime($planificador->fecha_fin) );
            
            $diasMax = [$planificador->planificadorProveedores->max('dia'),$planificador->planificadorEventos->max('dia'),$planificador->planificadorAtracciones->max('dia'),$planificador->planificadorActividades->max('dia')];
            $plan['NumeroDias'] = max($diasMax);
            
            $dias = array();
            for($i = 1; $i <= $plan['NumeroDias']; $i++ ){
                $atraccionesSeleccionadas = Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $i)
                                            ->join('atracciones','planificador_atracciones.atracciones_id','=','atracciones.id')
                                            ->join('sitios','atracciones.sitios_id', '=', 'sitios.id')
                                            ->join('sitios_con_idiomas', function($join){
                                                $join->on('atracciones.sitios_id', '=','sitios_con_idiomas.sitios_id')
                                                ->where('sitios_con_idiomas.idiomas_id','=', $this->idioma_id);
                                            })
                                            ->join('multimedia_sitios', function($join){
                                                $join->on('atracciones.sitios_id','=','multimedia_sitios.sitios_id')
                                                ->where('multimedia_sitios.portada','=' ,true)->where('multimedia_sitios.tipo', '=' , false);
                                            })
                                            ->distinct()
                                            ->get(['planificador_atracciones.atracciones_id as Id','sitios_con_idiomas.nombre as Nombre','multimedia_sitios.ruta as Imagen','planificador_atracciones.orden_visita as Orden',\DB::raw(' 1  as "Tipo", sitios_con_idiomas.descripcion as Descripcion, sitios.direccion as Direccion, atracciones.telefono as Telefono ')])->toArray();
                
                $actividadesSeleccionadas = Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $i)
                                            ->join('actividades_con_idiomas', function($join){
                                                $join->on('planificador_actividades.actividades_id', '=', 'actividades_con_idiomas.actividades_id')
                                                ->where('actividades_con_idiomas.idiomas','=',$this->idioma_id);
                                            })
                                            ->join('multimedias_actividades', function($join){
                                                $join->on('multimedias_actividades.actividades_id', '=', 'planificador_actividades.actividades_id')
                                                ->where('multimedias_actividades.portada','=', true)->where('multimedias_actividades.tipo','=', false);
                                            })
                                            ->distinct()
                                            ->get(['planificador_actividades.actividades_id as Id', 'actividades_con_idiomas.nombre as Nombre' ,'multimedias_actividades.ruta as Imagen','planificador_actividades.orden_dia as Orden' ,\DB::raw(' 2  as "Tipo", actividades_con_idiomas.descripcion as Descripcion ')])->toArray();
                                            
                $proveedoresSeleccionados = Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $i)
                                            ->join('proveedores', 'planificador_proveedores.proveedor_id', '=', 'proveedores.id')
                                            ->join('proveedores_rnt', 'proveedores_rnt.id', '=', 'proveedores.proveedor_rnt_id')
                                            ->join('proveedores_rnt_idiomas', function($join){
                                                $join->on('proveedores_rnt.id', '=', 'proveedores_rnt_idiomas.proveedor_rnt_id')
                                                ->where('proveedores_rnt_idiomas.idioma_id','=', $this->idioma_id);
                                            })
                                            ->join('multimedias_proveedores', function($join){
                                                $join->on('proveedores.id','=','multimedias_proveedores.proveedor_id')
                                                ->where('multimedias_proveedores.portada','=' ,true)->where('multimedias_proveedores.tipo', '=' , false);
                                            })
                                            ->distinct()
                                            ->get([ 'proveedores.id as Id', 'proveedores_rnt_idiomas.nombre as Nombre', 'multimedias_proveedores.ruta as Imagen','planificador_proveedores.orden_visita as Orden' ,\DB::raw(' 3  as "Tipo", proveedores_rnt_idiomas.descripcion as Descripcion, proveedores_rnt.direccion as Direccion, proveedores_rnt.telefono as Telefono ') ])->toArray();
                                            
                $eventosSeleccionados = Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $i)
                                        ->join('eventos','planificador_eventos.eventos_id', '=', 'eventos.id')
                                        ->join('eventos_con_idiomas', function($join){
                                            $join->on('eventos_con_idiomas.eventos_id', '=' , 'planificador_eventos.eventos_id')
                                            ->where('eventos_con_idiomas.idiomas_id', '=', $this->idioma_id);
                                        })
                                        ->join('multimedia_evento', function($join){
                                            $join->on('planificador_eventos.eventos_id', '=', 'multimedia_evento.eventos_id')
                                            ->where('multimedia_evento.portada', '=', true)->where('multimedia_evento.tipo', '=', false);
                                        })
                                        ->distinct()
                                        ->get(['planificador_eventos.eventos_id as Id', 'eventos_con_idiomas.nombre as Nombre', 'multimedia_evento.ruta as Imagen','planificador_eventos.orden_visita as Orden', \DB::raw(' 4  as "Tipo", eventos_con_idiomas.descripcion as Descripcion, eventos.telefono as Telefono '), 'eventos.fecha_in as FechaInicial', 'eventos.fecha_fin as FechaFin' ])->toArray();
                
                $objeto['Items'] = array_merge($atraccionesSeleccionadas,$actividadesSeleccionadas,$proveedoresSeleccionados,$eventosSeleccionados);
                array_push($dias,$objeto);
            }
            $plan['Dias'] = $dias;
            
        }else{
            $favoritos = array();
            $listaPlanificadores = array();
            $plan = null;
        }
        

        
        
        return ['favoritos' => $favoritos, 'listaPlanificadores' => $listaPlanificadores, 'planificador' => $plan];
    }
    
    public function postEditarplanificador(Request $request){
        $validator = \Validator::make($request->all(), [
            'Id' => 'required|exists:planificador,id',
			'Fecha_fin' => 'required',
			'Fecha_inicio' => 'required',
			'Nombre' => 'required|max:250',
			'Dias'=> 'required|min:1',
			'Dias.*.Items' => 'required|min:1',
			'Dias.*.Items.*.Orden' => 'required|min:1'
    	],[
       		'Dias.*.Items.required' => 'Verifique que los días del planificador tenga por lo menos un ítem.',
       		'Dias.*.Items.min' => 'Verifique que los días del planificador tenga por lo menos un ítem.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$fechaFin = date('Y-m-d',strtotime($request->Fecha_fin));
		$fechaInicio = date('Y-m-d',strtotime($request->Fecha_inicio));
		
		if( $fechaInicio > $fechaFin ){
		    return ["success"=>false,"errores"=> [ ["La fecha de inicio del planificador no debe ser mayor a la de fin."] ] ];
		}
		
		foreach($request->Dias as $dia){
		    foreach($dia['Items'] as $item){
		        switch($item['Tipo']){
		            case 1:
		                if(Atracciones::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["La atracción " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
		                break;
	                case 2:
	                    if(Actividad::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["La actividad " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
	                    break;
                    case 3:
                        if(Proveedor::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["EL proveedor " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
                        break;
                    case 4:
                        if(Evento::find($item['Id']) == null ){
		                    return ["success" => false, "errores" => [["El evento " . $item['Nombre'] . " no se encuentra ingresada en el sistema." ]] ];
		                }
                        break;
		        }
		    }
		}
		
		$userId = $this->user->id;
		$planificadorValidar = Planificador::where(function($query)use($fechaInicio,$userId,$request){
		    $query->where('fecha_inicio', '<=', $fechaInicio)->where('fecha_fin', '>=', $fechaInicio)->where('usuario_id', $userId)->where('id', '<>', $request->Id);
		})->orWhere(function($query)use($fechaFin,$userId,$request){
		    $query->where('fecha_inicio', '<=', $fechaFin)->where('fecha_fin', '>=', $fechaFin)->where('usuario_id', $userId)->where('id', '<>', $request->Id);
		})->orWhere(function($query)use($fechaInicio,$fechaFin,$userId,$request){
		    $query->where('fecha_inicio', '>=', $fechaInicio)->where('fecha_fin', '<=', $fechaFin)->where('usuario_id', $userId)->where('id', '<>', $request->Id);
		})->first();
		if( $planificadorValidar ){
		    return ["success" => false, "errores" => [["Ya existe un planificador en ese rango de fecha."]] ];
		}
	    
	    $planificador= Planificador::find($request->Id);
	    $planificador->fecha_inicio = $fechaInicio;
	    $planificador->fecha_fin = $fechaFin;
	    $planificador->nombre = $request->Nombre;
	    $planificador->save();
	    
	    $index = 1;
	    foreach($request['Dias'] as $dia){
	        $idsAtracciones = collect($dia['Items'])->where('Tipo', 1)->pluck('Id')->toArray();
	        $idsActividades = collect($dia['Items'])->where('Tipo', 2)->pluck('Id')->toArray();
	        $idsProveedores = collect($dia['Items'])->where('Tipo', 3)->pluck('Id')->toArray();
	        $idsEventos = collect($dia['Items'])->where('Tipo', 4)->pluck('Id')->toArray();
	        
	        Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $index)->whereNotIn('atracciones_id',$idsAtracciones)->delete();
    	    Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $index)->whereNotIn('actividades_id',$idsActividades)->delete();
    	    Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $index)->whereNotIn('proveedor_id',$idsProveedores)->delete();
    	    Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $index)->whereNotIn('eventos_id',$idsEventos)->delete();
	        
	        $index++;
	    }
	    
	    Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', '>' ,count($request['Dias']))->delete();
	    Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', '>' ,count($request['Dias']))->delete();
	    Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', '>' ,count($request['Dias']))->delete();
	    Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', '>' ,count($request['Dias']))->delete();
	    
	    $index = 1;
	    foreach($request->Dias as $dia){
		    foreach($dia['Items'] as $item){
		        switch($item['Tipo']){
		            case 1:
		                if(Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $index)->where('atracciones_id', $item['Id'])->first() == null ){
		                    Planificador_Atraccion::create([
    	                        'atracciones_id' => $item['Id'],
    	                        'planificador_id' => $planificador->id,
    	                        'dia' => $index,
    	                        'orden_visita' => $item['Orden']
    	                    ]);
		                }else{
		                   $planificadorAtraccion = Planificador_Atraccion::where('planificador_id', $planificador->id)->where('dia', $index)->where('atracciones_id', $item['Id'])->first();
		                   $planificadorAtraccion->orden_visita = $item['Orden'];
		                   $planificadorAtraccion->save();
		                }
		                break;
	                case 2:
	                    if(Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $index)->where('actividades_id', $item['Id'])->first() == null){
	                        Planificador_Actividad::create([
    	                        'actividades_id' => $item['Id'],
    	                        'planificador_id' => $planificador->id,
    	                        'dia' => $index,
    	                        'orden_dia' => $item['Orden']
    	                    ]);
	                    }else{
	                        $planificadorActividad = Planificador_Actividad::where('planificador_id', $planificador->id)->where('dia', $index)->where('actividades_id', $item['Id'])->first();
	                        $planificadorActividad->orden_dia = $item['Orden'];
	                        $planificadorActividad->save();
	                    }
	                    break;
                    case 3:
                        if(Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $index)->where('proveedor_id', $item['Id'])->first() == null){
                            Planificador_Proveedor::create([
    	                        'proveedor_id' => $item['Id'],
    	                        'planificador_id' => $planificador->id,
    	                        'dia' => $index,
    	                        'orden_visita' => $item['Orden']
    	                    ]);
                        }else{
                            $planificadorProveedor = Planificador_Proveedor::where('planificador_id', $planificador->id)->where('dia', $index)->where('proveedor_id', $item['Id'])->first();
                            $planificadorProveedor->orden_visita = $item['Orden'];
                            $planificadorProveedor->save();
                        }
                        break;
                    case 4:
                        if(Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $index)->where('eventos_id', $item['Id'])->first() == null){
                            Planificador_Evento::create([
    	                        'eventos_id' => $item['Id'],
    	                        'planificador_id' => $planificador->id,
    	                        'dia' => $index,
    	                        'orden_visita' => $item['Orden']
    	                    ]);
                        }else{
                            $planificadorEvento = Planificador_Evento::where('planificador_id', $planificador->id)->where('dia', $index)->where('eventos_id', $item['Id'])->first();
                            $planificadorEvento->orden_visita = $item['Orden'];
                            $planificadorEvento->save();
                        }
                        break;
		        }
		    }
		    $index++;
		}
	    
		
		return ["success" => true];
    }
    
    public function postEliminarplanificador(Request $request){
        $validator = \Validator::make($request->all(), [
            'Id' => 'required|exists:planificador,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(Planificador::where('id', $request->Id)->where('usuario_id', $this->user->id)->first() == null){
		    return ["success"=>false,"errores"=> [ ["El planificador seleccionado no se encuentra registrado ó no le pertenece al usuario logueado."] ] ];
		}
		
		Planificador_Atraccion::where('planificador_id', $request->Id)->delete();
	    Planificador_Actividad::where('planificador_id', $request->Id)->delete();
	    Planificador_Proveedor::where('planificador_id', $request->Id)->delete();
	    Planificador_Evento::where('planificador_id', $request->Id)->delete();
		Planificador::find($request->Id)->delete();
		
		return ["success" => true];
    }
    
}
