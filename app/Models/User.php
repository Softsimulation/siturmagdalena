<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

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
}
