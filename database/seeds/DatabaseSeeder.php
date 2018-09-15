<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //creando listado de permisos del sistema
        $createuser = Permission::create(['name'=>'create-user', 'display_name' => 'Crear usuario']);
        $readuser = Permission::create(['name' => 'read-user', 'display_name' => 'Ver usuario']);
        $listuser = Permission::create(['name' => 'list-user', 'display_name' => 'Listar usuarios']);
        $edituser = Permission::create(['name' => 'edit-user', 'display_name' => 'Editar usuario']);
        $estadouser = Permission::create(['name' => 'estado-user', 'display_name' => 'Cambiar estado de usuario']);
        $deleteuser = Permission::create(['name' => 'delete-user', 'display_name' => 'Eliminar usuario']);
        
        $createAtraccion = Permission::create(['name'=>'create-atraccion', 'display_name' => 'Crear atracción']);
        $readAtraccion = Permission::create(['name' => 'read-atraccion', 'display_name' => 'Ver atracción']);
        $listAtraccion = Permission::create(['name' => 'list-atraccion', 'display_name' => 'Listar atracciones']);
        $editAtraccion = Permission::create(['name' => 'edit-atraccion', 'display_name' => 'Editar atracción']);
        $estadoAtraccion = Permission::create(['name' => 'estado-atraccion', 'display_name' => 'Cambiar estado de atracción']);
        $deleteAtraccion = Permission::create(['name' => 'delete-atraccion', 'display_name' => 'Eliminar atracción']);
        
        $createActividad = Permission::create(['name'=>'create-actividad', 'display_name' => 'Crear actividad']);
        $readActividad = Permission::create(['name' => 'read-actividad', 'display_name' => 'Ver actividad']);
        $listActividad = Permission::create(['name' => 'list-actividad', 'display_name' => 'Listar actividades']);
        $editActividad = Permission::create(['name' => 'edit-actividad', 'display_name' => 'Editar actividad']);
        $estadoActividad = Permission::create(['name' => 'estado-actividad', 'display_name' => 'Cambiar estado de actividad']);
        $deleteActividad = Permission::create(['name' => 'delete-actividad', 'display_name' => 'Eliminar actividad']);
        
        $createProveedor = Permission::create(['name'=>'create-proveedor', 'display_name' => 'Crear proveedor']);
        $readProveedor = Permission::create(['name' => 'read-proveedor', 'display_name' => 'Ver proveedor']);
        $listProveedor = Permission::create(['name' => 'list-proveedor', 'display_name' => 'Listar proveedores']);
        $editProveedor = Permission::create(['name' => 'edit-proveedor', 'display_name' => 'Editar proveedor']);
        $estadoProveedor = Permission::create(['name' => 'estado-proveedor', 'display_name' => 'Cambiar estado de proveedor']);
        $deleteProveedor = Permission::create(['name' => 'delete-proveedor', 'display_name' => 'Eliminar proveedor']);
        
        $createEvento = Permission::create(['name'=>'create-evento', 'display_name' => 'Crear evento']);
        $readEvento = Permission::create(['name' => 'read-evento', 'display_name' => 'Ver evento']);
        $listEvento = Permission::create(['name' => 'list-evento', 'display_name' => 'Listar eventos']);
        $editEvento = Permission::create(['name' => 'edit-evento', 'display_name' => 'Editar evento']);
        $estadoEvento = Permission::create(['name' => 'estado-evento', 'display_name' => 'Cambiar estado de evento']);
        $deleteEvento = Permission::create(['name' => 'delete-evento', 'display_name' => 'Eliminar evento']);
        
        $createDestino = Permission::create(['name'=>'create-destino', 'display_name' => 'Crear destino']);
        $readDestino = Permission::create(['name' => 'read-destino', 'display_name' => 'Ver destino']);
        $listDestino = Permission::create(['name' => 'list-destino', 'display_name' => 'Listar destinos']);
        $editDestino = Permission::create(['name' => 'edit-destino', 'display_name' => 'Editar destino']);
        $estadoDestino = Permission::create(['name' => 'estado-destino', 'display_name' => 'Cambiar estado de destino']);
        $deleteDestino = Permission::create(['name' => 'delete-destino', 'display_name' => 'Eliminar destino']);
        
        $createRuta = Permission::create(['name'=>'create-ruta', 'display_name' => 'Crear ruta turística']);
        $readRuta = Permission::create(['name' => 'read-ruta', 'display_name' => 'Ver ruta turística']);
        $listRuta = Permission::create(['name' => 'list-ruta', 'display_name' => 'Listar rutas turísticas']);
        $editRuta = Permission::create(['name' => 'edit-ruta', 'display_name' => 'Editar ruta turística']);
        $estadoRuta = Permission::create(['name' => 'estado-ruta', 'display_name' => 'Cambiar estado de ruta turística']);
        $deleteRuta = Permission::create(['name' => 'delete-ruta', 'display_name' => 'Eliminar ruta turística']);
        
        $createEncuestaReceptor = Permission::create(['name'=>'create-encuestaReceptor', 'display_name' => 'Crear encuesta receptor']);
        $readEncuestaReceptor = Permission::create(['name' => 'read-encuestaReceptor', 'display_name' => 'Ver encuesta receptor']);
        $listEncuestaReceptor = Permission::create(['name' => 'list-encuestaReceptor', 'display_name' => 'Listar encuestas receptor']);
        $editEncuestaReceptor = Permission::create(['name' => 'edit-encuestaReceptor', 'display_name' => 'Editar encuesta receptor']);
        $deleteEncuestaReceptor = Permission::create(['name' => 'delete-encuestaReceptor', 'display_name' => 'Eliminar encuesta receptor']);
        
        $createGrupoViaje = Permission::create(['name'=>'create-grupoViaje', 'display_name' => 'Crear grupo de viaje']);
        $readGrupoViaje = Permission::create(['name' => 'read-grupoViaje', 'display_name' => 'Ver grupo de viaje']);
        $listGrupoViaje = Permission::create(['name' => 'list-grupoViaje', 'display_name' => 'Listar grupos de viajes']);
        $editGrupoViaje = Permission::create(['name' => 'edit-grupoViaje', 'display_name' => 'Editar grupo de viaje']);
        $deleteGrupoViaje = Permission::create(['name' => 'delete-grupoViaje', 'display_name' => 'Eliminar grupo de viaje']);
        
        
        
        $createEncuestaOferta = Permission::create(['name'=>'create-encuestaOfertaEmpleo', 'display_name' => 'Crear encuesta oferta y empleo']);
        $readEncuestaOferta = Permission::create(['name' => 'read-encuestaOfertaEmpleo', 'display_name' => 'Ver encuesta oferta y empleo']);
        $listEncuestaOferta = Permission::create(['name' => 'list-encuestaOfertaEmpleo', 'display_name' => 'Listar encuestas oferta y empleo']);
        $editEncuestaOferta = Permission::create(['name' => 'edit-encuestaOfertaEmpleo', 'display_name' => 'Editar encuesta oferta y empleo']);
        $deleteEncuestaOferta = Permission::create(['name' => 'delete-encuestaOfertaEmpleo', 'display_name' => 'Eliminar encuesta oferta y empleo']);
        
        $createTemporada = Permission::create(['name'=>'create-temporada', 'display_name' => 'Crear temporada']);
        $readTemporada = Permission::create(['name' => 'read-temporada', 'display_name' => 'Ver temporada']);
        $listTemporada = Permission::create(['name' => 'list-temporada', 'display_name' => 'Listar temporadas']);
        $editTemporada = Permission::create(['name' => 'edit-temporada', 'display_name' => 'Editar temporada']);
        $estadoTemporada = Permission::create(['name' => 'estado-temporada', 'display_name' => 'Cambiar estado de temporada']);
        $deleteTemporada = Permission::create(['name' => 'delete-temporada', 'display_name' => 'Eliminar temporada']);
        
        $createPoblacionDane = Permission::create(['name'=>'create-poblacionDane', 'display_name' => 'Crear población DANE']);
        $readPoblacionDane = Permission::create(['name' => 'read-poblacionDane', 'display_name' => 'Ver población DANE']);
        $listPoblacionDane = Permission::create(['name' => 'list-poblacionDane', 'display_name' => 'Listar población DANE']);
        $editPoblacionDane = Permission::create(['name' => 'edit-poblacionDane', 'display_name' => 'Editar población DANE']);
        
        $createMedicion = Permission::create(['name'=>'create-medicion', 'display_name' => 'Crear medicion']);
        $readMedicion = Permission::create(['name' => 'read-medicion', 'display_name' => 'Ver medicion']);
        $listMedicion = Permission::create(['name' => 'list-medicion', 'display_name' => 'Listar mediciones']);
        $editMedicion = Permission::create(['name' => 'edit-medicion', 'display_name' => 'Editar medicion']);
        $estadoMedicion = Permission::create(['name' => 'estado-medicion', 'display_name' => 'Cambiar estado de medicion']);
        $deleteMedicion = Permission::create(['name' => 'delete-medicion', 'display_name' => 'Eliminar medicion']);
        
        $createPrestador = Permission::create(['name'=>'create-prestador', 'display_name' => 'Crear prestador']);
        $readPrestador = Permission::create(['name' => 'read-prestador', 'display_name' => 'Ver prestador']);
        $listPrestador = Permission::create(['name' => 'list-prestador', 'display_name' => 'Listar prestadores']);
        $editPrestador = Permission::create(['name' => 'edit-prestador', 'display_name' => 'Editar medicion']);
        $estadoPrestador = Permission::create(['name' => 'estado-prestador', 'display_name' => 'Cambiar estado de prestador']);
        $deletePrestador = Permission::create(['name' => 'delete-prestador', 'display_name' => 'Eliminar prestador']);
        
        $createBloque = Permission::create(['name'=>'create-bloque', 'display_name' => 'Crear bloque']);
        $readBloque  = Permission::create(['name' => 'read-bloque', 'display_name' => 'Ver bloque']);
        $listBloque  = Permission::create(['name' => 'list-bloque', 'display_name' => 'Listar bloques']);
        $editBloque  = Permission::create(['name' => 'edit-bloque', 'display_name' => 'Editar bloque']);
        $estadoBloque  = Permission::create(['name' => 'estado-bloque', 'display_name' => 'Cambiar estado de bloque']);
        $deleteBloque  = Permission::create(['name' => 'delete-bloque', 'display_name' => 'Eliminar bloque']);
        
        $createEstadisticaSecundariaADHOC = Permission::create(['name'=>'create-estadisticaSecundariaADHOC', 'display_name' => 'Crear estadística secundaria']);
        $readEstadisticaSecundariaADHOC  = Permission::create(['name' => 'read-estadisticaSecundariaADHOC', 'display_name' => 'Ver estadística secundaria']);
        $listEstadisticaSecundariaADHOC  = Permission::create(['name' => 'list-estadisticaSecundariaADHOC', 'display_name' => 'Listar estadísticas secundarias']);
        $editEstadisticaSecundariaADHOC  = Permission::create(['name' => 'edit-estadisticaSecundariaADHOC', 'display_name' => 'Editar estadística secundaria']);
        $estadoEstadisticaSecundariaADHOC  = Permission::create(['name' => 'estado-estadisticaSecundariaADHOC', 'display_name' => 'Cambiar estado de estadística secundaria']);
        $deleteEstadisticaSecundariaADHOC  = Permission::create(['name' => 'delete-estadisticaSecundariaADHOC', 'display_name' => 'Eliminar estadística secundaria']);
        
        $createEncuestaADHOC = Permission::create(['name'=>'create-encuestaOfertaADHOC', 'display_name' => 'Crear encuesta ADHOC']);
        $readEncuestaADHOC = Permission::create(['name' => 'read-encuestaOfertaADHOC', 'display_name' => 'Ver encuesta ADHOC']);
        $listEncuestaADHOC = Permission::create(['name' => 'list-encuestaOfertaADHOC', 'display_name' => 'Listar encuestas ADHOC']);
        $editEncuestaADHOC = Permission::create(['name' => 'edit-encuestaOfertaADHOC', 'display_name' => 'Editar encuesta ADHOC']);
        $deleteEncuestaADHOC = Permission::create(['name' => 'delete-encuestaOfertaADHOC', 'display_name' => 'Eliminar encuesta ADHOC']);

        $listExportacionesReceptor = Permission::create(['name' => 'list-exportacionesReceptor', 'display_name' => 'Listar exportaciones de mediciones de receptor']);
        $exportarMedicionReceptor = Permission::create(['name' => 'export-medicionReceptor', 'display_name' => 'Exportar medición receptor']);
        
        $listExportacionesOferta = Permission::create(['name' => 'list-exportacionesOferta', 'display_name' => 'Listar exportaciones de mediciones de oferta y empleo']);
        $exportarMedicionOferta = Permission::create(['name' => 'export-medicionOferta', 'display_name' => 'Exportar medición oferta y empleo']);
        
        $listExportacionesInternoEmisor = Permission::create(['name' => 'list-exportacionesInternoEmisor', 'display_name' => 'Listar exportaciones de mediciones de interno y emisor']);
        $exportarMedicionInternoEmisor = Permission::create(['name' => 'export-medicionInternoEmisor', 'display_name' => 'Exportar medición de interno y emisor']);
        
        $listExportacionesMuestraMaestra = Permission::create(['name' => 'list-exportacionesMuestraMaestra', 'display_name' => 'Listar exportaciones de mediciones de muestra maestra']);
        $exportarMedicionMuestraMaestra = Permission::create(['name' => 'export-medicionMuestraMaestra', 'display_name' => 'Exportar medición de muestra maestra']);
        
        $listImportacionesRNT = Permission::create(['name' => 'list-importacionesRNT', 'display_name' => 'Listar RNT']);
        $importarRNT = Permission::create(['name' => 'import-RNT', 'display_name' => 'Importar RNT']);
        $deleteRNT = Permission::create(['name' => 'delete-RNT', 'display_name' => 'Eliminar encuesta RNT']);
        
        $createInforme= Permission::create(['name'=>'create-informe', 'display_name' => 'Crear informe']);
        $readInforme  = Permission::create(['name' => 'read-informe', 'display_name' => 'Ver informe']);
        $listInforme  = Permission::create(['name' => 'list-informe', 'display_name' => 'Listar informes']);
        $editInforme  = Permission::create(['name' => 'edit-informe', 'display_name' => 'Editar informe']);
        $estadoInforme  = Permission::create(['name' => 'estado-informe', 'display_name' => 'Cambiar estado de informe']);
        $deleteInforme  = Permission::create(['name' => 'delete-informe', 'display_name' => 'Eliminar informe']);
        
        $createNoticia= Permission::create(['name'=>'create-noticia', 'display_name' => 'Crear noticia']);
        $readNoticia  = Permission::create(['name' => 'read-noticia', 'display_name' => 'Ver noticia']);
        $listNoticia  = Permission::create(['name' => 'list-noticia', 'display_name' => 'Listar noticias']);
        $editNoticia  = Permission::create(['name' => 'edit-noticia', 'display_name' => 'Editar noticia']);
        $estadoNoticia  = Permission::create(['name' => 'estado-noticia', 'display_name' => 'Cambiar estado de noticia']);
        $deleteNoticia  = Permission::create(['name' => 'delete-noticia', 'display_name' => 'Eliminar noticia']);
        
        $createPais= Permission::create(['name'=>'create-pais', 'display_name' => 'Crear pais']);
        $readPais  = Permission::create(['name' => 'read-pais', 'display_name' => 'Ver pais']);
        $listPais  = Permission::create(['name' => 'list-pais', 'display_name' => 'Listar paises']);
        $editPais  = Permission::create(['name' => 'edit-pais', 'display_name' => 'Editar pais']);
        $deletePais  = Permission::create(['name' => 'delete-pais', 'display_name' => 'Eliminar pais']);
        
        $createDepartamento= Permission::create(['name'=>'create-departamento', 'display_name' => 'Crear departamento']);
        $readDepartamento = Permission::create(['name' => 'read-departamento', 'display_name' => 'Ver departamento']);
        $listDepartamento  = Permission::create(['name' => 'list-departamento', 'display_name' => 'Listar departamentos']);
        $editDepartamento  = Permission::create(['name' => 'edit-departamento', 'display_name' => 'Editar departamento']);
        $deleteDepartamento  = Permission::create(['name' => 'delete-departamento', 'display_name' => 'Eliminar departamento']);
        
        $createMunicipio= Permission::create(['name'=>'create-municipio', 'display_name' => 'Crear municipio']);
        $readMunicipio = Permission::create(['name' => 'read-municipio', 'display_name' => 'Ver municipio']);
        $listMunicipio  = Permission::create(['name' => 'list-municipio', 'display_name' => 'Listar municipios']);
        $editMunicipio  = Permission::create(['name' => 'edit-municipio', 'display_name' => 'Editar municipio']);
        $deleteMunicipio  = Permission::create(['name' => 'delete-municipio', 'display_name' => 'Eliminar municipio']);
        
    }
}
