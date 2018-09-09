
@extends('layout._AdminLayout')

@section('Title', 'Muestra maestra')

@section('title', 'Importación RNT')

@section('estilos')
    <style>
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }
    </style>
@endsection

@section('TitleSection', 'Importación RNT')

@section('app','ng-app="importarRntApp"')

@section('controller','ng-controller="importarRnt"')

@section('titulo','Muestra maestra')
@section('subtitulo','Módulo para la importación de proveedores RNT')

@section('content')
<div class="alert alert-info text-center">
    <p>A continuación presione el botón "Seleccionar archivo" para elegir el archivo a importar desde su computador. <strong>Recuerde que el archivo seleccionado debe ser de formato CSV con un peso menor o igual a 10MB.</strong> Después, presione el botón "Cargar".</p>
</div>
<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

<div class="form-inline text-center">
    <div class="form-group">
        <label class="sr-only">Adjuntar soporte</label>
        <div class="input-group">
            <label class="input-group-btn">
                <span class="btn btn-lg btn-primary" title="Seleccionar un archivo en formato CSV que tenga un peso menor o igual a 10MB" data-toggle="tooltip" data-placement="top">
                    Seleccionar archivo <input type="file" id="soporte" name="soporte" file-input='soporte' style="display: none;" accept=".csv">
                </span>
            </label>
            <input id="nombreArchivoSeleccionado" ng-model="nombreArchivoSeleccionado" type="text" class="form-control input-lg" placeholder="Peso máximo 10MB" readonly>
        </div>
    </div>
    <button class="btn btn-lg btn-success" ng-click="cargarDocumento()">Cargar</button>
