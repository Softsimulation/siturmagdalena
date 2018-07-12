<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function postEnviocorreooferta(Request $request)
    {
        //return $request->all();
        $errores = [];
        
        foreach($request->usuarios as $prov){
            $proveedor = User::where('id',intval($prov))->first();
            if($prov != null){
                $fecha_actual = Carbon::now();
                $data = [];
                $data["email"] = $proveedor->email;
                $data["nombre"] = $proveedor->nombre;
                $data["ESTABLECIMIENTO"] = $proveedor->nombre;
                $data["anio"] = $fecha_actual->format('Y');
                $data["mes"] = $fecha_actual->format('m');
                
                \Mail::send('Email.PlantillaRecordatorioOferta', $data, function($message) use ($proveedor){
               //remitente
               $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
     
               //asunto
               $message->subject("Invitación MinCIT – SITUR Magdalena.");
     
               //receptor
               $message->to($proveedor->email, $proveedor->nombres);
                });
                if( count(\Mail::failures()) > 0 ) {
                    $errores["Email"][0] = "Algún proveedor ".$proveedor->nombre." no se le pudo enviar el correo.";
                    //return ["success"=>false,"errores"=>"No se pudo realizar el envío de correo."];
                   
                }
            }else{
                    $errores["Proveedor"][0] = "Algún proveedor no se encuentra registrado en el sistema.";
            }
        }
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        return ['success'=> true];
    }
}
