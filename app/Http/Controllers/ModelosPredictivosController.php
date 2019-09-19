<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ModelosPredictivosController extends Controller
{
    
    public function getIndex(){
        
        return view('modelospredictivos.index');
    }

    public function getData(){

        $actividades=\DB::select('select actividad as id, aci.nombre as nombre from consulta join actividades_realizadas_con_idiomas aci on actividad=aci.actividad_realizada_id where aci.idiomas_id=1 group by actividad, aci.nombre');
        $pais=\DB::select('select pais as nombre from consulta group by pais');
        $departamento=\DB::select('select departamento as nombre,pais from consulta group by departamento,pais');
        $municipio=\DB::select('select municipio as nombre,departamento from consulta group by municipio,departamento');
        $motivos=\DB::select('select motivo_viaje as nombre from consulta group by motivo_viaje');
        return [
            'actividades'=>$actividades,
            'pais'=>$pais,
            'departamentos'=>$departamento,
            'municipios'=>$municipio,
            'motivos'=>$motivos
        ];
    }

    public function postPredecir(Request $request){
        $validator=\Validator::make(
            $request->all(),
            [
                'predicion'=>'required',
                'variables'=>'required'                
            ]
        );
        if($validator->fails()){
            return ["success"=>false];
        }
        $ecuacion=$request->predicion.' ~ '.implode("+",$request->variables);
        $pais=($request->pais == null)?"":$request->pais;
        $departamento=($request->departamento == null)?"":$request->departamento;
        $municipio=($request->municipio == null)?"":$request->municipio;
        $motivo_viaje=($request->motivo_viaje == null)?"":$request->motivo_viaje;
        $actividad=($request->actividad == null)?"":$request->actividad;
        $edad=($request->edad == null)?0:$request->edad;
        $sexo=($request->sexo == null)?"":$request->sexo;
        $numero_noches=($request->numero_noches == null)?0:$request->numero_noches;
        $gasto=($request->gasto == null)?0:$request->gasto;
        $datos = \DB::select("SELECT *from visitante(?,?,?,?,?,?,?,?,?,?)", array($ecuacion,$pais,$departamento,$municipio,$motivo_viaje,$actividad,$edad,$sexo,$numero_noches,$gasto));

        return ["success"=>true,"data"=>$datos,"variable"=>$request->predicion];
        
        


    }

}
