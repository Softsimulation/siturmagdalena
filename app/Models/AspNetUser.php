<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspNetUser extends Model
{
    protected $table = 'users';
    
    protected $fillable = ['id	', 'email', 'username'];
    
    protected $primaryKey = 'id';
    
    public function lugaresFavoritos()
    {
        return $this->hasMany('App\Model\Lugar_Favorito', 'usuario_id');
    }
}