</div>
<hr/>
<div class="resultadoImportacion">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"  ng-class="{'active': nuevos.length > 0}" ng-if="nuevos.length > 0"><a href="#nuevos" aria-controls="nuevos" role="tab" data-toggle="tab">Registros nuevos</a></li>
        <li role="presentation" ng-class="{'active': (nuevos.length == 0 && antiguos.length > 0)}" ng-if="antiguos.length > 0"><a href="#antiguo" aria-controls="antiguo" role="tab" data-toggle="tab">Registros antiguos</a></li>
       
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" ng-class="{'active': nuevos.length > 0}" id="nuevos" ng-if="nuevos.length > 0">
            <h2 class="title1 text-center">Registros nuevos</h1>
            <div class="flex-list">
                 
                <div class="form-group has-feedback" style="display: inline-block;">
                    <label class="sr-only" for="inputSearchNew">Búsqueda de registros nuevos</label>
                    <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputSearchNew" placeholder="Buscar registro...">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>      
            </div>
            <div class="text-center" ng-if="(nuevos | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
                <p>Hay @{{(nuevos | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
            </div>
            <div class="alert alert-info" ng-if="nuevos.length == 0">
                <p>No hay registros almacenados</p>
            </div>
            <div class="alert alert-warning" ng-if="(nuevos | filter:prop.search).length == 0 && nuevos.length > 0">
                <p>No existen registros que coincidan con su búsqueda</p>
            </div>
            <div class="alert alert-info" ng-if="nuevos.length > 0">
                Los registros resaltados con color <span class="text-success">verde</span> contienen información similar a los registros que ya se encuentran almacenados en el sistema.
            </div>
            <div class="row">
                <div class="col-xs-12 table-overflow">
                    <table class="table table-striped">
                        <tr>
                            <th style="min-width: 60px;">No. de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Sub-Categoría</th>
                            <th>Categoría</th>
                            <!-- <th>Correo</th> -->
                            <th style="max-width: 80px;">Estado</th>
                            <th style="max-width: 140px;">Estado carga</th>
                            <th style="min-width: 90px;"></th>
                        </tr>
                        <tr dir-paginate="item in nuevos |filter:prop.search|itemsPerPage:10 as results" pagination-id="paginacion_nuevos" ng-class="{'success': item.es_similar == 1}">
                            <td>@{{item.numero_rnt}}</td>
                            <td>@{{item.nombre_comercial}}</td>
                            <td>@{{item.sub_categoria}}</td>
                            <td>@{{item.categoria}}</td>
                            <!-- <td>@{{item.correo}}</td> -->
                            <td>@{{item.estado}}</td>
                            <td ng-if="item.es_correcto ==1">Correcto</td><td ng-if="item.es_correcto !=1">Incorrecto</td>
                            <td style="text-align: center;">
                                <button type="button" ng-if="item.es_correcto != 1 || item.es_similar == 1 " title="Agregar registro" ng-click="abrirModalCrear(item)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Agregar registro</span></button>
                                <button type="button" title="Ver registro" ng-click="abrirModalVer(item)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">Ver registro</span></button>
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12 text-center">
              <dir-pagination-controls pagination-id="paginacion_nuevos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" ng-class="{'active': (nuevos.length == 0 && antiguos.length > 0)}" id="antiguo" ng-if="antiguos.length > 0">
            <h2 class="title1 text-center">Registros antiguos pendientes de revisión</h2>
                        
            <div class="flex-list">
                 
                <div class="form-group has-feedback" style="display: inline-block;">
                    <label class="sr-only" for="inputSearchNew">Búsqueda de registros antiguos</label>
                    <input type="text" ng-model="prop.searchAntiguo" class="form-control input-lg" id="inputSearchOld" placeholder="Buscar registro...">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>      
            </div>
            <div class="text-center" ng-if="(antiguos | filter:prop.searchAntiguo).length > 0 && (prop.searchAntiguo != '' && prop.searchAntiguo != undefined)">
                <p>Hay @{{(antiguos|filter:prop.searchAntiguo).length}} registro(s) que coinciden con su búsqueda</p>
            </div>
            <div class="alert alert-info" ng-if="antiguos.length == 0">
                <p>No hay registros almacenados</p>
            </div>
            <div class="alert alert-warning" ng-if="(antiguos|filter:prop.searchAntiguo).length == 0 && antiguos.length > 0">
                <p>No existen registros que coincidan con su búsqueda</p>
            </div>
            
            <div class="row">
                <div class="col-xs-12 table-overflow">
                    <table class="table table-hover table-striped">
                        <tr>                        
                            <th>No. de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Sub-Categoría</th>
                            <th>Categoría</th>
                            <!-- <th>Correo</th>-->
                            <th>Estado</th>
                            <th style="width: 70px;"></th>
                        </tr>
                        <tr dir-paginate="item in antiguos|filter:prop.searchAntiguo|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            
                            <td>@{{item.numero_rnt}}</td>
                            <td>@{{item.nombre_comercial}}</td>
                            <td>@{{item.sub_categoria}}</td>
                            <td>@{{item.categoria}}</td>
                            <!-- <td>@{{item.correo}}</td>-->
                            <td>@{{item.estado}}</td>
                            <td style="text-align: center;">
                                <button type="button" title="Editar registro" ng-click="abrirModalEditar(item)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar registro</span></button>
                                <button type="button" title="Ver registro" ng-click="abrirModalVer(item)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">Ver registro</span></button>
                                
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <dir-pagination-controls pagination-id="paginacion_antiguos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Modal editar registro-->
    <div class="modal fade bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="labelModalEditar">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="labelModalEditar">Editar registro</h4>
                </div>
                
                <form role="form" name="editarForm" novalidate>
                    <div class="modal-body">
    					
    				    <div class="row">
    				        <div class="col-xs-12">
    				            <div class="alert alert-warning">
                					En esta ventana puede verificar los datos a editar en cada registro. Si considera que el registro puede ser editado presione el botón 'Guardar'.
                				</div> 
    				        </div>
    				    </div>	
    					<div class="row">
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group">
        			                <label class="control-label" for="editarForm-numero_rnt"><span class="asterisk">*</span> No. de RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.numero_rnt" name="numero_rnt" id="editarForm-numero_rnt" required>
        			                <span class="text-input-alt">@{{registro.numero_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.estado.$touched) && editarForm.estado.$error.required) || (registro.estado != registro.estado2)}">
        			                <label class="control-label" for="editarForm-estado"><span class="asterisk">*</span> Estado</label>
        			                <input type="text" class="form-control" ng-model="registro.estado" name="estado" id="editarForm-estado" required>
        			                <span class="text-input-alt">@{{registro.estado2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.nit.$touched) && editarForm.nit.$error.required) || (registro.nit != registro.nit2)}">
        			                <label class="control-label" for="editarForm-nit"><span class="asterisk">*</span> NIT</label>
        			                <input type="text" class="form-control" ng-model="registro.nit" name="nit" id="editarForm-id" required>
        			                <span class="text-input-alt">@{{registro.nit2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.municipio.$touched) && editarForm.municipio.$error.required) || (registro.municipio != registro.municipio2)}">
        			                <label class="control-label" for="editarForm-municipio"><span class="asterisk">*</span> Municipio</label>
        			                <input type="text" class="form-control" ng-model="registro.municipio" name="municipio" id="editarForm-municipio" required>
        			                <span class="text-input-alt">@{{registro.municipio2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-12">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.nombre_comercial.$touched) && editarForm.nombre_comercial.$error.required) || (registro.nombre_comercial != registro.nombre_comercial2)}">
        			                <label class="control-label" for="editarForm-nombre_comercial"><span class="asterisk">*</span> Nombre comercial</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_comercial" name="nombre_comercial" id="editarForm-nombre_comercial" required>
        			                <span class="text-input-alt">@{{registro.nombre_comercial2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-12">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.nombre_comercial_plataforma.$touched) && editarForm.nombre_comercial_plataforma.$error.required) || (registro.nombre_comercial_plataforma != registro.nombre_comercial_plataforma2)}">
        			                <label class="control-label" for="editarForm-nombre_comercial_plataforma"><span class="asterisk">*</span> Nombre comercial plataforma</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_comercial_plataforma" name="nombre_comercial_plataforma" id="editarForm-nombre_comercial_plataforma" required>
        			                <span class="text-input-alt">@{{registro.nombre_comercial_plataforma2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.categoria.$touched) && editarForm.categoria.$error.required) || (registro.categoria != registro.categoria2)}">
        			                <label class="control-label" for="editarForm-categoria"><span class="asterisk">*</span> Categoría</label>
        			                <input type="text" class="form-control" ng-model="registro.categoria" name="categoria" id="editarForm-categoria" required>
        			                <span class="text-input-alt">@{{registro.categoria2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.categoria.$touched) && editarForm.categoria.$error.required) || (registro.sub_categoria != registro.sub_categoria2)}">
        			                <label class="control-label" for="editarForm-sub_categoria"><span class="asterisk">*</span> Subcategoría</label>
        			                <input type="text" class="form-control" ng-model="registro.sub_categoria" name="sub_categoria" id="editarForm-sub_categoria" required>
        			                <span class="text-input-alt">@{{registro.sub_categoria2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.direccion_comercial.$touched) && editarForm.direccion_comercial.$error.required) || (registro.direccion_comercial != registro.direccion_comercial2)}">
        			                <label class="control-label" for="editarForm-direccion_comercial"><span class="asterisk">*</span> Dirección comercial</label>
        			                <input type="text" class="form-control" ng-model="registro.direccion_comercial" name="direccion_comercial" id="editarForm-direccion_comercial" required>
        			                <span class="text-input-alt">@{{registro.direccion_comercial2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.telefono.$touched) && editarForm.telefono.$error.required) || (registro.telefono != registro.telefono2)}">
        			                <label class="control-label" for="editarForm-telefono"><span class="asterisk">*</span> Teléfono</label>
        			                <input type="text" class="form-control" ng-model="registro.telefono" name="telefono" id="editarForm-telefono" required>
        			                <span class="text-input-alt">@{{registro.telefono2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.celular.$touched) && editarForm.celular.$error.required) || (registro.celular != registro.celular2)}">
        			                <label class="control-label" for="editarForm-celular"><span class="asterisk">*</span> Celular</label>
        			                <input type="text" class="form-control" ng-model="registro.celular" name="celular" id="editarForm-celular" required>
        			                <span class="text-input-alt">@{{registro.celular2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.nombre_gerente.$touched) && editarForm.nombre_gerente.$error.required) || (registro.nombre_gerente != registro.nombre_gerente2)}">
        			                <label class="control-label" for="editarForm-nombre_gerente"><span class="asterisk">*</span> Nombre del gerente</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_gerente" name="nombre_gerente" id="editarForm-nombre_gerente" required>
        			                <span class="text-input-alt">@{{registro.nombre_gerente2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.correo.$touched) && editarForm.correo.$error.required) || (registro.correo != registro.correo2)}">
        			                <label class="control-label" for="editarForm-correo"><span class="asterisk">*</span> Correo electrónico</label>
        			                <input type="text" class="form-control" ng-model="registro.correo" name="correo" id="editarForm-correo" required>
        			                <span class="text-input-alt">@{{registro.correo2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.digito_verificacion.$touched) && editarForm.digito_verificacion.$error.required) || (registro.digito_verificacion != registro.digito_verificacion2)}">
        			                <label class="control-label" for="editarForm-digito_verificacion"><span class="asterisk">*</span> Dígito de verificación</label>
        			                <input type="text" class="form-control" ng-model="registro.digito_verificacion" name="digito_verificacion" id="editarForm-digito_verificacion" required>
        			                <span class="text-input-alt">@{{registro.digito_verificacion2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.ultimo_anio_rnt.$touched) && editarForm.ultimo_anio_rnt.$error.required) || (registro.ultimo_anio_rnt != registro.ultimo_anio_rnt2)}">
        			                <label class="control-label" for="editarForm-ultimo_anio_rnt"><span class="asterisk">*</span> Último año RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.ultimo_anio_rnt" name="ultimo_anio_rnt" id="editarForm-ultimo_anio_rnt" required>
        			                <span class="text-input-alt">@{{registro.ultimo_anio_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.sostenibilidad_rnt.$touched) && editarForm.sostenibilidad_rnt.$error.required) || (registro.sostenibilidad_rnt != registro.sostenibilidad_rnt2)}">
        			                <label class="control-label" for="editarForm-sostenibilidad_rnt"><span class="asterisk">*</span> Sostenibilidad RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.sostenibilidad_rnt" name="sostenibilidad_rnt" id="editarForm-sostenibilidad_rnt" required>
        			                <span class="text-input-alt">@{{registro.sostenibilidad_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.turismo_aventura.$touched) && editarForm.turismo_aventura.$error.required) || (registro.turismo_aventura != registro.turismo_aventura2)}">
        			                <label class="control-label" for="editarForm-turismo_aventura"><span class="asterisk">*</span> Turísmo aventura</label>
        			                <input type="text" class="form-control" ng-model="registro.turismo_aventura" name="turismo_aventura" id="editarForm-turismo_aventura" required>
        			                <span class="text-input-alt">@{{registro.turismo_aventura2}}</span>
        			            </div>
        			        </div>
        			        
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.hab2.$touched) && editarForm.hab2.$error.required) || (registro.hab2 != registro.hab22)}">
        			                <label class="control-label" for="editarForm-hab2"><span class="asterisk">*</span> Hab2</label>
        			                <input type="number" class="form-control" ng-model="registro.hab2" name="hab2" id="editarForm-hab2" required>
        			                <span class="text-input-alt">@{{registro.hab22}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.cam2.$touched) && editarForm.cam2.$error.required) || (registro.cam2 != registro.cam22)}">
        			                <label class="control-label" for="editarForm-cam2"><span class="asterisk">*</span> Cam2</label>
        			                <input type="number" class="form-control" ng-model="registro.cam2" name="cam2" id="editarForm-cam2" required>
        			                <span class="text-input-alt">@{{registro.cam22}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': ((editarForm.$submitted || editarForm.emp2.$touched) && editarForm.emp2.$error.required) || (registro.emp2 != registro.emp22)}">
        			                <label class="control-label" for="editarForm-emp2"><span class="asterisk">*</span> Emp2</label>
        			                <input type="number" class="form-control" ng-model="registro.emp2" name="emp2" id="editarForm-emp2" required>
        			                <span class="text-input-alt">@{{registro.emp22}}</span>
        			            </div>
        			        </div>
        			    </div>
        				<div class="row">
        				    <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': (registro.latitud != registro.latitud2)}">
        			                <label class="control-label" for="editarForm-latitud">Latitud</label>
        			                <input type="number" class="form-control" ng-model="registro.latitud" name="latitud" id="editarForm-latitud">
        			                <span class="text-input-alt">@{{registro.latitud2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': (registro.longitud != registro.longitud2)}">
        			                <label class="control-label" for="editarForm-longitud">Longitud</label>
        			                <input type="number" class="form-control" ng-model="registro.longitud" name="longitud" id="editarForm-longitud">
        			                <span class="text-input-alt">@{{registro.longitud2}}</span>
        			            </div>
        			                
        			        </div>
        				</div>
    				    
                        <div class="row">
                            <ng-map id="mapa" zoom="9" center="[11.24079, -74.19904]" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
                                <marker ng-if="registro.latitud != undefined && registro.longitud != undefined" draggable="true" on-dragend="getCurrentLocation(registro)" position="[@{{registro.latitud}}, @{{registro.longitud}}]" title="registro.nombre_comercial"></marker>
                                
                                <drawing-manager ng-if="registro.latitud == undefined && registro.longitud == undefined"
                                    on-overlaycomplete="drawFinish(registro)"
                                    drawing-control-options="{position: 'TOP_CENTER',drawingModes:['marker']}"
                                    drawingControl="true"
                                    drawingMode="null"
                                    rectangleOptions="{fillColor:'red'}" >
                                </drawing-manager>
                                
                            </ng-map>
                        </div>
                        
                        
                        <div class="row" ng-if="registro.es_correcto != 1">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="observacion">Observación</label>
                                    <textarea class="form-control" id="observacion" rows="3" readonly>@{{registro.campos}}</textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="editarRegistro()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Modal agregar registro-->
    <div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="labelModalAgregar">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="labelModalAgregar">Agregar registro</h4>
                </div>
                
                <form role="form" name="addForm" novalidate>
                    <div class="modal-body">
    					
    				    <div class="row">
    				        <div class="col-xs-12">
    				            <div class="alert alert-warning">
                					En esta ventana puede verificar los datos de cada registro para luego insertarlo en el sistema.
								</div> 
    				        </div>
    				    </div>	
    					<div class="row">
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.numero_rnt.$touched) && addForm.numero_rnt.$error.required}">
        			                <label class="control-label" for="addForm-numero_rnt"><span class="asterisk">*</span> No. de RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.numero_rnt" name="numero_rnt" id="addForm-numero_rnt" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.numero_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.estado.$touched) && addForm.estado.$error.required}">
        			                <label class="control-label" for="addForm-estado"><span class="asterisk">*</span> Estado</label>
        			                <input type="text" class="form-control" ng-model="registro.estado" name="estado" id="addForm-estado" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.estado2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3" ng-class="{'bg-info': (registro.nit == registro.nit2 && registro.nit == 1) }">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.nit.$touched) && addForm.nit.$error.required}">
        			                <label class="control-label" for="addForm-nit"><span class="asterisk">*</span> NIT</label>
        			                <input type="text" class="form-control" ng-model="registro.nit" name="nit" id="addForm-id" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.nit2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.municipio.$touched) && addForm.municipio.$error.required}">
        			                <label class="control-label" for="addForm-municipio"><span class="asterisk">*</span> Municipio</label>
        			                <input type="text" class="form-control" ng-model="registro.municipio" name="municipio" id="addForm-municipio" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.municipio2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-12">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.nombre_comercial.$touched) && addForm.nombre_comercial.$error.required}">
        			                <label class="control-label" for="addForm-nombre_comercial"><span class="asterisk">*</span> Nombre comercial</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_comercial" name="nombre_comercial" id="addForm-nombre_comercial" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.nombre_comercial2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-12">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.nombre_comercial_plataforma.$touched) && addForm.nombre_comercial_plataforma.$error.required}">
        			                <label class="control-label" for="addForm-nombre_comercial_plataforma"><span class="asterisk">*</span> Nombre comercial plataforma</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_comercial_plataforma" name="nombre_comercial_plataforma" id="addForm-nombre_comercial_plataforma" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.nombre_comercial_plataforma2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.categoria.$touched) && addForm.categoria.$error.required}">
        			                <label class="control-label" for="addForm-categoria"><span class="asterisk">*</span> Categoría</label>
        			                <input type="text" class="form-control" ng-model="registro.categoria" name="categoria" id="addForm-categoria" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.categoria2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.categoria.$touched) && addForm.categoria.$error.required}">
        			                <label class="control-label" for="addForm-sub_categoria"><span class="asterisk">*</span> Subcategoría</label>
        			                <input type="text" class="form-control" ng-model="registro.sub_categoria" name="sub_categoria" id="addForm-sub_categoria" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.sub_categoria2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6" ng-class="{'bg-info': (registro.direccion_comercial == registro.direccion_comercial2 && registro.es_similar == 1) }">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.direccion_comercial.$touched) && addForm.direccion_comercial.$error.required}">
        			                <label class="control-label" for="addForm-direccion_comercial"><span class="asterisk">*</span> Dirección comercial</label>
        			                <input type="text" class="form-control" ng-model="registro.direccion_comercial" name="direccion_comercial" id="addForm-direccion_comercial" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.direccion_comercial2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.telefono.$touched) && addForm.telefono.$error.required}">
        			                <label class="control-label" for="addForm-telefono"><span class="asterisk">*</span> Teléfono</label>
        			                <input type="text" class="form-control" ng-model="registro.telefono" name="telefono" id="addForm-telefono" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.telefono2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.celular.$touched) && addForm.celular.$error.required}">
        			                <label class="control-label" for="addForm-celular"><span class="asterisk">*</span> Celular</label>
        			                <input type="text" class="form-control" ng-model="registro.celular" name="celular" id="addForm-celular" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.celular2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.nombre_gerente.$touched) && addForm.nombre_gerente.$error.required}">
        			                <label class="control-label" for="addForm-nombre_gerente"><span class="asterisk">*</span> Nombre del gerente</label>
        			                <input type="text" class="form-control" ng-model="registro.nombre_gerente" name="nombre_gerente" id="addForm-nombre_gerente" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.nombre_gerente2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6" ng-class="{'bg-info': (registro.correo == registro.correo2 && registro.es_similar == 1 && registro.correo.indexOf('@') > 0 ) }">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.correo.$touched) && addForm.correo.$error.required}">
        			                <label class="control-label" for="addForm-correo"><span class="asterisk">*</span> Correo electrónico</label>
        			                <input type="text" class="form-control" ng-model="registro.correo" name="correo" id="addForm-correo" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.correo2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3" ng-class="{'bg-info': (registro.digito_verificacion == registro.digito_verificacion2 && registro.es_similar == 1) }">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.digito_verificacion.$touched) && addForm.digito_verificacion.$error.required}">
        			                <label class="control-label" for="addForm-digito_verificacion"><span class="asterisk">*</span> Dígito de verificación</label>
        			                <input type="text" class="form-control" ng-model="registro.digito_verificacion" name="digito_verificacion" id="addForm-digito_verificacion" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.digito_verificacion2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.ultimo_anio_rnt.$touched) && addForm.ultimo_anio_rnt.$error.required}">
        			                <label class="control-label" for="addForm-ultimo_anio_rnt"><span class="asterisk">*</span> Último año RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.ultimo_anio_rnt" name="ultimo_anio_rnt" id="addForm-ultimo_anio_rnt" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.ultimo_anio_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.sostenibilidad_rnt.$touched) && addForm.sostenibilidad_rnt.$error.required}">
        			                <label class="control-label" for="addForm-sostenibilidad_rnt"><span class="asterisk">*</span> Sostenibilidad RNT</label>
        			                <input type="text" class="form-control" ng-model="registro.sostenibilidad_rnt" name="sostenibilidad_rnt" id="addForm-sostenibilidad_rnt" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.sostenibilidad_rnt2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-3">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.turismo_aventura.$touched) && addForm.turismo_aventura.$error.required}">
        			                <label class="control-label" for="addForm-turismo_aventura"><span class="asterisk">*</span> Turísmo aventura</label>
        			                <input type="text" class="form-control" ng-model="registro.turismo_aventura" name="turismo_aventura" id="addForm-turismo_aventura" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.turismo_aventura2}}</span>
        			            </div>
        			        </div>
        			        
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.hab2.$touched) && addForm.hab2.$error.required}">
        			                <label class="control-label" for="addForm-hab2"><span class="asterisk">*</span> Hab2</label>
        			                <input type="number" class="form-control" ng-model="registro.hab2" name="hab2" id="addForm-hab2" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.hab22}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.cam2.$touched) && addForm.cam2.$error.required}">
        			                <label class="control-label" for="addForm-cam2"><span class="asterisk">*</span> Cam2</label>
        			                <input type="number" class="form-control" ng-model="registro.cam2" name="cam2" id="addForm-cam2" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.cam22}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-4">
        			            <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.emp2.$touched) && addForm.emp2.$error.required}">
        			                <label class="control-label" for="addForm-emp2"><span class="asterisk">*</span> Emp2</label>
        			                <input type="number" class="form-control" ng-model="registro.emp2" name="emp2" id="addForm-emp2" required>
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.emp22}}</span>
        			            </div>
        			        </div>
        			    </div>
        				<div class="row">
        				    <div class="col-xs-12 col-sm-6">
        			            <div class="form-group">
        			                <label class="control-label" for="addForm-latitud">Latitud</label>
        			                <input type="number" class="form-control" ng-model="registro.latitud" name="latitud" id="addForm-latitud">
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.latitud2}}</span>
        			            </div>
        			        </div>
        			        <div class="col-xs-12 col-sm-6">
        			            <div class="form-group">
        			                <label class="control-label" for="addForm-longitud">Longitud</label>
        			                <input type="number" class="form-control" ng-model="registro.longitud" name="longitud" id="addForm-longitud">
        			                <span class="text-input-alt" ng-if="registro.es_similar == 1">@{{registro.longitud2}}</span>
        			            </div>
        			                
        			        </div>
        				</div>
    					
          <!--              <div class="row">-->
          <!--                  <div class="col-xs-12">-->
    						<!--	<table class="table table-striped">-->
    						<!--		<tr>-->
    						<!--			<th style="width: 50px;">Columna</th>                           -->
    						<!--			<th>Nuevo dato</th>-->
    						<!--			<th ng-if="registro.es_similar == 1">Similar</th>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Numero del RNT</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.numero_rnt" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.numero_rnt2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Estado</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.estado" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.estado2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Municipio</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.municipio" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.municipio2}}</td>-->
    						<!--		</tr>-->
    								<!--<tr>-->
    								<!--	<td>Departamento</td>-->
    								<!--	<td><input type="text" class="form-control" ng-model="registro.departamento" required></td>-->
    								<!--	<td ng-if="registro.es_similar == 1">@{{registro.departamento2}}</td>-->
    								<!--</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Nombre Comercial RNT</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.nombre_comercial" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.nombre_comercial2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Nombre Comercial Plataforma</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.nombre_comercial_plataforma" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.nombre_comercial_plataforma2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Categoría</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.categoria" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.categoria2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Subcategoría</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.sub_categoria" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.sub_categoria2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr ng-class="{'info': (registro.direccion_comercial == registro.direccion_comercial2 && registro.es_similar == 1) }">-->
    						<!--			<td>Dirección Comercial</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.direccion_comercial" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.direccion_comercial2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Teléfono</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.telefono" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.telefono2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Celular</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.celular" required></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.celular2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr ng-class="{'info': (registro.correo == registro.correo2 && registro.es_similar == 1 && registro.correo.indexOf('@') > 0 ) }">-->
    						<!--			<td>Correo Electronico</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.correo" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.correo2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Latitud</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.latitud"  ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.latitud2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Longitud</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.longitud"  ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.longitud2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr ng-class="{'info': (registro.digito_verificacion == registro.digito_verificacion2 && registro.es_similar == 1) }">-->
    						<!--			<td>Digito verificación</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.digito_verificacion" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.digito_verificacion2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr ng-class="{'info': (registro.nit == registro.nit2 && registro.es_similar == 1) }">-->
    						<!--			<td>NIT</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.nit" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.nit2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Nombre gerente</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.nombre_gerente" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.nombre_gerente2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Ultimo año RNT</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.ultimo_anio_rnt" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.ultimo_anio_rnt2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Sostenibilidad RNT</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.sostenibilidad_rnt" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.sostenibilidad_rnt2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Turísmo aventura</td>-->
    						<!--			<td><input type="text" class="form-control" ng-model="registro.turismo_aventura" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.turismo_aventura2}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Hab2</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.hab2" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.hab22}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Cam2</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.cam2" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.cam22}}</td>-->
    						<!--		</tr>-->
    						<!--		<tr>-->
    						<!--			<td>Emp2</td>-->
    						<!--			<td><input type="number" class="form-control" ng-model="registro.emp2" required ></td>-->
    						<!--			<td ng-if="registro.es_similar == 1">@{{registro.emp22}}</td>-->
    						<!--		</tr>-->
    						<!--	</table>-->
    						<!--</div>-->
          <!--              </div>-->
                        
                        <div class="row">
                            <ng-map id="mapa" zoom="9" center="[11.24079, -74.19904]" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
                                <marker ng-if="registro.latitud != undefined && registro.longitud != undefined" draggable="true" on-dragend="getCurrentLocation(registro)" position="[@{{registro.latitud}}, @{{registro.longitud}}]" title="registro.nombre_comercial"></marker>
                                
                                <drawing-manager ng-if="registro.latitud == undefined && registro.longitud == undefined"
                                    on-overlaycomplete="drawFinish(registro)"
                                    drawing-control-options="{position: 'TOP_CENTER',drawingModes:['marker']}"
                                    drawingControl="true"
                                    drawingMode="null"
                                    rectangleOptions="{fillColor:'red'}" >
                                </drawing-manager>
                                
                            </ng-map>
                        </div>
                        
                        <div class="row" ng-if="registro.es_correcto != 1">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="observacion">Observación</label>
                                    <textarea class="form-control" id="observacion" rows="3" readonly>@{{registro.campos}}</textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" ng-if="registro.es_similar == 1" ng-click="guardarRegistroHavilitar()">Guardar y deshabilitar similar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarRegistro()">Guardar como nuevo</button>
                        <button type="submit" class="btn btn-info" ng-if="registro.es_similar == 1" ng-click="sobreescribirRegistro()">Sobreescribir similar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal ver registro-->
    <div class="modal fade bs-example-modal-lg" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				<h4 class="modal-title" id="myModalLabel">Ver registro</h4>
    			</div>
    			
    			<div class="modal-body">
    			    <div class="row">
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">No. de RNT</label>
    			                <p class="form-control-static">@{{registro.numero_rnt}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Estado</label>
    			                <p class="form-control-static">@{{registro.estado}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">NIT</label>
    			                <p class="form-control-static">@{{registro.nit}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Municipio</label>
    			                <p class="form-control-static">@{{registro.municipio}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-12">
    			            <div class="form-group">
    			                <label class="control-label">Nombre comercial</label>
    			                <p class="form-control-static">@{{registro.nombre_comercial}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-12" ng-if="registro.nombre_comercial_plataforma != ''">
    			            <div class="form-group">
    			                <label class="control-label">Nombre comercial plataforma</label>
    			                <p class="form-control-static">@{{registro.nombre_comercial_plataforma}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-6">
    			            <div class="form-group">
    			                <label class="control-label">Categoría</label>
    			                <p class="form-control-static">@{{registro.categoria}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-6">
    			            <div class="form-group">
    			                <label class="control-label">Subcategoría</label>
    			                <p class="form-control-static">@{{registro.sub_categoria}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-6">
    			            <div class="form-group">
    			                <label class="control-label">Dirección comercial</label>
    			                <p class="form-control-static">@{{registro.direccion_comercial}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Teléfono</label>
    			                <p class="form-control-static">@{{registro.telefono}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Celular</label>
    			                <p class="form-control-static">@{{registro.celular}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-6">
    			            <div class="form-group">
    			                <label class="control-label">Nombre del gerente</label>
    			                <p class="form-control-static">@{{registro.nombre_gerente}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-6">
    			            <div class="form-group">
    			                <label class="control-label">Correo electrónico</label>
    			                <p class="form-control-static">@{{registro.correo}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Dígito verificación</label>
    			                <p class="form-control-static">@{{registro.digito_verificacion}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Último año RNT</label>
    			                <p class="form-control-static">@{{registro.ultimo_anio_rnt}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Sostenibilidad RNT</label>
    			                <p class="form-control-static">@{{registro.sostenibilidad_rnt}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3">
    			            <div class="form-group">
    			                <label class="control-label">Turísmo aventura</label>
    			                <p class="form-control-static">@{{registro.turismo_aventura}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3" ng-if="registro.latitud != undefined">
    			            <div class="form-group">
    			                <label class="control-label">Latitud</label>
    			                <p class="form-control-static">@{{registro.latitud}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3" ng-if="registro.latitud != undefined">
    			            <div class="form-group">
    			                <label class="control-label">Longitud</label>
    			                <p class="form-control-static">@{{registro.longitud}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3" ng-if="registro.hab2 != undefined">
    			            <div class="form-group">
    			                <label class="control-label">Hab2</label>
    			                <p class="form-control-static">@{{registro.hab2}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3" ng-if="registro.cam2 != undefined">
    			            <div class="form-group">
    			                <label class="control-label">Cam2</label>
    			                <p class="form-control-static">@{{registro.cam2}}</p>
    			            </div>
    			        </div>
    			        <div class="col-xs-12 col-sm-3" ng-if="registro.emp2 != undefined">
    			            <div class="form-group">
    			                <label class="control-label">Emp2</label>
    			                <p class="form-control-static">@{{registro.emp2}}</p>
    			            </div>
    			        </div>
    			    </div>
    				
    				
    				<div class="row" ng-show="registro.latitud != undefined && registro.longitud != undefined">
                        <ng-map id="mapa" zoom="9" center="[11.24079, -74.19904]" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
                            <marker ng-if="registro.latitud != undefined && registro.longitud != undefined"  position="[@{{registro.latitud}}, @{{registro.longitud}}]" title="registro.nombre_comercial"></marker>
                        </ng-map>
                    </div>
    				
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class='carga'>

    </div>

@endsection


@section('javascript')

    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ng-map.min.js')}}"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    
    
    <script src="{{asset('/js/importacionRnt/importarRnt.js')}}"></script>
    <script src="{{asset('/js/importacionRnt/proveedorService.js')}}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imagen").change(function () {
            readURL(this);
        });

        $(document).on('change', ':file', function () {
          
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });
        $(document).ready(function () {

            $('[data-toggle="popover"]').popover();
            

            
            $(':file').on('fileselect', function (event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    //if (log) alert(log);
                }

            });

        });

    </script>
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
@endsection