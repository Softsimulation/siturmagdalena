<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicaciones_idioma extends Model
{
    
    protected $table = 'publicaciones_idioma';
    protected $primaryKey = ['publicaciones_id', 'idioma_id'];
    public $incrementing = false;
    public $timestamps = false;
    
    
    public function idioma(){
        return $this->hasOne( "App\Models\Idioma", 'id', 'idioma_id');  
    }
    
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query) {
        if (is_array($this->primaryKey)) {
            foreach ($this->primaryKey as $pk) {
                $query->where($pk, '=', $this->original[$pk]);
            }
            return $query;
        }else{
            return parent::setKeysForSaveQuery($query);
        }
    }
    
}
