<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @var array
     */
    public $timestamps = false;
    protected $fillable = ['name', 'display_name'];
    protected $table = 'roles';
    public function users(){
       return $this->belongsToMany('App\Models\User');
   }
}