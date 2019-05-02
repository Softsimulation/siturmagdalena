
@extends('layout._AdminLayout')

@section('title', 'DashBoard')

@section('titulo','DashBoard')
@section('subtitulo','El siguiente listado cuenta con los diferentes enlaces a los que puede acceder el usuario')

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
            z-index: 1000;
            display: block;
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            z-index: 1000;
            display: block;
        }
        .panel-title{
            font-weight: 500;
            margin: 0;
        }
        .m-0{
            margin: 0;
        }
        .list-group-flush:first-child .list-group-item:first-child {
            border-top: 0;
        }
        .list-group-flush .list-group-item {
            border-right: 0;
            border-left: 0;
            border-radius: 0;
        }
        .list-group-flush:last-child .list-group-item:last-child {
            margin-bottom: 0;
            border-bottom: 0;
        }
        .panel-body {
            padding: .5rem;
        }
        
    </style>
@endsection

@section('content')

<div class="row">
    @if(Auth::user()->contienePermiso('list-actividad|list-atraccion|list-destino|list-evento|list-proveedor|list-ruta|list-informe|list-publicaciones|list-slider|acerca-departamento|requisitos-viaje'))
    <div class="col-xs-12 col-md-4" >
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Promoción</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
            @if(Auth::user()->contienePermiso('list-actividad'))
                <li class="list-group-item"><a href="/administradoractividades">Listado de actividades</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-atraccion'))
                <li class="list-group-item"><a href="/administradoratracciones">Listado de atracciones</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-destino'))
                <li class="list-group-item"><a href="/administradordestinos">Listado de destinos</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-evento'))
                <li class="list-group-item"><a href="/administradoreventos">Listado de eventos</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedor'))
                <li class="list-group-item"><a href="/administradorproveedores">Listado de proveedores</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-ruta'))
                <li class="list-group-item"><a href="/administradorrutas">Listado de rutas turísticas</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-informe'))
                <li class="list-group-item"><a href="/informes/configuracion">Listado de informes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-publicaciones'))
                <li class="list-group-item"><a href="/publicaciones/listadoadmin">Listado de biblioteca digital</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-noticia'))
                <li class="list-group-item"><a href="/noticias/listadonoticias">Listado de noticias</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-slider'))
                <li class="list-group-item"><a href="/sliders/listadosliders">Galería de imágenes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('acerca-departamento'))
                <li class="list-group-item"><a href="/InformacionDepartamento/configuracionacercade">Acerca del departamento</a></li>
            @endif
            @if(Auth::user()->contienePermiso('requisitos-viaje'))
                <li class="list-group-item"><a href="/InformacionDepartamento/configuracionrequisitos">Requisitos de viajes</a></li>
            @endif
            </ul>
          </div>
        </div>
    </div>
    @endif
    <div class="col-sm-12 col-md-4">
        @if(Auth::user()->contienePermiso('list-grupoViaje|list-encuestaReceptor'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Turísmo receptor</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
            @if(Auth::user()->contienePermiso('list-grupoViaje'))
                <li class="list-group-item"><a href="/grupoviaje/listadogrupos">Grupos de viajes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaReceptor'))
                <li class="list-group-item"><a href="/InformacionDepartamento/configuracionrequisitos">Listado encuestas</a></li>
            @endif
            </ul>
          </div>
        </div>
        @endif
        @if(Auth::user()->contienePermiso('list-temporada|create-encuestaInterno|edit-encuestaInterno'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Turísmo interno y emisor</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
            @if(Auth::user()->contienePermiso('list-temporada|create-encuestaInterno|edit-encuestaInterno'))
                <li class="list-group-item"><a href="/temporada">Temporadas turísmo interno</a></li>
            @endif
            </ul>
          </div>
        </div>
        @endif
        @if(Auth::user()->contienePermiso('list-encuestaOfertaEmpleo|list-proveedoresOferta|list-proveedoresRNTOferta|import-RNT'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Oferta y empleo</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
            @if(Auth::user()->contienePermiso('list-encuestaOfertaEmpleo'))
                <li class="list-group-item"><a href="/ofertaempleo/encuestasoferta">Listado encuestas</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedoresOferta'))
                <li class="list-group-item"><a href="/ofertaempleo/listadoproveedores">Listado proveedores</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedoresRNTOferta'))
                <li class="list-group-item"><a href="/ofertaempleo/listadoproveedoresrnt">Activar proveedor RNT</a></li>
            @endif
            @if(Auth::user()->contienePermiso('import-RNT'))
                <li class="list-group-item"><a href="/importarRnt">Importar RNT</a></li>
            @endif
            </ul>
          </div>
        </div>
        @endif
        @role('Admin')
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Administrador</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
                <li class="list-group-item"><a href="/usuario/listadousuarios">Listado de usuarios</a></li>
                <li class="list-group-item"><a href="/bolsaEmpleo/vacantes">Bolsa de empleo</a></li>
            </ul>
          </div>
        </div>
        @endif
    </div>
    <div class="col-sm-12 col-md-4">
        @if(Auth::user()->contienePermiso('list-encuestaSostenibilidadHogares|list-encuestaSostenibilidadPST'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Sotenibilidad</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
            @if(Auth::user()->contienePermiso('list-encuestaSostenibilidadHogares'))
                <li class="list-group-item"><a href="/sostenibilidadhogares/encuestas">Encuestas sostenibilidad</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaSostenibilidadPST'))
                <li class="list-group-item"><a href="/sostenibilidadpst/encuestas">Encuestas sostenibilidad PST</a></li>
            @endif
            </ul>
          </div>
        </div>
        @endif
        
        @if(Auth::user()->contienePermiso('list-noticia|list-estadisticaSecundaria|list-indicadorMedicion|list-indicadorMedicion|calcular-indicadorMedicion|recalcular-indicadorMedicion'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Encuestas e indicadores</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
                @if(Auth::user()->contienePermiso('list-noticia'))
                    <li class="list-group-item"><a href="/encuesta/listado">Encuestas dinámicas</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-estadisticaSecundaria'))
                    <li class="list-group-item"><a href="/EstadisticasSecundarias/configuracion">Listado de estadísticas secundarias</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-indicadorMedicion'))
                    <li class="list-group-item"><a href="/indicadoresMedicion/listado">Listado de indicadores</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-indicadorMedicion|calcular-indicadorMedicion|recalcular-indicadorMedicion'))
                    <li class="list-group-item"><a href="/calcularindicadores">Listado de indicadores calculados</a></li>
                @endif
            </ul>
          </div>
        </div>
        @endif
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Configuración</h3>
             <p class="text-muted m-0">Permisos</p>
          </div>
          <div class="panel-body">
            <ul class="list-group list-group-flush m-0">
                @if(Auth::user()->contienePermiso('export-medicionReceptor|export-medicionOferta|export-medicionInternoEmisor|export-sostenibilidadHogar|export-sostenibilidadPST'))
                    <li class="list-group-item"><a href="/exportacion">Exportaciones</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-pais'))
                    <li class="list-group-item"><a href="/administrarpaises">Listado de paises</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-departamento'))
                    <li class="list-group-item"><a href="/administrardepartamentos">Listado de departamentos</a></li>
                @endif
                @if(Auth::user()->contienePermiso('list-municipio'))
                    <li class="list-group-item"><a href="/administrarmunicipios">Listado de municipios</a></li>
                @endif
            </ul>
          </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <ul>
            @role('Admin')
                <li><a href="/usuario/listadousuarios">Listado de usuarios</a></li>
                <li><a href="/bolsaEmpleo/vacantes">Bolsa de empleo</a></li>
            @endrole
            @role('AdminPst')
                <li><a href="/bolsaEmpleo/vacantes">Bolsa de empleo</a></li>   
            @endrole
            @if(Auth::user()->contienePermiso('list-actividad'))
                <li><a href="/administradoractividades">Listado de actividades</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-atraccion'))
                <li><a href="/administradoratracciones">Listado de atracciones</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-destino'))
                <li><a href="/administradordestinos">Listado de destinos</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-evento'))
                <li><a href="/administradoreventos">Listado de eventos</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedor'))
                <li><a href="/administradorproveedores">Listado de proveedores promocion</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-ruta'))
                <li><a href="/administradorrutas">Listado de rutas turísticas</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-informe'))
                <li><a href="/informes/configuracion">Listado de informes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-publicaciones'))
                <li><a href="/publicaciones/listadoadmin">Listado de biblioteca digital</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-slider'))
                <li><a href="/sliders/listadosliders">Galería de imágenes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('acerca-departamento'))
                <li><a href="/InformacionDepartamento/configuracionacercade">Acerca del departamento</a></li>
            @endif
            @if(Auth::user()->contienePermiso('requisitos-viaje'))
                <li><a href="/InformacionDepartamento/configuracionrequisitos">Requisitos de viajes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-grupoViaje'))
                <li><a href="/grupoviaje/listadogrupos">Grupos de viajes</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaReceptor'))
                <li><a href="/InformacionDepartamento/configuracionrequisitos">Listado encuestas turismo receptor</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-temporada|create-encuestaInterno|edit-encuestaInterno'))
                <li><a href="/temporada">Temporadas turismo interno</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaOfertaEmpleo'))
                <li><a href="/ofertaempleo/encuestasoferta">Listado encuestas Oferta y empleo</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedoresOferta'))
                <li><a href="/ofertaempleo/listadoproveedores">Listado proveedores oferta</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-proveedoresRNTOferta'))
                <li><a href="/ofertaempleo/listadoproveedoresrnt">Activar proveedore RNT</a></li>
            @endif
            @if(Auth::user()->contienePermiso('import-RNT'))
                <li><a href="/importarRnt">Importar RNT</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaSostenibilidadHogares'))
                <li><a href="/sostenibilidadhogares/encuestas">Encuestas sostenibilidad hogar</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-encuestaSostenibilidadPST'))
                <li><a href="/sostenibilidadpst/encuestas">Encuestas sostenibilidad PST</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-periodosMuestra'))
                <li><a href="/MuestraMaestra/periodos">Listado de períodos de muestra maestra</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-noticia'))
                <li><a href="/noticias/listadonoticias">Listado de noticias</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-noticia'))
                <li><a href="/encuesta/listado">Encuestas dinámicas</a></li>
            @endif
            @if(Auth::user()->contienePermiso('export-medicionReceptor|export-medicionOferta|export-medicionInternoEmisor|export-sostenibilidadHogar|export-sostenibilidadPST'))
                <li><a href="/exportacion">Exportaciones</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-pais'))
                <li><a href="/administrarpaises">Listado de paises</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-departamento'))
                <li><a href="/administrardepartamentos">Listado de departamentos</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-municipio'))
                <li><a href="/administrarmunicipios">Listado de municipios</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-estadisticaSecundaria'))
                <li><a href="/EstadisticasSecundarias/configuracion">Listado de estadísticas secundarias</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-indicadorMedicion'))
                <li><a href="/indicadoresMedicion/listado">Listado de indicadores</a></li>
            @endif
            @if(Auth::user()->contienePermiso('list-indicadorMedicion|calcular-indicadorMedicion|recalcular-indicadorMedicion'))
                <li><a href="/calcularindicadores">Listado de indicadores calculados</a></li>
            @endif
        </ul>
    </div>
</div>

@endsection

