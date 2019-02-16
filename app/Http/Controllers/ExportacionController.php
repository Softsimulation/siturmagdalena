<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Exportarturismoreceptor;
use App\Http\Requests;
use App\Models\Exportacion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mes_Anio;

class ExportacionController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        //$this->middleware('role:Admin|Estadistico');
        $this->middleware('permissions:export-medicionReceptor|export-medicionOferta|export-medicionInternoEmisor|export-sostenibilidadHogar|export-sostenibilidadPST',
        ['only' => ['getIndex','getMeses','postExportar'] ]);
        
        $this->middleware('permissions:export-medicionReceptor',['only' => ['ExportacionTurismoReceptor2'] ]);
        
        $this->middleware('permissions:export-medicionInternoEmisor',['only' => ['ExportacionTurismoInterno2'] ]);
        
        $this->middleware('permissions:export-sostenibilidadPST',['only' => ['ExportacionSostenibilidadpst'] ]);
        
        $this->middleware('permissions:export-sostenibilidadHogar',['only' => ['ExportacionSostenibilidadhogares'] ]);
        
        $this->middleware('permissions:export-medicionOferta',['only' => ['ExportacionOfertayEmpleo'] ]);
        
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
    }
    
    public function getIndex(){
        
        return view('exportacion.Index');
        
    }
    
    public function getMeses(){
        
        $meses=Mes_Anio::with('mes')->with('anio')->orderby('anio_id')->orderby('mes_id')->get();
        return ["meses"=>$meses];
    }
    
    public function postExportar(Request $request){
        
        $validator=\Validator::make($request->all(),[
                                                     'nombre'=>'required',
                                                     'fecha_inicial'=>'required_if:nombre,receptor,interno,sostenibilidad|date|before:tomorrow',
                                                     'fecha_final'=>'required_if:nombre,receptor,interno,sostenibilidad|date|before:tomorrow',
                                                     'categoria'=>'required_if:nombre,ofertayempleo|in:1,2,3,4,5,6',
                                                     'mes'=>'required_if:nombre,ofertayempleo|exists:meses_de_anio,id'
        
        ]);
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
            case 'sostenibilidad': 
               $url= $this->ExportacionSostenibilidadpst($request->fecha_inicial,$request->fecha_final);
            break;
            case 'ofertayempleo': 
               $url= $this->ExportacionOfertayEmpleo($request->categoria,$request->mes);
            break;
            case 'hogares':
                $url= $this->ExportacionSostenibilidadhogares($request->categoria,$request->mes);
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
    
    protected function ExportacionSostenibilidadpst($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion Sostenibilidad PST";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionsostenibilidadpst(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionSostenibilidadPst', function($excel) use($datos) {
        
                    $excel->sheet('Sostenibilidad pst', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionSostenibilidadPst.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
    protected function ExportacionSostenibilidadhogares($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion Sostenibilidad Hogares";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionsostenibilidadhogares(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionSostenibilidadhogares', function($excel) use($datos) {
        
                    $excel->sheet('Sostenibilidad hogares ', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionSostenibilidadhogares.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
    protected function ExportacionOfertayEmpleo($tipo,$mes){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion oferta y empleo";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        switch($tipo){
            
            case 1:
                 $datos = \DB::select("SELECT *from AgenciaViajes(?)", array($mes));
                 $nombre="AgenciaViajes";
                break;
            case 2:
                 $datos = \DB::select("SELECT *from AgenciaOperadoras(?)", array($mes));
                 $nombre="AgenciaOperadoras";
                break;
            case 3:
                 $datos = \DB::select("SELECT *from Alojamiento(?)", array($mes));
                 $nombre="Alojamiento";
                break;
            case 4:
                 $datos = \DB::select("SELECT *from Restaurantes(?)", array($mes));
                 $nombre="Restaurantes";
                break;
            case 5:
                 $datos = \DB::select("SELECT *from Transporte(?)", array($mes));
                 $nombre="Transporte";
                break;
            case 6:
                 $datos = \DB::select("SELECT *from empleo(?)", array($mes));
                 $nombre="Empleo";
                break;
        }
       
       
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionOfertayEmpleo', function($excel) use($datos,$nombre) {
        
                    $excel->sheet($nombre, function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionOfertayEmpleo.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
        
    }
    
}
