<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;
use App\Models\Permission;
use App\Models\Proveedores_rnt;
use App\Models\Digitador;

class UsuarioController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        $this->middleware('role:Admin');
        /*$this->middleware('permissions:list-usuario|create-usuario|read-usuario|edit-usuario|estado-usuario|delete-usuario',['only' => ['getListadousuarios','getUsuarios','getDatosasignarpermisos'] ]);
        $this->middleware('permissions:create-usuario|edit-usuario',['only' => ['getInformacionguardar'] ]);
        $this->middleware('permissions:create-usuario',['only' => ['postGuardarusuario'] ]);
        $this->middleware('permissions:edit-usuario|read-usuario',['only' => ['getEditar','getInformacioneditar'] ]);
        $this->middleware('permissions:edit-usuario',['only' => ['postEditarusuario'] ]);
        $this->middleware('permissions:estado-usuario',['only' => ['postCambiarestado'] ]);
        $this->middleware('permissions:asignar-permiso',['only' => ['postAsignacionpermisos'] ]);*/
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
    public function getAsignarpermisos($id){
        return view('usuario.AsignarPermisos',array('id' => $id));
    }
    public function getUsuarios(){
        
        $usuarios = User::with(['roles','permissions'=>function($q){
            $q->select('id');
        }])->get();
        $roles = Role::all();
        
        $permisos = Permission::all();
        return ['usuarios'=>$usuarios,'roles'=>$roles, 'permisos'=>$permisos];
    }
    public function getInformacionguardar(){
        
        $roles = Role::all();
        $proveedores = Proveedores_rnt::where('estado',1)->get();
        return ['roles'=>$roles,'proveedoresRNT'=>$proveedores];
    }
    public function getInformacioneditar($id){
        
        $roles = Role::all();
        $user = User::where('id',$id)->with(['roles','proveedoresPst'])->first();
        
        $roles_retornar = [];
        $proveedoresRetornar = [];
        foreach($user->roles as $rol){
            array_push($roles_retornar,$rol->id);
        }
        foreach($user->proveedoresPst as $proveedor){
            array_push($proveedoresRetornar,$proveedor->id);
        }
        $userRetornar = [];
        
        $userRetornar["id"] = $user->id;
        $userRetornar["nombres"] = $user->nombre;
        $userRetornar["email"] = $user->email;
        $userRetornar["rol"] = $roles_retornar;
        $userRetornar["proveedoresRNT"] = $proveedoresRetornar;
        
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
            if($rolSeleccionado == 3){
                if(sizeof($request->proveedoresRNT) == 0){
                    $errores["proveedores"][0] = "Si selecciona el rol PST, debe por lo menos escoger un proveedor.";
                }else{
                    foreach($request->proveedoresRNT as $proveedor){
                        if(Proveedores_rnt::where('id',$proveedor)->first() == null){
                            $errores["listaProveedore"][0] = "Uno de los proveedores seleccionados no se encuentran registrados en el sistema, favor recargar la página.";
                        }
                    }
                }
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
            if($rol == 2){
                $digitador = new Digitador();
                $digitador->user_id = $user->id;
            }
        }
        foreach($request->proveedoresRNT as $proveedor){
            $user->proveedoresPst()->attach($proveedor);
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
            if($rolSeleccionado == 3){
                if(sizeof($request->proveedoresRNT) == 0){
                    $errores["proveedores"][0] = "Si selecciona el rol PST, debe por lo menos escoger un proveedor.";
                }else{
                    foreach($request->proveedoresRNT as $proveedor){
                        if(Proveedores_rnt::where('id',$proveedor)->first() == null){
                            $errores["listaProveedore"][0] = "Uno de los proveedores seleccionados no se encuentran registrados en el sistema, favor recargar la página.";
                        }
                    }
                }
            }
        }
        
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        $user->roles()->detach();
        $user->proveedoresPst()->detach();
        foreach($request->rol as $rol){
            $user->roles()->attach($rol);
            if($rol == 2){
                $digitador = Digitador::where('user_id',$user->id)->first();
                if($digitador == null){
                    $digitador = new Digitador();
                }
                $digitador->user_id = $user->id;
            }
        }
        foreach($request->proveedoresRNT as $proveedor){
            $user->proveedoresPst()->attach($proveedor);
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
    public function getDatosasignarpermisos(){
        
        $usuarios = User::with('roles')->get();
        $permisos = Permission::all();
        return ['usuarios'=>$usuarios,'permisos'=>$permisos];
    }
    public function postAsignacionpermisos(Request $request){
        
        $validator = \Validator::make($request->all(),[
        
            'idUsuario' => 'required|exists:users,id',
            //'permisos' => 'required',
            
            
        ],[
            'idUsuario.required' => 'El usuario es requerido.',
            'idUsuario.exists' => 'El usuario seleccionado no se encuentra en registrado en el sistema.',
            //'permisos.required' => 'Es necesario haber seleccionar por lo menos un permiso.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $errores = [];
        $idsPermisos = [];
        if(sizeof($request->permisos) > 0){
            foreach($request->permisos as $permisoSeleccionado){
                $auxPermiso = Permission::where('name',$permisoSeleccionado)->first();
                
                if($auxPermiso == null){
                    return $permisoSeleccionado;
                    $errores["permission"][0] = "Uno de los permisos seleccionados no se encuentran registrados en el sistema";
                }else{
                    if (!in_array($auxPermiso->id, $idsPermisos)) {
                        array_push($idsPermisos, $auxPermiso->id);
                    }
                    
                }
            }
        }
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        $user = User::where('id',$request->idUsuario)->first();
        $user->permissions()->detach();
        
        if(sizeof($idsPermisos) > 0){
            foreach($idsPermisos as $permiso){
                $user->permissions()->attach($permiso);
            }
        }
        
        return ['success'=> true];
        
    }
    public function getPermisosusuario($id){
        //return $id;
        $usuario = User::where('id',$id)->with(['permissions'=>function($q){
            $q->select('permissions.name');
        }])->first();
        //return $usuario->permissions;
        $permisos = [];
        for($i=0;$i<sizeof($usuario->permissions);$i++){
            array_push($permisos, $usuario->permissions[$i]->name);
        }
        return ['permisos'=>$permisos];
    }
    public function getArreglo(){
        $permiso = Permission::where('id',267)->first();
        $permiso->name = "edit-estadisticaSecundaria";
        $permiso->save();
        return $permiso;
    }
}
