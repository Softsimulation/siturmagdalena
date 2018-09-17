<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * @var array
     */
    public $timestamps = false;
    protected $fillable = ['name', 'display_name','description'];
    protected $table = 'permissions';
    public function users(){
       return $this->belongsToMany('App\Models\User');
   }
}