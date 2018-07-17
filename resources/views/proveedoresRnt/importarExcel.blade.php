
@extends('layout._AdminLayout')

@section('title', 'Importación RNT')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

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

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('TitleSection', 'Importación RNT')

@section('app','ng-app="importarRntApp"')

@section('controller','ng-controller="importarRnt"')

@section('content')

<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

<div class="container">
    <h1 class="title1">Importar RNT</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="u-block">Adjuntar soporte</label>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                Seleccionar archivo <input type="file" id="soporte" name="soporte" file-input='soporte' style="display: none;" accept=".csv">
                            </span>
                        </label>
                        <input id="nombreArchivoSeleccionado" ng-model="nombreArchivoSeleccionado" type="text" class="form-control" placeholder="Peso máximo 10MB" readonly>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-raised btn-primary" ng-click="cargarDocumento()">Cargar</button>
            </div>
        </div>
        
        <div class="row" ng-if="nuevos.length > 0">
            <h1 class="title1">Registros nuevos</h1>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                    <input type="text" style="margin-bottom: .5em;" ng-model="prop.search" class="form-control" id="inputSearch" placeholder="Buscar registro...">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                    <span class="chip" style="margin-bottom: .5em;">@{{(nuevos|filter:prop.search).length}} resultados</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 50px;"></th>                           
                            <th>Número de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Sub-Categoría</th>
                            <th>Categoría</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th style="width: 150px;">Estado carga</th>
                            <th style="width: 70px;"></th>
                        </tr>
                        <tr dir-paginate="item in nuevos|filter:prop.search|itemsPerPage:10 as results" pagination-id="paginacion_nuevos" >
                            <td>@{{$index+1}}</td>
                            <td>@{{item.numero_rnt}}</td>
                            <td>@{{item.nombre_comercial}}</td>
                            <td>@{{item.sub_categoria}}</td>
                            <td>@{{item.categoria}}</td>
                            <td>@{{item.correo}}</td>
                            <td>@{{item.estado}}</td>
                            <td ng-if="item.es_correcto ==1">Correcto</td><td ng-if="item.es_correcto !=1">Incorrecto</td>
                            <td style="text-align: center;">
                                <a ng-if="item.es_correcto != 1" title="Agregar registro" ng-click="abrirModalCrear(item)"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a title="Ver registro" ng-click="abrirModalVer(item)"><span class="glyphicon glyphicon-eye-open"></span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="nuevos.length == 0 || (nuevos|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(nuevos|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
                </div>
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_nuevos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
        
        <div class="row" ng-if="antiguos.length > 0">
            <h1 class="title1">Registros antiguos</h1>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                    <input type="text" style="margin-bottom: .5em;" ng-model="prop.searchAntiguo" class="form-control" id="inputSearch" placeholder="Buscar registro...">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                    <span class="chip" style="margin-bottom: .5em;">@{{(antiguos|filter:prop.searchAntiguo).length}} resultados</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 50px;"></th>                           
                            <th>Número de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Sub-Categoría</th>
                            <th>Categoría</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th style="width: 70px;"></th>
                        </tr>
                        <tr dir-paginate="item in antiguos|filter:prop.searchAntiguo|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            <td>@{{$index+1}}</td>
                            <td>@{{item.numero_rnt}}</td>
                            <td>@{{item.nombre_comercial}}</td>
                            <td>@{{item.sub_categoria}}</td>
                            <td>@{{item.categoria}}</td>
                            <td>@{{item.correo}}</td>
                            <td>@{{item.estado}}</td>
                            <td style="text-align: center;">
                                <a title="Editar registro" ng-click="abrirModalEditar(item)"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a title="Ver registro" ng-click="abrirModalVer(item)"><span class="glyphicon glyphicon-eye-open"></span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="antiguos.length == 0 || (antiguos|filter:prop.searchAntiguo).length == 0">No hay resultados disponibles <span ng-show="(antiguos|filter:prop.searchAntiguo).length == 0">para la búsqueda '@{{prop.searchAntiguo}}'. <a href="#" ng-click="prop.searchAntiguo = ''">Presione aquí</a> para ver todos los resultados.</span></div>
                </div>
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_antiguos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
        
    </div>
    
    

    <!-- Modal editar registro-->
    <div class="modal fade bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar registro</h4>
                </div>
                
                <form role="form" name="editarForm" novalidate>
                    <div class="modal-body">
    					
    				    <div class="row">
    				        <div class="col-xs-12">
    				            <div class="alert alert-warning">
                					En esta ventana puede verificar los datos a editar en cada registro. Si considera que el registro puede ser editado presione el botón 'Editar'.
                				</div> 
    				        </div>
    				    </div>	
    					
                        <div class="row">
                            <div class="col-xs-12">
    							<table class="table table-striped">
    								<tr>
    									<th style="width: 50px;">Columna</th>                           
    									<th>Nuevo dato</th>
    								</tr>
    								<tr>
    									<td>Numero del RNT</td>
    									<td><input type="text" class="form-control" ng-model="registro.numero_rnt" required></td>
    									<td>@{{registro.numero_rnt2}}</td>
    								</tr>
    								<tr ng-class="{'danger': (registro.estado != registro.estado2) }">
    									<td>Estado</td>
    									<td><input type="text" class="form-control" ng-model="registro.estado" required></td>
    									<td>@{{registro.estado2}}</td>
    								</tr>
    								<tr ng-class="{'danger': (registro.municipio != registro.municipio2) }">
    									<td>Municipio</td>
    									<td><input type="text" class="form-control" ng-model="registro.municipio" required></td>
    									<td>@{{registro.municipio2}}</td>
    								</tr>
    								<tr ng-class="{'danger': (registro.departamento != registro.departamento2) }">
    									<td>Departamento</td>
    									<td><input type="text" class="form-control" ng-model="registro.departamento" required></td>
    									<td>@{{registro.departamento2}}</td>
    								</tr>
    								<tr ng-class="{'danger': (registro.nombre_comercial != registro.nombre_comercial2) }">
    									<td>Nombre Comercial RNT</td>
    									<td><input type="text" class="form-control" ng-model="registro.nombre_comercial" required></td>
    									<td>@{{registro.nombre_comercial2}}</td>
    								</tr>
    								<tr>
    									<td>Nombre Comercial Plataforma</td>
    									<td><input type="text" class="form-control" ng-model="registro.nombre_comercial_plataforma" required></td>
    									<td>@{{registro.nombre_comercial_plataforma2}}</td>
    								</tr>
    								<tr>
    									<td>Categoría</td>
    									<td><input type="text" class="form-control" ng-model="registro.categoria" required></td>
    									<td>@{{registro.categoria2}}</td>
    								</tr>
    								<tr>
    									<td>Subcategoría</td>
    									<td><input type="text" class="form-control" ng-model="registro.sub_categoria" required></td>
    									<td>@{{registro.sub_categoria2}}</td>
    								</tr>
    								<tr>
    									<td>Dirección Comercial</td>
    									<td><input type="text" class="form-control" ng-model="registro.direccion_comercial" required></td>
    									<td>@{{registro.direccion_comercial2}}</td>
    								</tr>
    								<tr>
    									<td>Teléfono</td>
    									<td><input type="text" class="form-control" ng-model="registro.telefono" required></td>
    									<td>@{{registro.telefono2}}</td>
    								</tr>
    								<tr>
    									<td>Celular</td>
    									<td><input type="text" class="form-control" ng-model="registro.celular" required></td>
    									<td>@{{registro.celular2}}</td>
    								</tr>
    								<tr>
    									<td>Correo Electronico</td>
    									<td><input type="text" class="form-control" ng-model="registro.correo" required ></td>
    									<td>@{{registro.correo2}}</td>
    								</tr>
    								<tr>
    									<td>Latitud</td>
    									<td><input type="text" class="form-control" ng-model="registro.latitud" required ></td>
    									<td>@{{registro.latitud2}}</td>
    								</tr>
    								<tr>
    									<td>Longitud</td>
    									<td><input type="text" class="form-control" ng-model="registro.longitud" required ></td>
    									<td>@{{registro.longitud2}}</td>
    								</tr>
    							</table>
    						</div>
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
    <div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar registro</h4>
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
                            <div class="col-xs-12">
    							<table class="table table-striped">
    								<tr>
    									<th style="width: 50px;">Columna</th>
    									<th>Dato almacenado</th>
    								</tr>
    								<tr>
    									<td>Numero del RNT</td>
    									<td><input type="text" class="form-control" ng-model="registro.numero_rnt" required></td>
    								</tr>
    								<tr>
    									<td>Estado</td>
    									<td><input type="text" class="form-control" ng-model="registro.estado" required></td>
    								</tr>
    								<tr>
    									<td>Municipio</td>
    									<td><input type="text" class="form-control" ng-model="registro.municipio" required></td>
    								</tr>
    								<tr>
    									<td>Departamento</td>
    									<td><input type="text" class="form-control" ng-model="registro.departamento" required></td>
    								</tr>
    								<tr>
    									<td>Nombre Comercial RNT</td>
    									<td><input type="text" class="form-control" ng-model="registro.nombre_comercial" required></td>
    								</tr>
    								<tr>
    									<td>Nombre Comercial Plataforma</td>
    									<td><input type="text" class="form-control" ng-model="registro.nombre_comercial_plataforma" required></td>
    								</tr>
    								<tr>
    									<td>Categoría</td>
    									<td><input type="text" class="form-control" ng-model="registro.categoria" required></td>
    								</tr>
    								<tr>
    									<td>Subcategoría</td>
    									<td><input type="text" class="form-control" ng-model="registro.sub_categoria" required></td>
    								</tr>
    								<tr>
    									<td>Dirección Comercial</td>
    									<td><input type="text" class="form-control" ng-model="registro.direccion_comercial" required></td>
    								</tr>
    								<tr>
    									<td>Teléfono</td>
    									<td><input type="text" class="form-control" ng-model="registro.telefono" required></td>
    								</tr>
    								<tr>
    									<td>Celular</td>
    									<td><input type="text" class="form-control" ng-model="registro.celular" required></td>
    								</tr>
    								<tr>
    									<td>Correo Electronico</td>
    									<td><input type="text" class="form-control" ng-model="registro.correo" required ></td>
    								</tr>
    								<tr>
    									<td>Latitud</td>
    									<td><input type="text" class="form-control" ng-model="registro.latitud" required ></td>
    								</tr>
    								<tr>
    									<td>Longitud</td>
    									<td><input type="text" class="form-control" ng-model="registro.longitud" required ></td>
    								</tr>
    							</table>
    						</div>
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
                        <button type="submit" class="btn btn-success" ng-click="guardarRegistro()">Guardar</button>
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
    					<div class="col-xs-12">
    						<table class="table table-striped">
    							<tr>
    								<th style="width: 50px;">Columna</th>
    								<th>Dato almacenado</th>
    							</tr>
    							<tr>
    								<td>Numero del RNT</td>
    								<td>@{{registro.numero_rnt}}</td>
    							</tr>
    							<tr>
    								<td>Estado</td>
    								<td>@{{registro.estado}}</td>
    							</tr>
    							<tr>
    								<td>Municipio</td>
    								<td>@{{registro.municipio}}</td>
    							</tr>
    							<tr>
    								<td>Departamento</td>
    								<td>@{{registro.departamento}}</td>
    							</tr>
    							<tr>
    								<td>Nombre Comercial RNT</td>
    								<td>@{{registro.nombre_comercial}}</td>
    							</tr>
    							<tr>
    								<td>Nombre Comercial Plataforma</td>
    								<td>@{{registro.nombre_comercial_plataforma}}</td>
    							</tr>
    							<tr>
    								<td>Categoría</td>
    								<td>@{{registro.categoria}}</td>
    							</tr>
    							<tr>
    								<td>Subcategoría</td>
    								<td>@{{registro.sub_categoria}}</td>
    							</tr>
    							<tr>
    								<td>Dirección Comercial</td>
    								<td>@{{registro.direccion_comercial}}</td>
    							</tr>
    							<tr>
    								<td>Teléfono</td>
    								<td>@{{registro.telefono}}</td>
    							</tr>
    							<tr>
    								<td>Celular</td>
    								<td>@{{registro.celular}}</td>
    							</tr>
    							<tr>
    								<td>Correo Electronico</td>
    								<td>@{{registro.correo}}</td>
    							</tr>
    							<tr>
    								<td>Latitud</td>
    								<td>@{{registro.latitud}}</td>
    							</tr>
    							<tr>
    								<td>Longitud</td>
    								<td>@{{registro.longitud}}</td>
    							</tr>
    						</table>
    					</div>
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
</div>

@endsection


@section('javascript')
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
@endsection