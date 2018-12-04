<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Exportarturismoreceptor;
use App\Http\Requests;
use App\Models\Exportacion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ExportacionController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin|Estadistico');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
    }
    
    public function getIndex(){
        
        return view('exportacion.Index');
        
    }
    
    public function postExportar(Request $request){
        
        $validator=\Validator::make($request->all(),['nombre'=>'required','fecha_inicial'=>'required|date|before:tomorrow','fecha_final'=>'required|date|before:tomorrow']);
        $url='';
        if($validator->fails()){
            
            return ["success"=>false,"errores"=>$validator->errors()];
            
        }
        
        switch($request->nombre){
            
            case 'receptor': 
                $this->ExportacionTurismoReceptor2($request->fecha_inicial,$request->fecha_final);
                $url='/excel/exports/Exportacion.xlsx';
            break;
             case 'interno': 
               $url= $this->ExportacionTurismoInterno2($request->fecha_inicial,$request->fecha_final);
            break;
            
        }
        
        return ["success"=>true,'url'=>$url];
    }
    
    protected function ExportacionTurismoReceptor2($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion turismo receptor";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionreceptor(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('Exportacion', function($excel) use($datos) {
        
                    $excel->sheet('Turismo receptor', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/Exportacion.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
        
    }
    
      protected function ExportacionTurismoInterno2($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion turismo interno";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacioninterno(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionInterno', function($excel) use($datos) {
        
                    $excel->sheet('Turismo interno', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionInterno.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
}
