<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Viaje;
use App\Models\Ciudad_Visitada;
use App\Models\Persona;

class TurismoInterno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
       
        
        if(strlen(strstr($request->path(),'turismointerno/actividadesrealizadas'))>0){
            
            $viaje=Viaje::find($request->one);
             $sw = 1;
        
            $principal = Ciudad_Visitada::join("municipios","municipios.id","=","municipio_id")
            ->join("departamentos","departamentos.id","=","municipios.departamento_id")
            ->where('viajes_id', $viaje->id)->where("destino_principal",true)
            ->where("departamentos.id",1411)->first();
            if($principal == null){
                $sw = 0;
            }
            
            if($sw==1){
               return $next($request);
            }else{
                return redirect('/turismointerno/viajesrealizados/'.$viaje->persona->id);
            }
            
        }
        
        if(strlen(strstr($request->path(),'turismointerno/viajesrealizados'))>0){
            
            
            $sw = 1;
        
            $persona=Persona::where('es_viajero',true)->where('es_residente',true)->where('id',$request->one)->first();
            
            if($persona == null){
                $sw = 0;
            }
            
            if($sw==1){
               return $next($request);
            }else{
                \Session::flash('mensaje','El hogar no tiene ningun miembro viajero');
                return redirect('/turismointerno/editarhogar/'.$request->one);
            }
            
        }
        
        
        
        
        
        return $next($request);
    }
}
