
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
    </style>
@endsection

@section('content')
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

