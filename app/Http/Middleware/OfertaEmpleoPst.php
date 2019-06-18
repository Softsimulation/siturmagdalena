<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Encuesta;
use App\Models\Sitio_Para_Encuesta;
use Illuminate\Database\Eloquent\Collection;
use DB;
class OfertaEmpleoPst
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
        
        if(strlen(strstr($request->path(),'ofertaempleopst/encuesta'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->one);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/listadoproveedores/'.$request->one);
            }
            
          
            
        }    

     
     if(strlen(strstr($request->path(),'ofertaempleopst/actividadcomercial'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->three);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/encuestas/'.$sitio->id);
            }
            
          
            
        }
    $data =  new Collection(DB::select("SELECT *from listado_encuesta_oferta where id =".$request->one));
    $encuesta = Encuesta::find($request->one);
    if($encuesta == null){
         \Session::flash('mensaje','No existe la encuesta');
                return redirect('/ofertaempleo/listadoproveedores');
    }    
        
    
    
    
    
    
    if(strlen(strstr($request->path(),'ofertaempleopst/agenciaviajes'))>0){
            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/ofertaagenciaviajes'))>0){
           if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }
           
            if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 13){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
    }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/caracterizacionalquilervehiculo'))>0){
          
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 21){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        if(strlen(strstr($request->path(),'ofertaempleopst/ofertalquilervehiculo'))>0){
            if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }
           if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }     
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 21){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
     
     
    if(strlen(strstr($request->path(),'ofertaempleopst/caracterizacionagenciasoperadoras'))>0){
           
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleopst/ocupacionagenciasoperadoras'))>0){
        if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }
                if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }        
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/caracterizaciontransporte'))>0){   

            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleopst/ofertatransporte'))>0){
              if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }
 
             if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }           
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/caracterizacionalimentos'))>0){        
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11 ){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleopst/capacidadalimentos'))>0){
              if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }
 
             if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }                 
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/alojamientomensual'))>0){
              if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }           
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1){
                      if($data[0]->mes_id%3 == 0){
                        return redirect('/ofertaempleo/caracterizacion/'.$request->one);
                      }
            
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
    
    if(strlen(strstr($request->path(),'ofertaempleopst/caracterizacion'))>0){
            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1){
          
             
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
     
    if(strlen(strstr($request->path(),'ofertaempleopst/oferta'))>0){
             if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1 ){
                  if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/alojamientomensual/'.$request->one);
                      }
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleopst/empleomensual'))>0){
               if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }          
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            } else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return $next($request);
            }
            
     }
     

     
     if(strlen(strstr($request->path(),'ofertaempleoempleo/empleo'))>0){
             if($encuesta->actividad_comercial == false  ){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
                
            }            
            if($data[0]->mes_id%3 == 0){
                return redirect('/ofertaempleo/empleomensual/'.$request->one);
            } else{
                return $next($request);
            }
            
     }

        
        return $next($request);
    }
}