<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Sitio $sitio
 * @property CategoriaProveedore $categoriaProveedore
 * @property CategoriaTurismoConProveedore[] $categoriaTurismoConProveedores
 * @property ComentariosProveedore[] $comentariosProveedores
 * @property PerfilesUsuariosConProveedore[] $perfilesUsuariosConProveedores
 * @property PlanificadorProveedore[] $planificadorProveedores
 * @property ProveedoresConIdioma[] $proveedoresConIdiomas
 * @property AspNetUser[] $aspNetUsers
 * @property ProveedoresCaracteristica[] $proveedoresCaracteristicas
 * @property int $id
 * @property int $sitios_id
 * @property int $categoria_proveedores_id
 * @property string $telefono
 * @property string $sitio_web
 * @property float $valor_min
 * @property float $valor_max
 * @property float $calificacion_legusto
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property int $contador_visitas
 */
class Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proveedores';

    /**
     * @var array
     */
    protected $fillable = ['sitios_id', 'categoria_proveedores_id', 'telefono', 'sitio_web', 'valor_min', 'valor_max', 'calificacion_legusto', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update', 'contador_visitas'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitio()
    {
        return $this->belongsTo('App\Sitio', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaProveedore()
    {
        return $this->belongsTo('App\CategoriaProveedore', 'categoria_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConProveedores()
    {
        return $this->hasMany('App\CategoriaTurismoConProveedore', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentariosProveedores()
    {
        return $this->hasMany('App\ComentariosProveedore', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConProveedores()
    {
        return $this->hasMany('App\PerfilesUsuariosConProveedore', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorProveedores()
    {
        return $this->hasMany('App\PlanificadorProveedore', 'proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresConIdiomas()
    {
        return $this->hasMany('App\ProveedoresConIdioma', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\AspNetUser', 'proveedores_favoritos', 'proveedores_id', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresCaracteristicas()
    {
        return $this->hasMany('App\ProveedoresCaracteristica', 'proveedores_id');
    }
}
