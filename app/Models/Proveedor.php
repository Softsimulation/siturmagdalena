<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\Sitio', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaProveedore()
    {
        return $this->belongsTo('App\Models\Categoria_Proveedor', 'categoria_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categoriaTurismoConProveedores()
    {
        return $this->belongsToMany('App\Models\Categoria_Turismo', 'categoria_turismo_con_proveedores', 'proveedores_id', 'categoria_turismo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentariosProveedores()
    {
        return $this->hasMany('App\Models\Comentario_Proveedor', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfilesUsuariosConProveedores()
    {
        return $this->belongsToMany('App\Models\Perfil_Usuario', 'perfiles_usuarios_con_proveedores', 'proveedores_id', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorProveedores()
    {
        return $this->hasMany('App\Models\PlanificadorProveedore', 'proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresConIdiomas()
    {
        return $this->hasMany('App\Models\Proveedor_Con_Idioma', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\Models\AspNetUser', 'proveedores_favoritos', 'proveedores_id', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresCaracteristicas()
    {
        return $this->hasMany('App\Models\ProveedoresCaracteristica', 'proveedores_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediaProveedores()
    {
        return $this->hasMany('App\Models\Multimedia_Proveedor', 'proveedor_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividadesProveedores()
    {
        return $this->belongsToMany('App\Models\Actividades', 'actividades_proveedores', 'proveedor_id', 'actividad_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedorRnt()
    {
        return $this->belongsTo('App\Models\Proveedores_rnt', 'proveedor_rnt_id');
    }
}
