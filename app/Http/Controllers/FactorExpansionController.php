<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Factor_Expansion_Oferta_Empleo;
use App\Models\Tipo_Proveedor;
use App\Models\Tipo_Proveedor_Con_Idioma;
use App\Models\Mes_Anio;
use App\Models\D_Tamanio_Empresa;
use App\Models\D_Municipios_Interno;



class FactorExpansionController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        //$this->middleware('role:Admin');
        
        $this->middleware('permissions:list-factorExpansion|create-factorExpansion|edit-factorExpansion',['only' => ['getListado','getFactoresoferta'] ]);
        $this->middleware('permissions:create-factorExpansion',['only' => ['postCrearfactor'] ]);
        $this->middleware('permissions:edit-noticia',['only' => ['postEditarfactor'] ]);
        
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    public function getListado(){
        //return $this->user;
        return view('FactorExpansion.ListadoOferta');
    }
    public function getFactoresoferta(){
        $factores = Factor_Expansion_Oferta_Empleo::with(['d_municipioInterno','d_tamanioEmpresa','mesAnio'=>function($q){
            $q->with(['anio','mes']);
        },
        'tipoProveedor'=>function($q){$q->with(['tipoProveedoresConIdiomas'=>function($q){
            $q->where('idiomas_id',1);
        }]);}])->where('estado',1)->get(); 
        $proveedores = new Collection(DB::select("SELECT *from listado_proveedores_rnt"));
        $mesesAnio = Mes_Anio::with(['anio','mes'])->orderBy('anio_id','desc')->orderBy('mes_id','asc')->get();
        $tiposProveedores = Tipo_Proveedor_Con_Idioma::with(['tipoProveedore'=>function($q){$q->where('estado',1);}])->where('idiomas_id',1)->get();
        $tamaniosEmpresa = D_Tamanio_Empresa::where('estado',1)->get();
        $municipios = D_Municipios_Interno::where('estado',1)->get();
        return ["factores"=>$factores,"proveedores"=>$proveedores,"meses"=>$mesesAnio,"tiposProveedores"=>$tiposProveedores,"tamaniosEmpresa"=>$tamaniosEmpresa,"municipios"=>$municipios];
    }
    public function postCrearfactor(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'es_general' =>'required|numeric',
            'es_oferta' =>'required|numeric',
            'proveedor_rnt_id' =>'required_if:es_general,1|exists:proveedores_rnt,id',
            'cantidad' =>'required|numeric',
            'mes_id'=> 'required|exists:meses_de_anio,id',
            'municipio_id'=> 'required|exists:d_municipios_interno,id',
            'tipoProveedor_id'=> 'required|exists:tipo_proveedores,id',
            'tamanioEmpresa_id'=> 'required|exists:d_tamaño_empresa,id',
            
        ],[
            'cantidad.required' => 'El valor del factor de expansión es obligatorio.',
            'cantidad.numeric' => 'El valor solo debe ser numérico.',
            'es_general.required' => 'Se debe seleccionar si el factor es general o específico.',
            'es_general.numeric' => 'Inconsistencia en las opciones, favor recargar la página.',
            'es_oferta.required' => 'Se debe seleccionar si el factor es de la sección de oferta o empleo.',
            'es_oferta.numeric' => 'Inconsistencia en las opciones, favor recargar la página.',
            'mes_id.required' => 'El campo mes es requerido.',
            'mes_id.exists' => 'El mes seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'municipio_id.required' => 'El campo municipio es requerido.',
            'municipio_id.exists' => 'El municipio seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'tipoProveedor_id.required' => 'El campo tipo proveedor es requerido.',
            'tipoProveedor_id.exists' => 'El tipo proveedor seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'tamanioEmpresa_id.required' => 'El campo tamaño de la empresa es requerido.',
            'tamanioEmpresa_id.exists' => 'El tamaño de la empresa seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'proveedor_rnt_id.required_if' => 'El campo proveedor rnt es requerido.',
            'proveedor_rnt_id.exists' => 'El proveedor rnt seleccionado no se encuentra en la base de datos, favor recargar la página.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $busqueda = Factor_Expansion_Oferta_Empleo::where('mes_anio_id',$request->mes_id)
        ->where('d_tamanio_empresa_id',$request->tamanioEmpresa_id)
        ->where('tipo_proveedor_id',$request->tipoProveedor_id)
        ->where('d_municipio_interno_id',$request->municipio_id)->first();
        if($busqueda != null){
            return ["success"=>false,"errores"=>[["Ya el factor de expansión existe en el sistema."]]];
        }
        //return $request->all();
        $factor = new Factor_Expansion_Oferta_Empleo();
        $factor->cantidad = $request->cantidad;
        $factor->mes_anio_id = $request->mes_id;
        $factor->d_tamanio_empresa_id = $request->tamanioEmpresa_id;
        $factor->d_municipio_interno_id = $request->municipio_id;
        $factor->tipo_proveedor_id = $request->tipoProveedor_id;
        $factor->proveedor_rnt_id = $request->proveedor_rnt_id;
        $factor->es_oferta = $request->es_oferta;
        $factor->user_create = $this->user->username;
        $factor->user_update = $this->user->username;
        $factor->created_at = Carbon::now();
        $factor->updated_at = Carbon::now();
        $factor->save();
        
        return ["success"=>true];
    }
    public function postEditarfactor(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'id'=> 'required|exists:factor_expansion_oferta_empleo,id',
            'es_general' =>'required|numeric',
            'es_oferta' =>'required|numeric',
            'proveedor_rnt_id' =>'required_if:es_general,1|exists:proveedores_rnt,id',
            'cantidad' =>'required|numeric',
            'mes_id'=> 'required|exists:meses_de_anio,id',
            'municipio_id'=> 'required|exists:d_municipios_interno,id',
            'tipoProveedor_id'=> 'required|exists:tipo_proveedores,id',
            'tamanioEmpresa_id'=> 'required|exists:d_tamaño_empresa,id',
            
        ],[
            'id.required' => 'Se debe seleccionar un factor.',
            'id.exists' => 'El factor seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'es_general.required' => 'Se debe seleccionar si el factor es general o específico.',
            'es_general.numeric' => 'Inconsistencia en las opciones, favor recargar la página.',
            'es_oferta.required' => 'Se debe seleccionar si el factor es de la sección de oferta o empleo.',
            'es_oferta.numeric' => 'Inconsistencia en las opciones, favor recargar la página.',
            'cantidad.required' => 'El valor del factor de expansión es obligatorio.',
            'cantidad.numeric' => 'El valor solo debe ser numérico.',
            'mes_id.required' => 'El campo mes es requerido.',
            'mes_id.exists' => 'El mes seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'municipio_id.required' => 'El campo municipio es requerido.',
            'municipio_id.exists' => 'El municipio seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'tipoProveedor_id.required' => 'El campo tipo proveedor es requerido.',
            'tipoProveedor_id.exists' => 'El tipo proveedor seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'tamanioEmpresa_id.required' => 'El campo tamaño de la empresa es requerido.',
            'tamanioEmpresa_id.exists' => 'El tamaño de la empresa seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'proveedor_rnt_id.required_if' => 'El campo proveedor rnt es requerido.',
            'proveedor_rnt_id.exists' => 'El proveedor rnt seleccionado no se encuentra en la base de datos, favor recargar la página.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $busqueda = Factor_Expansion_Oferta_Empleo::where('mes_anio_id',$request->mes_id)
        ->where('d_tamanio_empresa_id',$request->tamanioEmpresa_id)
        ->where('tipo_proveedor_id',$request->tipoProveedor_id)
        ->where('d_municipio_interno_id',$request->municipio_id)
        ->where('id','<>',$request->id)->first();
        if($busqueda != null){
            return ["success"=>false,"errores"=>[["Los datos que quiere asignar ya se encuentran registrados en otro factor."]]];
        }
        //return $request->all();
        $factor = Factor_Expansion_Oferta_Empleo::where('id',$request->id)->first();
        $factor->cantidad = $request->cantidad;
        $factor->mes_anio_id = $request->mes_id;
        $factor->d_tamanio_empresa_id = $request->tamanioEmpresa_id;
        $factor->d_municipio_interno_id = $request->municipio_id;
        $factor->tipo_proveedor_id = $request->tipoProveedor_id;
        $factor->proveedor_rnt_id = $request->proveedor_rnt_id;
        $factor->es_oferta = $request->es_oferta;
        $factor->user_update = $this->user->username;
        $factor->updated_at = Carbon::now();
        $factor->save();
        
        return ["success"=>true];
    }
}
