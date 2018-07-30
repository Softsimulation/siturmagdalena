<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Encuesta;
use App\Models\Sitio_Para_Encuesta;

class OfertaEmpleo
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
        
        if(strlen(strstr($request->path(),'ofertaempleo/encuesta'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->one);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/listadoproveedores/'.$request->one);
            }
            
          
            
        }    
    
    
     if(strlen(strstr($request->path(),'ofertaempleo/actividadcomercial'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->three);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
          
            
        }
        
        
    $encuesta = Encuesta::find($request->one);
    if($encuesta->actividad_comercial == 0){
        return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
        
    }
    
    if($encuesta == null){
         \Session::flash('mensaje','No existe la encuesta');
                return redirect('/ofertaempleo/listadoproveedores');
    }
    
    if(strlen(strstr($request->path(),'ofertaempleo/agenciaviajes'))>0){
            $encuesta = Encuesta::find($request->one);
            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/ofertaagenciaviajes'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
    }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionalquilervehiculo'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 21){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionagenciasoperadoras'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/ocupacionagenciasoperadoras'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizaciontransporte'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/ofertatransporte'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionalimentos'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11 ){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/capacidadalimentos'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacion'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/oferta'))>0){
            $encuesta = Encuesta::find($request->one);
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1 ){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
        }
        
        return $next($request);
    }
}
