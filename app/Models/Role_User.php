<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{
    /**
     * @var array
     */
    public $timestamps = false;
    protected $fillable = ['user_id', 'role_id'];
    protected $table = 'role_user';
    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }
    public function users(){
       return $this->belongsToMany('App\Models\User');
   }
}