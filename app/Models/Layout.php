<?php
use App\Models\Evento_Favorita;
use App\Models\Atraccion_Favorita;
use App\Models\Proveedor_Favorito;
use App\Models\Actividad_Favorita;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MesesDeAño[] $mesesDeAños
 * @property int $id
 * @property string $nombre
 */
class Layout extends Model{
    static function favoritos(){
        $user = \Auth::user();
        if($user != null && \Auth::check()){
            $atraccionesFavoritas = Atraccion_Favorita::where('usuario_id', $user->id)->count();
            $actividadesFavoritas = Actividad_Favorita::where('usuario_id', $user->id)->count();
            $proveedoresFavoritos = Proveedor_Favorito::where('usuario_id', $user->id)->count();
            $eventosFavoritos = Evento_Favorita::where('usuario_id', $user->id)->count();
            $totalFavoritos = $atraccionesFavoritas + $actividadesFavoritas + $proveedoresFavoritos + $eventosFavoritos;
            return $totalFavoritos;
	    }
        return 0;
    }
}