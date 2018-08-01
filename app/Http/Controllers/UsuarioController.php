<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
    public function getListadousuarios(){
        //return $this->user;
        return view('usuario.Listado');
    }
    public function getGuardar(){
        return view('usuario.Guardar');
    }
    public function getEditar($id){
        return view('usuario.Editar',array('id' => $id));
    }
    public function getUsuarios(){
        
        $usuarios = User::with('roles')->get();
        $roles = Role::all();
        return ['usuarios'=>$usuarios,'roles'=>$roles];
    }
    public function getInformacionguardar(){
        
        $roles = Role::all();
        
        return ['roles'=>$roles];
    }
    public function getInformacioneditar($id){
        
        $roles = Role::all();
        $user = User::where('id',$id)->with(['roles'])->first();
        $roles_retornar = [];
        foreach($user->roles as $rol){
            array_push($roles_retornar,$rol->id);
        }
        $userRetornar = [];
        
        $userRetornar["id"] = $user->id;
        $userRetornar["nombres"] = $user->nombre;
        $userRetornar["email"] = $user->email;
        $userRetornar["rol"] = $roles_retornar;
        
        return ['roles'=>$roles, 'usuario'=>$userRetornar];
    }
    public function postGuardarusuario(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'nombres' => 'string|min:1|max:255|required',
            'rol' => 'required',
            'email' => 'required',
            'password1' => 'required',
            'password2' =>'required',
            
        ],[
            'nombres.string' => 'El nombre debe ser de tipo string.',
            'nombres.min' => 'El nombre debe ser mínimo de 1 caracter.',
            'nombres.max' => 'El nombre debe ser maximo de 255 caracteres.',
            'nombres.required' => 'El nombre es requerido.',
            'rol.required' => 'Es necesario haber seleccionar por lo menos un rol.',
            'email.required' => 'El email es requerido.',
            'password1.required' => 'La contraseña es requerida.',
            'password2.required' => 'La confirmación de la contraseña es requerida.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $errores = [];
        if(User::where('email',$request->email)->count() > 0){ 
            $errores["Email"][0] = "El email ingresado ya se encuentra registrado en el sistema";
        }
        if($request->password1 != $request->password2){ 
            $errores["password"][0] = "Las contraseñas no coinciden";
        }
        foreach($request->rol as $rolSeleccionado){
            if(Role::where('id',$rolSeleccionado)->first() == null){
                $errores["rol"][0] = "Uno de los roles seleccionados no se encuentran registrados en el sistema";
            }
        }
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        $user = new User();
        $user->username = $request->email;
        $user->nombre = $request->nombres;
        $user->password = $request->password1;
        $user->email = $request->email;
        $user->estado = 1;
        $user->save();
        
        foreach($request->rol as $rol){
            $user->roles()->attach($rol);
        }
        return ['success'=> true];
    }
    public function postEditarusuario(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:users,id',
            'nombres' => 'string|min:1|max:255|required',
            'rol' => 'required',
            'email' => 'required',
            
        ],[
            'id.required' => 'El usuario es requerido.',
            'id.exists' => 'El usuario seleccionado no se encuentra en registrado en el sistema.',
            'nombres.string' => 'El nombre debe ser de tipo string.',
            'nombres.min' => 'El nombre debe ser mínimo de 1 caracter.',
            'nombres.max' => 'El nombre debe ser maximo de 255 caracteres.',
            'nombres.required' => 'El nombre es requerido.',
            'rol.required' => 'Es necesario haber seleccionar por lo menos un rol.',
            'email.required' => 'El email es requerido.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        $errores = [];
        $user = User::where('id',$request->id)->first();
        if($user->email != $request->email && User::where('email',$request->email)->count() > 0){
            $errores["Email"][0] = "El email ingresado ya se encuentra registrado en el sistema";    
            
        }
        if($request->password1 != $request->password2){
            $errores["password"][0] = "Las contraseñas no coinciden";
        }
        
        foreach($request->rol as $rolSeleccionado){
            if(Role::where('id',$rolSeleccionado)->first() == null){
                $errores["rol"][0] = "Uno de los roles seleccionados no se encuentran registrados en el sistema";
            }
        }
        
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        $user->roles()->detach();
        foreach($request->rol as $rol){
            $user->roles()->attach($rol);
        }
        $user->nombre = $request->nombres;
        $user->username = $request->email;
        $user->email = $request->email;
        $user->password = $request->password1;
        $user->save();
        
        return ['success'=> true];
    }
    public function postCambiarestado(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:users,id',
            
        ],[
            'id.required' => 'El usuario es requerido.',
            'id.exists' => 'El usuario seleccionado no se encuentra en registrado en el sistema.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        $user = User::where('id',$request->id)->first();
        
        $user->estado = !$user->estado;
        $user->save();
        return ['success'=> true];
    }
}
