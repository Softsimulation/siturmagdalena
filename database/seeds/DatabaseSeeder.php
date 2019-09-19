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
        $sugerirAtraccion = Permission::create(['name' => 'sugerir-atraccion', 'display_name' => 'Sugerir atracción']);
        
        $createActividad = Permission::create(['name'=>'create-actividad', 'display_name' => 'Crear actividad']);
        $readActividad = Permission::create(['name' => 'read-actividad', 'display_name' => 'Ver actividad']);
        $listActividad = Permission::create(['name' => 'list-actividad', 'display_name' => 'Listar actividades']);
        $editActividad = Permission::create(['name' => 'edit-actividad', 'display_name' => 'Editar actividad']);
        $estadoActividad = Permission::create(['name' => 'estado-actividad', 'display_name' => 'Cambiar estado de actividad']);
        $deleteActividad = Permission::create(['name' => 'delete-actividad', 'display_name' => 'Eliminar actividad']);
        $sugerirActividad = Permission::create(['name' => 'sugerir-actividad', 'display_name' => 'Sugerir actividad']);
        
        $createDestino = Permission::create(['name'=>'create-destino', 'display_name' => 'Crear destino']);
        $readDestino = Permission::create(['name' => 'read-destino', 'display_name' => 'Ver destino']);
        $listDestino = Permission::create(['name' => 'list-destino', 'display_name' => 'Listar destinos']);
        $editDestino = Permission::create(['name' => 'edit-destino', 'display_name' => 'Editar destino']);
        $estadoDestino = Permission::create(['name' => 'estado-destino', 'display_name' => 'Cambiar estado de destino']);
        $deleteDestino = Permission::create(['name' => 'delete-destino', 'display_name' => 'Eliminar destino']);
        $sugerirDestino = Permission::create(['name' => 'sugerir-destino', 'display_name' => 'Sugerir destino']);
        
        $createEvento = Permission::create(['name'=>'create-evento', 'display_name' => 'Crear evento']);
        $readEvento = Permission::create(['name' => 'read-evento', 'display_name' => 'Ver evento']);
        $listEvento = Permission::create(['name' => 'list-evento', 'display_name' => 'Listar eventos']);
        $editEvento = Permission::create(['name' => 'edit-evento', 'display_name' => 'Editar evento']);
        $estadoEvento = Permission::create(['name' => 'estado-evento', 'display_name' => 'Cambiar estado de evento']);
        $deleteEvento = Permission::create(['name' => 'delete-evento', 'display_name' => 'Eliminar evento']);
        $sugerirEvento = Permission::create(['name' => 'sugerir-evento', 'display_name' => 'Sugerir evento']);
        
        $createRuta = Permission::create(['name'=>'create-ruta', 'display_name' => 'Crear ruta turística']);
        $readRuta = Permission::create(['name' => 'read-ruta', 'display_name' => 'Ver ruta turística']);
        $listRuta = Permission::create(['name' => 'list-ruta', 'display_name' => 'Listar rutas turísticas']);
        $editRuta = Permission::create(['name' => 'edit-ruta', 'display_name' => 'Editar ruta turística']);
        $estadoRuta = Permission::create(['name' => 'estado-ruta', 'display_name' => 'Cambiar estado de ruta turística']);
        $deleteRuta = Permission::create(['name' => 'delete-ruta', 'display_name' => 'Eliminar ruta turística']);
        $sugerirRuta = Permission::create(['name' => 'sugerir-ruta', 'display_name' => 'Sugerir ruta']);
        
        $createProveedor = Permission::create(['name'=>'create-proveedor', 'display_name' => 'Crear proveedor']);
        $readProveedor = Permission::create(['name' => 'read-proveedor', 'display_name' => 'Ver proveedor']);
        $listProveedor = Permission::create(['name' => 'list-proveedor', 'display_name' => 'Listar proveedores']);
        $editProveedor = Permission::create(['name' => 'edit-proveedor', 'display_name' => 'Editar proveedor']);
        $estadoProveedor = Permission::create(['name' => 'estado-proveedor', 'display_name' => 'Cambiar estado de proveedor']);
        $deleteProveedor = Permission::create(['name' => 'delete-proveedor', 'display_name' => 'Eliminar proveedor']);
        $sugerirProveedor = Permission::create(['name' => 'sugerir-proveedor', 'display_name' => 'Sugerir proveedor']);
        
        $createDepartamento= Permission::create(['name'=>'create-departamento', 'display_name' => 'Crear departamento']);
        $readDepartamento = Permission::create(['name' => 'read-departamento', 'display_name' => 'Ver departamento']);
        $listDepartamento  = Permission::create(['name' => 'list-departamento', 'display_name' => 'Listar departamentos']);
        $editDepartamento  = Permission::create(['name' => 'edit-departamento', 'display_name' => 'Editar departamento']);
        $deleteDepartamento  = Permission::create(['name' => 'delete-departamento', 'display_name' => 'Eliminar departamento']);
        $importarDepartamento  = Permission::create(['name' => 'importar-departamento', 'display_name' => 'Importar departamentos']);
        
        $createMunicipio= Permission::create(['name'=>'create-municipio', 'display_name' => 'Crear municipio']);
        $readMunicipio = Permission::create(['name' => 'read-municipio', 'display_name' => 'Ver municipio']);
        $listMunicipio  = Permission::create(['name' => 'list-municipio', 'display_name' => 'Listar municipios']);
        $editMunicipio  = Permission::create(['name' => 'edit-municipio', 'display_name' => 'Editar municipio']);
        $deleteMunicipio  = Permission::create(['name' => 'delete-municipio', 'display_name' => 'Eliminar municipio']);
        $importarMunicipio  = Permission::create(['name' => 'importar-municipio', 'display_name' => 'Importar municipios']);
        
        $createPais= Permission::create(['name'=>'create-pais', 'display_name' => 'Crear pais']);
        $readPais  = Permission::create(['name' => 'read-pais', 'display_name' => 'Ver pais']);
        $listPais  = Permission::create(['name' => 'list-pais', 'display_name' => 'Listar paises']);
        $editPais  = Permission::create(['name' => 'edit-pais', 'display_name' => 'Editar pais']);
        $deletePais  = Permission::create(['name' => 'delete-pais', 'display_name' => 'Eliminar pais']);
        $importarPais  = Permission::create(['name' => 'importar-pais', 'display_name' => 'Importar pais']);
        
        $acercaDepartamento  = Permission::create(['name' => 'acerca-departamento', 'display_name' => 'Configuración acerca del departamento']);
        $requisitosViaje  = Permission::create(['name' => 'requisitos-viaje', 'display_name' => 'Configuración requisitos de viaje']);
        
        $createSlider= Permission::create(['name'=>'create-slider', 'display_name' => 'Crear slider']);
        $readSlider  = Permission::create(['name' => 'read-slider', 'display_name' => 'Ver slider']);
        $listSlider  = Permission::create(['name' => 'list-slider', 'display_name' => 'Listar sliders']);
        $editSlider  = Permission::create(['name' => 'edit-slider', 'display_name' => 'Editar slider']);
        $estadoSlider  = Permission::create(['name' => 'estado-slider', 'display_name' => 'Cambiar estado de slider']);
        $prioridadSlider  = Permission::create(['name' => 'prioridad-slider', 'display_name' => 'Cambiar prioridad de slider']);
        $deleteSlider  = Permission::create(['name' => 'delete-slider', 'display_name' => 'Eliminar slider']);
        
        $createNoticia= Permission::create(['name'=>'create-noticia', 'display_name' => 'Crear noticia']);
        $readNoticia  = Permission::create(['name' => 'read-noticia', 'display_name' => 'Ver noticia']);
        $listNoticia  = Permission::create(['name' => 'list-noticia', 'display_name' => 'Listar noticias']);
        $editNoticia  = Permission::create(['name' => 'edit-noticia', 'display_name' => 'Editar noticia']);
        $estadoNoticia  = Permission::create(['name' => 'estado-noticia', 'display_name' => 'Cambiar estado de noticia']);
        $deleteNoticia  = Permission::create(['name' => 'delete-noticia', 'display_name' => 'Eliminar noticia']);
        
        $createPublicacion= Permission::create(['name'=>'create-publicaciones', 'display_name' => 'Crear publicación']);
        $readPublicacion  = Permission::create(['name' => 'read-publicaciones', 'display_name' => 'Ver publicación']);
        $listPublicacion  = Permission::create(['name' => 'list-publicaciones', 'display_name' => 'Listar publicaciones']);
        $editPublicacion  = Permission::create(['name' => 'edit-publicaciones', 'display_name' => 'Editar publicación']);
        $estadoPublicacion  = Permission::create(['name' => 'estado-publicaciones', 'display_name' => 'Cambiar estado de publicación']);
        $deletePublicacion  = Permission::create(['name' => 'delete-publicaciones', 'display_name' => 'Eliminar publicación']);
        
        $exportarMedicionReceptor = Permission::create(['name' => 'export-medicionReceptor', 'display_name' => 'Exportar medición receptor']);
        $exportarMedicionOferta = Permission::create(['name' => 'export-medicionOferta', 'display_name' => 'Exportar medición oferta y empleo']);
        $exportarMedicionInternoEmisor = Permission::create(['name' => 'export-medicionInternoEmisor', 'display_name' => 'Exportar medición de interno y emisor']);
        $exportarMedicionSostHogar = Permission::create(['name' => 'export-sostenibilidadHogar', 'display_name' => 'Exportar medición de sostenibilidad hogar']);
        $exportarMedicionSostPST = Permission::create(['name' => 'export-sostenibilidadPST', 'display_name' => 'Exportar medición de sostenibilidad PST']);
        
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
        
        $createInternoEmisor = Permission::create(['name' => 'create-encuestaInterno', 'display_name' => 'Crear encuesta interno']);
        $editInternoEmisor = Permission::create(['name' => 'read-encuestaInterno', 'display_name' => 'Ver encuesta interno']);
        $deleteInternoEmisor = Permission::create(['name' => 'edit-encuestaInterno', 'display_name' => 'Editar encuesta interno']);
        $listInternoEmisor = Permission::create(['name' => 'delete-encuestaInterno', 'display_name' => 'Eliminar encuesta interno']);
        $readInternoEmisor = Permission::create(['name' => 'list-encuestaInterno', 'display_name' => 'Listar encuestas interno']);
        
        $createSostHogar = Permission::create(['name' => 'create-encuestaSostenibilidadHogares', 'display_name' => 'Crear encuesta sostenibilidad hogar']);
        $editSostHogar = Permission::create(['name' => 'read-encuestaSostenibilidadHogares', 'display_name' => 'Ver encuesta sostenibilidad hogar']);
        $deleteSostHogar = Permission::create(['name' => 'edit-encuestaSostenibilidadHogares', 'display_name' => 'Editar encuesta sostenibilidad hogar']);
        $listSostHogar = Permission::create(['name' => 'delete-encuestaSostenibilidadHogares', 'display_name' => 'Eliminar encuesta sostenibilidad hogar']);
        $listSostHogar = Permission::create(['name' => 'list-encuestaSostenibilidadHogares', 'display_name' => 'Listar encuesta sostenibilidad hogar']);
        
        $createSostPST = Permission::create(['name'=>'create-encuestaSostenibilidadPST', 'display_name' => 'Crear encuesta sostenibilidad PST']);
        $readSostPST = Permission::create(['name' => 'read-encuestaSostenibilidadPST', 'display_name' => 'Ver encuesta sostenibilidad PST']);
        $listSostPST = Permission::create(['name' => 'list-encuestaSostenibilidadPST', 'display_name' => 'Listar encuestas sostenibilidad PST']);
        $editSostPST = Permission::create(['name' => 'edit-encuestaSostenibilidadPST', 'display_name' => 'Editar encuesta sostenibilidad PST']);
        $deleteSostPST = Permission::create(['name' => 'delete-encuestaSostenibilidadPST', 'display_name' => 'Eliminar encuesta sostenibilidad PST']);
        
        $createEstadisticaSecundariaADHOC = Permission::create(['name'=>'create-estadisticaSecundaria', 'display_name' => 'Crear estadística secundaria']);
        $readEstadisticaSecundariaADHOC  = Permission::create(['name' => 'read-estadisticaSecundaria', 'display_name' => 'Ver estadística secundaria']);
        $listEstadisticaSecundariaADHOC  = Permission::create(['name' => 'list-estadisticaSecundariaC', 'display_name' => 'Listar estadísticas secundarias']);
        $editEstadisticaSecundariaADHOC  = Permission::create(['name' => 'edit-estadisticaSecundariaC', 'display_name' => 'Editar estadística secundaria']);
        $estadoEstadisticaSecundariaADHOC  = Permission::create(['name' => 'estado-estadisticaSecundaria', 'display_name' => 'Cambiar estado de estadística secundaria']);
        $deleteEstadisticaSecundariaADHOC  = Permission::create(['name' => 'delete-estadisticaSecundaria', 'display_name' => 'Eliminar estadística secundaria']);
        
        $createEncuestaADHOC = Permission::create(['name'=>'create-encuestaADHOC', 'display_name' => 'Crear encuesta ADHOC']);
        $readEncuestaADHOC  = Permission::create(['name' => 'read-encuestaADHOC', 'display_name' => 'Ver encuesta ADHOC']);
        $listEncuestaADHOC  = Permission::create(['name' => 'list-encuestaADHOC', 'display_name' => 'Listar encuesta ADHOC']);
        $editEncuestaADHOC  = Permission::create(['name' => 'edit-encuestaADHOC', 'display_name' => 'Editar encuesta ADHOC']);
        $estadoEncuestaADHOC  = Permission::create(['name' => 'estado-encuestaADHOC', 'display_name' => 'Cambiar estado de encuesta ADHOC']);
        $deleteEncuestaADHOC  = Permission::create(['name' => 'delete-encuestaADHOC', 'display_name' => 'Eliminar encuesta ADHOC']);
        $duplicarEncuestaADHOC  = Permission::create(['name' => 'duplicar-encuestaADHOC', 'display_name' => 'Duplicar encuesta ADHOC']);
        $estadisticasEncuestaADHOC  = Permission::create(['name' => 'estadisticas-encuestaADHOC', 'display_name' => 'Ver estadisticas de encuesta ADHOC']);
        
        $importarRNT = Permission::create(['name' => 'import-RNT', 'display_name' => 'Importar RNT']);
        $excelMuestra = Permission::create(['name'=>'excel-muestra', 'display_name' => 'Excel muestra maestra']);
        $kmlMuestra = Permission::create(['name'=>'KML-muestra', 'display_name' => 'Archivo KML muestra maestra']);
        $excelInfoZona = Permission::create(['name'=>'excel-infoZona', 'display_name' => 'Excel Información zona']);
        $excelZona = Permission::create(['name'=>'excel-zona', 'display_name' => 'Excel de zona']);
        
        $llenarInfoZona = Permission::create(['name'=>'llenarInfo-zona', 'display_name' => 'Ingresar información zona']);
        
        $createBloque = Permission::create(['name'=>'create-zona', 'display_name' => 'Crear bloque']);
        $readBloque  = Permission::create(['name' => 'read-zona', 'display_name' => 'Ver bloque']);
        $listBloque  = Permission::create(['name' => 'list-zona', 'display_name' => 'Listar bloques']);
        $editBloque  = Permission::create(['name' => 'edit-zona', 'display_name' => 'Editar bloque']);
        $estadoBloque  = Permission::create(['name' => 'estado-zona', 'display_name' => 'Cambiar estado de bloque']);
        $deleteBloque  = Permission::create(['name' => 'delete-zona', 'display_name' => 'Eliminar bloque']);
        
        $createPeriodoMuestra = Permission::create(['name'=>'create-periodosMuestra', 'display_name' => 'Crear periodos muestra maestra']);
        $readPeriodoMuestra  = Permission::create(['name' => 'read-periodosMuestra', 'display_name' => 'Ver periodos muestra maestra']);
        $listPeriodoMuestra  = Permission::create(['name' => 'list-periodosMuestra', 'display_name' => 'Listar periodos muestra maestra']);
        $editPeriodoMuestra  = Permission::create(['name' => 'edit-periodosMuestra', 'display_name' => 'Editar periodos muestra maestra']);
        $estadoPeriodoMuestra  = Permission::create(['name' => 'estado-periodosMuestra', 'display_name' => 'Cambiar estado de periodos muestra maestra']);
        
        $createProveedorMuestra  = Permission::create(['name' => 'create-proveedorMuestra', 'display_name' => 'Crear proveedor muestra maestra']);
        $editProveedorMuestra  = Permission::create(['name' => 'edit-proveedorMuestra', 'display_name' => 'Editar proveedor muestra maestra']);
        $verMuestraMaestra = Permission::create(['name'=>'read-muestraMaestra', 'display_name' => 'Ver muestra maestra']);
        
        $createInforme= Permission::create(['name'=>'create-informe', 'display_name' => 'Crear informe']);
        $readInforme  = Permission::create(['name' => 'read-informe', 'display_name' => 'Ver informe']);
        $listInforme  = Permission::create(['name' => 'list-informe', 'display_name' => 'Listar informes']);
        $editInforme  = Permission::create(['name' => 'edit-informe', 'display_name' => 'Editar informe']);
        $estadoInforme  = Permission::create(['name' => 'estado-informe', 'display_name' => 'Cambiar estado de informe']);
        $deleteInforme  = Permission::create(['name' => 'delete-informe', 'display_name' => 'Eliminar informe']);
        
        $listProveedorOferta  = Permission::create(['name' => 'list-proveedoresOferta', 'display_name' => 'Listar proveedores oferta']);
        $listProveedorRNTOferta  = Permission::create(['name' => 'list-proveedoresRNTOferta', 'display_name' => 'Listar proveedores RNT oferta']);
        $exportProveedorRNTOferta  = Permission::create(['name' => 'exportar-proveedoresRNTOferta', 'display_name' => 'Exportar proveedores RNT oferta']);
        $exportProveedorOferta  = Permission::create(['name' => 'exportar-proveedoresOferta', 'display_name' => 'Exportar proveedores oferta']);
        $editProveedorRNTOferta  = Permission::create(['name' => 'edit-proveedoresRNTOferta', 'display_name' => 'Editar proveedores RNT oferta']);
        $activarProveedorOferta  = Permission::create(['name' => 'activar-proveedoresOferta', 'display_name' => 'Activar proveedor oferta']);
        
        
        
    }
}
