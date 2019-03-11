<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use JWTAuth;
use App\Models\Permiso;


class User extends Authenticatable
{
    use EntrustUserTrait;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */                                                                                                                                                                            
    protected $fillable = [
        'nombre', 'email', 'password','username','estado'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($value){
        if( ! empty($value) ){
            $this->attributes['password'] = \Hash::make($value);
        }
    }
    
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
    public function digitador(){
        return $this->hasOne('App\Models\Digitador');
        //return $this->belongsToMany('App\Models\Role');
    }
    public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    }
    
    public function datosAdicionales(){
        return $this->hasOne('App\Models\Datos_Adicional_Usuario','users_id');
        
    }
    public function proveedoresPst(){
        return $this->belongsToMany('App\Models\Proveedores_rnt','proveedor_rnt_user','user_id','proveedor_rnt_id');
    }
    
    public static function resolveUser()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }
    public function contienePermiso($permiso){
        $arrayPermisos = explode("|", $permiso);
        $user = \Auth::user();
        for($i=0;$i<sizeof($user->permissions);$i++){
            for($j=0;$j<sizeof($arrayPermisos);$j++){
                if($user->permissions[$i]->name == $arrayPermisos[$j]){
                    return true;
                }
            }
            
        }
        return false;
    }
}
