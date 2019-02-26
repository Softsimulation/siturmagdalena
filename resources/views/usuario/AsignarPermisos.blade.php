
@extends('layout._AdminLayout')

@section('title', 'Asignación de permisos')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
        }
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Asignación de permisos')

@section('app','ng-app="admin.usuario"')

@section('controller','ng-controller="asignacionPermisosCtrl"')

@section('content')
    

<div class="container">
    <h1 class="title1">Asignación de permisos</h1>
    <input type="hidden" ng-init="id={{$id}}" ng-model="id"/>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            
            <div class="col-xs-12 col-sm-6 col-md-6" style="text-align: center;">
                <a href="/usuario/listadousuarios" class="btn btn-primary" style="margin-bottom: .5em;">Volver al listado</a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6" style="text-align: center;">
                <a href="" ng-click="asignacionPermisos()" class="btn btn-success" style="margin-bottom: .5em;">Guardar permisos</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12" style="overflow: auto;">
                <div>
                    <table class="table table-bordered">
                      <tbody>
                        <tr fixed>
                          <th></th><th></th>
                          <th>Crear</th>
                          <th>Editar</th>
                          <th>Listar</th>
                          <th>Cambiar estado</th>
                          <th>Visualizar</th>
                          <th>Sugerir</th>
                          <th>Borrar</th>
                          <th>Prioridad</th>
                          <th>Importar</th>
                          <th>Exportar</th>
                          <th>Activar proveedor oferta</th>
                          <th>Duplicar</th>
                          <th>Obtener estadística</th>
                          <th>Archivo KML</th>
                        </tr>
                        <tr>
                          <td rowspan="13">Promoción</td>
                        </tr>
                        <tr>
                          <td>Actividades</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-actividad'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-actividad'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Atracciones</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-atraccion'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-atraccion'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Destinos</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-destino'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-destino'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Eventos</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-evento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-evento'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Rutas turísticas</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-ruta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-ruta'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Proveedores</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'sugerir-proveedor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-proveedor'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Informes</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-informe'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-informe'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-informe'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-informe'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-informe'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-informe'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Biblioteca digital</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-publicaciones'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-publicaciones'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-publicaciones'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-publicaciones'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-publicaciones'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-publicaciones'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Noticias</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-noticia'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-noticia'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-noticia'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-noticia'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-noticia'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-noticia'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Galería de imágenes</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-slider'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-slider'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-slider'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-slider'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-slider'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-slider'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'prioridad-slider'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Requisitos de viaje</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'requisitos-viaje'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'requisitos-viaje'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Acerca del departamento</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'acerca-departamento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'acerca-departamento'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="4">Turismo receptor</td>
                        </tr>
                        <tr>
                          <td>Grupos de viajes</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-grupoViaje'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-grupoViaje'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-grupoViaje'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-grupoViaje'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-grupoViaje'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Encuesta turismo receptor</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaReceptor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaReceptor'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaReceptor'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaReceptor'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaReceptor'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Medición</td>
                          <td></td><td></td><td></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'export-medicionReceptor'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="4">Turismo interno y emisor</td>
                        </tr>
                        <tr>
                          <td>Temporadas</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-temporada'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-temporada'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-temporada'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-temporada'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-temporada'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-temporada'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Encuesta interno y emisor</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaInterno'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaInterno'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaInterno'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaInterno'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaInterno'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Medición</td>
                          <td></td><td></td><td></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'export-medicionInternoEmisor'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="5">Oferta y empleo</td>
                        </tr>
                        <tr>
                          <td>Encuesta oferta y empleo</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaOfertaEmpleo'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaOfertaEmpleo'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaOfertaEmpleo'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaOfertaEmpleo'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaOfertaEmpleo'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Proveedores oferta</td>
                          <td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-proveedoresOferta'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'exportar-proveedoresOferta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'activar-proveedoresOferta'"></td>
                          <td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Proveedores RNT oferta</td>
                          <td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-proveedoresRNTOferta'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-proveedoresRNTOferta'"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'import-RNT'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'exportar-proveedoresRNTOferta'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Medición</td>
                          <td></td><td></td><td></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'export-medicionOferta'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="5">Sostenibilidad</td>
                        </tr>
                        <tr>
                          <td>Encuesta sostenibilidad Hogar</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaSostenibilidadHogares'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaSostenibilidadHogares'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaSostenibilidadHogares'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaSostenibilidadHogares'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaSostenibilidadHogares'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Medición Hogar</td>
                          <td></td><td></td><td></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'export-sostenibilidadHogar'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Encuesta sostenibilidad PST</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaSostenibilidadPST'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaSostenibilidadPST'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaSostenibilidadPST'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaSostenibilidadPST'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaSostenibilidadPST'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Medición PST</td>
                          <td></td><td></td><td></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'export-sostenibilidadPST'"></td>
                          <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="4">Administrador paises</td>
                        </tr>
                        <tr>
                          <td>Paises</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-pais'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-pais'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-pais'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-pais'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-pais'"></td>
                          <td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'importar-pais'"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Departamentos</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-departamento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-departamento'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-departamento'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-departamento'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-departamento'"></td>
                          <td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'importar-departamento'"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Municipios</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-municipio'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-municipio'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-municipio'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-municipio'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-municipio'"></td>
                          <td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'importar-municipio'"></td>
                          <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td rowspan="2'"></td>
                        </tr>
                        <tr>
                          <td>Estadísticas secundarias</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-estadisticaSecundaria'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-estadisticaSecundaria'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-estadisticaSecundaria'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-estadisticaSecundaria'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-estadisticaSecundaria'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-estadisticaSecundaria'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                
                        </tr>
                        <tr>
                          <td rowspan="2'"></td>
                        </tr>
                        <tr>
                          <td>Encuestas ADHOC</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-encuestaADHOC'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-encuestaADHOC'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-encuestaADHOC'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-encuestaADHOC'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-encuestaADHOC'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-encuestaADHOC'"></td>
                          <td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'duplicar-encuestaADHOC'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estadisticas-encuestaADHOC'"></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td rowspan="6">Muestra Maestra</td>
                        </tr>
                        <tr>
                          <td>Muestra muestra</td>
                          <td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-muestraMaestra'"></td>
                          <td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'excel-muestra'"></td>
                          <td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'KML-muestra'"></td>
                        </tr>
                        <tr>
                          <td>Períodos</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-periodosMuestra'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-periodosMuestra'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-periodosMuestra'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-periodosMuestra'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-periodosMuestra'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                          <td>Bloques</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-zona'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-zona'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'list-zona'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'estado-zona'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'read-zona'"></td>
                          <td class="text-center"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'delete-zona'"></td>
                          <td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'excel-zona'"></td>
                          <td></td><td></td><td></td><td></td>
                          
                        </tr>
                        <tr>
                          <td>Información de zona</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'llenarInfo-zona'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'excel-infoZona'"></td>
                          <td></td><td></td><td></td><td></td>
                          
                        </tr>
                        <tr>
                          <td>Proveedores Muestra Maestra</td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'create-proveedorMuestra'"></td>
                          <td class="text-center"><input type="checkbox" checklist-model="permisos" checklist-value="'edit-proveedorMuestra'"></td>
                          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                          <td></td><td></td><td></td><td></td><td></td>
                          
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='carga'>

    </div>
</div>

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/usuarios/usuarios.js')}}"></script>
<script src="{{asset('/js/administrador/usuarios/usuarioServices.js')}}"></script>
@endsection

