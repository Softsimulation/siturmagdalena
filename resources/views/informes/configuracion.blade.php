
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', "Administración de informes" )
@section('app','ng-app="AppInformes"')
@section('controller','ng-controller="InformesAdminCtrl"')

@section('estilos')

  <style>
        .view-list > .description > .buttons {
            width: 100% !important;
        }

        .view-list > .description > .buttons > .button-sm, .buttons > .button-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: orange;
            border: none;
            text-align: center;
            font-weight: bold;
            padding-top: 2px;
            text-decoration: none;
            color: black;
            margin: 3px;
        }

        .view-list > .description > .buttons > .button-lang,.buttons > .button-lang  {
            background-color: white;
            border: 2px solid orange;
            padding: 0;
        }

        .view-list > .description > .buttons > a.button-sm,.buttons > a.button-sm {
            padding: 0;
            color: black;
            font-size: 1.1em;
            padding-top: .2em;
        }

        .view-list > .description > .buttons > .button-sm:hover,.buttons > .button-sm:hover {
            box-shadow: 0px 0px 3px rgba(0,0,0,0.65);
        }
        .panel-body {
            max-height: none;
            box-shadow: 0px 0px 4px rgba(0,0,0,.35);
            color: dimgray;
        }

        .breadcrumb {
            margin-top: .5em;
            margin-bottom: .5em;
            border-radius: 20px;
        }
        .row {
            margin-top: 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
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
        p {
            font-size: .9em;
        }
    </style>

@endsection

@section('content')
<div class="main-page" >
    <h1 class="title1">Listado de informes</h1>
    <br />
     
    @if ( session('post') == true ) 
        @if ( session('success') == true )
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Registro guardado exitosamente!</strong> {{ session('mensaje') }}
            </div>
        @else
           <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error al guardar registro!</strong> {{ session('mensaje') }}
            </div>
        @endif
    @endif
    
    <div class="row">
        <button type="button" class="btn btn-primary" data-target="#modalCrear" data-toggle="modal" data-placement="bottom" title="Crear Informe">Añadir informe</button>
    </div>
    <br />
    <div class="row">
        <div class="col-xs-12 col-md-12">

        </div>
        <div class="col-xs-12 col-md-12" dir-paginate="informe in informes | itemsPerPage: 8 as fTexto">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3" style="text-align: center; overflow: hidden;">
                            <img alt="Portada no disponible" ng-src="@{{informe.portada}}" class="img-rounded" width="180"/>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-9">

                            <h3 style="overflow: hidden; text-overflow: ellipsis;white-space: nowrap"><strong>@{{ (informe.idiomas|filter:{'idioma_id':1}:true)[0].nombre }} <small>Vol. @{{informe.volumen}}</small></strong></h3>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <ol class="breadcrumb">
                                        <li class="active"><i class="glyphicon glyphicon-user" title="@Resource.InformeTItleAutor"></i> @{{informe.autores}}</li>
                                    </ol>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <ol class="breadcrumb">
                                        <li class="active"><i class="glyphicon glyphicon-calendar" title="@Resource.InformeTitleFechaPublicacion"></i> @{{informe.fecha_publicacion|date:shortDate}}</li>
                                    </ol>
                                </div>
                            </div>
                            <p class="text-justify">@{{ (informe.idiomas|filter:{'idioma_id':1}:true)[0].descripcion }}</p>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-9" style="padding: 0;">
                                    <span class="label label-primary"><b>Tipo:</b> @{{informe.tipo.tipo_documento_idiomas[0].nombre}}</span>
                                    <span class="label label-primary"><b>Categoria:</b> @{{informe.categoria.categoria_documento_idiomas[0].nombre}}</span>
                                    <span class="label label-primary"><b>Periodo:</b> @{{informe.fecha_creacion|date:'MMMM/yyyy'}}</span>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12" style="text-align: right; margin-top: 1em;">
                                    <div class="buttons">
                                        <button ng-if="informe.estado" type="button" class="btn btn-danger" ng-click="cambiarEstado(informe)">Desactivar</button>
                                        <button ng-if="!informe.estado" type="button" class="btn btn-success" ng-click="cambiarEstado(informe)">Activar</button>
                                        <button type="button" ng-repeat="i in informe.idiomas" class="btn button-sm button-lang" ng-click="ModalIdiomas(i, informe)" >
                                            @{{i.idioma.culture}}
                                        </button>
                                        <button type="button" class="button-sm" ng-click="ModalIdiomas(null,informe)" ng-if="informe.idiomas.length<idiomas.length" title="Ingresar idioma"><span class="glyphicon glyphicon-plus"></span></button>
                                        <button type="button" class="button-sm" ng-click="ModalEliminarIdioma(informe)"  ng-if="informe.idiomas.length > 1" title="Eliminar información de un idioma"><span class="glyphicon glyphicon-minus"></span></button>

                                        <button type="button" class="button-sm" data-target="#modalEditar" ng-click="editarInforme(informe)" data-toggle="modal" data-placement="bottom" title="Editar informe"><span class="glyphicon glyphicon-edit"></span></button>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
   
    <div class="row">

        <dir-pagination-controls max-size="8"
                                 direction-links="true"
                                 boundary-links="true">
        </dir-pagination-controls>

    </div>

            <!-- Modal -->
            <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">SUBIR INFORME</h4>
                        </div>
                        <form role="form" name="formeCrearInf" action = "/informes/crear" method="post" enctype="multipart/form-data" >
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                        <div ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Titulo.$touched) && formeCrearInf.Titulo.$error.required]">
                                            <label class="control-label" for="Titulo">Título</label> <span style="font-size: .6em;color: darkgrey;" ng-if="addInformeTitulo.length > 0">@{{addInformeTitulo.length}} / 255</span><span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Titulo.$touched) && formeCrearInf.Titulo.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="text" class="form-control" name="Titulo" id="Titulo" maxlength="255" ng-model="addInformeTitulo" placeholder="Ingrese el titulo del informe" required/>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.Titulo.$touched) && formeCrearInf.Titulo.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Volumen.$touched) && formeCrearInf.Volumen.$error.required]">
                                            <label class="control-label" for="Volumen">Volumen</label> <span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Volumen.$touched) && formeCrearInf.Volumen.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="number" class="form-control" name="Volumen" id="Volumen" ng-model="addInformeVolumen" placeholder="Solo números" min="0" required />
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.Volumen.$touched) && formeCrearInf.Volumen.$error.required"></span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Autor.$touched) && formeCrearInf.Autor.$error.required]">
                                            <label class="control-label" for="autor">Autor</label> <span style="font-size: .6em;color: darkgrey;" ng-if="addInformeAutor.length > 0">@{{addInformeAutor.length}} / 255</span><span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Autor.$touched) && formeCrearInf.Autor.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="text" class="form-control" name="Autor" id="autor" maxlength="255" ng-model="addInformeAutor" placeholder="Ingrese el autor del informe" required/>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.Autor.$touched) && formeCrearInf.Autor.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.FechaCreacion.$touched) && formeCrearInf.FechaCreacion.$error.required]">
                                            <label class="control-label" for="FechaCreacion">Fecha de creación</label> <span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.FechaCreacion.$touched) && formeCrearInf.FechaCreacion.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <adm-dtp ng-model="addInformeFechaCreacion" full-data='date_details'>
                                                    <input type='text' class="form-control" name="FechaCreacion" id="FechaCreacion" ng-model="addInformeFechaCreacion" dtp-input required placeholder="dd-mm-yyyy" />
                                                </adm-dtp>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.FechaCreacion.$touched) && formeCrearInf.FechaCreacion.$error.required"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.FechaPublicacion.$touched) && formeCrearInf.FechaPublicacion.$error.required]">
                                            <label class="control-label" for="FechaPublicacion">Fecha de publicación</label> <span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.FechaPublicacion.$touched) && formeCrearInf.FechaPublicacion.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <adm-dtp ng-model="addInformeFechaPublicacion" full-data='date_details'>
                                                    <input type='text' class="form-control" name="FechaPublicacion" id="FechaPublicacion" ng-model="addInformeFechaPublicacion" dtp-input required placeholder="dd-mm-yyyy" />
                                                </adm-dtp>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.FechaPublicacion.$touched) && formeCrearInf.FechaPublicacion.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="alert alert-dismissible alert-default" style="background-color: rgba(255, 255, 0,.5); box-shadow: 0px 0px 4px rgba(0,0,0,.45); margin-bottom:0;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <h4><strong>Tenga en cuenta que para subir documentos:</strong></h4>
                                            <ul style="margin-left: 4%; font-size: .9em;">
                                                <li>Los documentos subidos deben ser de formato PDF.</li>
                                                <li>Se recomienda que el archivos a subir sea comprimido para reducir su peso. Para comprimir los archivos PDF se recomienda el uso de <a target="_blank" href="http://www.ilovepdf.com/compress_pdf">I<i class="glyphicon glyphicon-heart"></i>PDF <i class="glyphicon glyphicon-new-window" style="font-size: 1em"></i></a>, <a target="_blank" href="https://smallpdf.com/compress-pdf">SmallPDF <i class="glyphicon glyphicon-new-window" style="font-size: 1em"></i></a> o cualquier otro compresor de PDF.</li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" >
                                    <div class="col-xs-12 col-sm-12 col-md-8" >
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Tipo.$touched) && formeCrearInf.Tipo.$error.required]">
                                                    <label class="control-label" for="Tipo">Tipo de documento</label> <span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Tipo.$touched) && formeCrearInf.Tipo.$error.required">(El campo es obligatorio)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                        <select class="form-control" name="Tipo" id="Tipo" ng-model="addInformeTipoDoc" required>
                                                            <option value="" disabled>Seleccione un tipo</option>
                                                            <option ng-repeat="tipo in tipos" value="@{{tipo.id}}">@{{tipo.tipo_documento_idiomas[0].nombre}}</option>
                                                        </select>
                                                        <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.Tipo.$touched) && formeCrearInf.Tipo.$error.required"></span>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Categoria.$touched) && formeCrearInf.Tipo.$error.required]">
                                                    <label class="control-label" for="Categoria">Categoría de documento</label> <span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Categoria.$touched) && formeCrearInf.Categoria.$error.required">(Obligatorio)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                        <select class="form-control" name="Categoria" id="Categoria" ng-model="addInformeCategoria" required>
                                                            <option value="" disabled>Seleccione una categoría</option>
                                                            <option ng-repeat="ctg in categorias"value="@{{ctg.id}}">@{{ctg.categoria_documento_idiomas[0].nombre}}</option>
                                                        </select>
                                                        <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formeCrearInf.$submitted || formeCrearInf.Categoria.$touched) && formeCrearInf.Categoria.$error.required"></span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4" >
                                        <div class="form-group">
                                            <label>Portada</label><span style="font-size: .6em;color: darkgrey;">(Formato permitido: PNG, JPG)</span>
                                            <input type="file" class="form-control" name="Portada" id="Portada" accept=".jpg,.jpeg,.png" required />
                                            <span class="messages" ng-show="formeCrearInf.$submitted || formeCrearInf.Portada.$touched">
                                                <span ng-show="formeCrearInf.Portada.$error.required">* El campo es obligatorio.</span>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label>Documento</label><span style="font-size: .6em;color: darkgrey;">(Formato permitido: PDF)</span>
                                            <input type="file" class="form-control" name="Archivo" id="Archivo" accept=".pdf" required />
                                            <span class="messages" ng-show="formeCrearInf.$submitted || formeCrearInf.Archivo.$touched">
                                                <span ng-show="formeCrearInf.Archivo.$error.required">* El campo es obligatorio.</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.Descripcion.$touched) && formeCrearInf.Descripcion.$error.required]">
                                            <label class="control-label" for="Descripcion">Descripción</label> <span style="font-size: .6em;color: darkgrey;" ng-if="addInformeDescripcion.length > 0">@{{addInformeDescripcion.length}} / 500</span><span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.Descripcion.$touched) && formeCrearInf.Descripcion.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <textarea class="form-control" style="resize: none" name="Descripcion" id="Descripcion" ng-model="addInformeDescripcion" rows="6" maxlength="500" placeholder="Máx 500 caracteres" required></textarea>
                                                
                                            </div>

                                        </div>

                                    </div>
                                
                                    <div class="col-xs-6">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formeCrearInf.$submitted || formeCrearInf.PalabrasClaves.$touched) && formeCrearInf.PalabrasClaves.$error.required]">
                                            <label class="control-label" for="PalabrasClaves">Palabras clave</label> <span style="font-size: .6em;color: darkgrey;" ng-if="addInformePalabrasClaves.length > 0">@{{addInformePalabrasClaves.length}} / 500</span><span class="text-error" ng-show="(formeCrearInf.$submitted || formeCrearInf.PalabrasClaves.$touched) && formeCrearInf.PalabrasClaves.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <textarea class="form-control" style="resize: none" name="PalabrasClaves" id="PalabrasClaves" ng-model="addInformePalabrasClaves" rows="6" maxlength="500" placeholder="Máx 500 caracteres. Separe las palabras clave por comas." required></textarea>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--MODAL EDITAR INFORME-->
            <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">EDITAR INFORME</h4>
                        </div>
                        <form method="post" name="editarForm" action="/informes/editar" enctype="multipart/form-data">
                            <div class="modal-body">

                                <input type="hidden"  name="id" id="id" ng-value="informeEdit.id"  />
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">Título</label> <abbr title="El título del informe se puede modificar al momento de editar la información de los idiomas"><span class="glyphicon glyphicon-exclamation-sign"></span></abbr>
                                            <p class="form-control-static" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">@{{ (informeEdit.idiomas|filter:{'idioma_id':1}:true)[0].nombre }}</p>

                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.Volumen.$touched) && editarForm.Volumen.$error.required]">
                                            <label class="control-label" for="editVolumen">Volumen</label> <span class="text-error" ng-show="(editarForm.$submitted || editarForm.Volumen.$touched) && editarForm.Volumen.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="number" class="form-control" name="volumen" id="editVolumen" ng-model="informeEdit.volumen" placeholder="Solo números" min="0" required />
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.Volumen.$touched) && editarForm.Volumen.$error.required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.Autor.$touched) && editarForm.Autor.$error.required]">
                                            <label class="control-label" for="editAutor">Autor</label> <span style="font-size: .6em;color: darkgrey;" ng-if="informeEdit.Autor.length > 0">@{{informeEdit.Autor.length}} / 255</span><span class="text-error" ng-show="(editarForm.$submitted || editarForm.Autor.$touched) && editarForm.Autor.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="text" class="form-control" name="autores" id="editAutor" maxlength="255" ng-model="informeEdit.autores" placeholder="Ingrese el autor del informe" required />
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.Autor.$touched) && editarForm.Autor.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.fechaCreacion.$touched) && editarForm.fechaCreacion.$error.required]">
                                            <label class="control-label" for="fechaCreacion">Fecha de creación</label> <span class="text-error" ng-show="(editarForm.$submitted || editarForm.fechaCreacion.$touched) && editarForm.fechaCreacion.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <adm-dtp ng-model="informeEdit.fecha_creacion" full-data='date_details'>
                                                    <input type='text' class="form-control" name="fechaCreacion" id="fechaCreacion" ng-model="informeEdit.fecha_creacion" dtp-input required placeholder="dd-mm-yyyy" />
                                                </adm-dtp>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.fechaCreacion.$touched) && editarForm.fechaCreacion.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.fechaPublicacion.$touched) && editarForm.fechaPublicacion.$error.required]">
                                            <label class="control-label" for="fechaPublicacion">Fecha de publicación</label> <span class="text-error" ng-show="(editarForm.$submitted || editarForm.fechaPublicacion.$touched) && editarForm.fechaPublicacion.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <adm-dtp ng-model="informeEdit.fecha_publicacion" full-data='date_details'>
                                                    <input type='text' class="form-control" name="fechaPublicacion" id="fechaPublicacion" ng-model="informeEdit.fecha_publicacion" dtp-input required placeholder="dd-mm-yyyy" />
                                                </adm-dtp>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.fechaPublicacion.$touched) && editarForm.fechaPublicacion.$error.required"></span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="alert alert-dismissible alert-default" style="background-color: rgba(255, 255, 0,.5); box-shadow: 0px 0px 4px rgba(0,0,0,.45); margin-bottom:0;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <h4><strong>Tenga en cuenta que para subir documentos:</strong></h4>
                                            <ul style="margin-left: 4%; font-size: .9em;">
                                                <li>Los documentos subidos deben ser de formato PDF.</li>
                                                <li>Se recomienda que el archivos a subir sea comprimido para reducir su peso. Para comprimir los archivos PDF se recomienda el uso de <a target="_blank" href="http://www.ilovepdf.com/compress_pdf">I<i class="glyphicon glyphicon-heart"></i>PDF <i class="glyphicon glyphicon-new-window" style="font-size: 1em"></i></a>, <a target="_blank" href="https://smallpdf.com/compress-pdf">SmallPDF <i class="glyphicon glyphicon-new-window" style="font-size: 1em"></i></a> o cualquier otro compresor de PDF.</li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.IdTipo.$touched) && editarForm.Tipo.$error.required]">
                                            <label class="control-label" for="editTipo">Tipo de documento</label> <span class="text-error" ng-show="(editarForm.$submitted || editarForm.Tipo.$touched) && editarForm.Tipo.$error.required">(El campo es obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <select class="form-control" name="Tipo" id="editTipo" ng-model="informeEdit.tipo_documento_id" required>
                                                    <option value="" disabled>Seleccione un tipo</option>
                                                    <option ng-repeat="tipo in tipos" value='@{{tipo.id}}' >@{{tipo.tipo_documento_idiomas[0].nombre}}</option>
                                                </select>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.Tipo.$touched) && editarForm.Tipo.$error.required"></span>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Documento</label> <span style="font-size: .6em;color: darkgrey;">(Formato permitido: PDF)</span>
                                            <input type="file" class="form-control" name="Archivo" id="Archivo" accept=".pdf" />
                                            <span class="messages" ng-show="formeCrearInf.$submitted || formeCrearInf.Archivo.$touched">
                                                <span ng-show="formeCrearInf.Archivo.$error.required">* El campo es obligatorio.</span>
                                            </span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(editarForm.$submitted || editarForm.Categoria.$touched) && editarForm.Categoria.$error.required]">
                                            <label class="control-label" for="editCategoria">Categoría de documento</label> <span class="text-error" ng-show="(editarForm.$submitted || editarForm.Categoria.$touched) && editarForm.Categoria.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <select class="form-control" name="Categoria" id="editCategoria" ng-model="informeEdit.categoria_doucmento_id" required>
                                                    <option value="" disabled>Seleccione una categoría</option>
                                                    <option ng-repeat="ctg in categorias" value='@{{ctg.id}}' >@{{ctg.categoria_documento_idiomas[0].nombre}}</option>
                                                </select>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarForm.$submitted || editarForm.Categoria.$touched) && editarForm.Categoria.$error.required"></span>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label>Portada</label> <span style="font-size: .6em;color: darkgrey;">(Formato permitido: PNG, JPG)</span>
                                            <input type="file" class="form-control" name="Portada" id="Portada" accept=".jpg,.jpeg,.png" />
                                            <span class="messages" ng-show="formeCrearInf.$submitted || formeCrearInf.Portada.$touched">
                                                <span ng-show="formeCrearInf.Portada.$error.required">* El campo es obligatorio.</span>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <label style="font-style: italic; font-size: .8em;">(Portada actual)</label>
                                        <img ng-src="@{{informeEdit.portada}}" width="180"  style="box-shadow: 0px 0px 3px 0px rgba(0,0,0,.45)"/>
                            
                                    </div>
                                        
                                </div>
                                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            
            <!--INSERTAR INFORMACIÓN DE IDIOMA DEL INFORME-->
             <div class="modal fade" id="modalIdioma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Idioma informe</h4>
                        </div>
                        <form role="form" name="formIdioma">
                            <div class="modal-body">
                                <div class="alert alert-danger" ng-if="errores != null">
                                    <label><b>Corrige los errores:</b></label>
                                    <br />
                                    <div ng-repeat="error in errores" ng-if="error.errores.length>0">
                                        -@{{error.errores[0].ErrorMessage}}
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class="col-xs-12">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formIdioma.$submitted || formIdioma.idoSelectCrear.$touched) && formIdioma.idoSelectCrear.$error.required]">
                                            <label class="control-label" for="addSelectedLang">Seleccione el idioma para el que quiere agregar información del informe</label> <span class="text-error" ng-show="(formIdioma.$submitted || formIdioma.idoSelectCrear.$touched) && editarForm.idoSelectCrear.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <select class="form-control" name="idoSelectCrear" id="addSelectedLang" ng-model="idiomaInforme.idioma_id" ng-options="idioma.id as idioma.nombre for idioma in idiomasFiltrados" ng-disabled="idiomaInforme.idioma" required >
                                                    <option value="" disabled>Seleccione un idioma</option>
                                                </select>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formIdioma.$submitted || formIdioma.idoSelectCrear.$touched) && formIdioma.idoSelectCrear.$error.required"></span>
                                            </div>

                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formIdioma.$submitted || formIdioma.tituloCrearIdo.$touched) && formIdioma.tituloCrearIdo.$error.required]">
                                            <label class="control-label" for="addLangTitulo">Título</label> <span style="font-size: .6em;color: darkgrey;" ng-if="idiomaInforme.nombre.length > 0">@{{idiomaInforme.nombre.length}} / 255</span><span class="text-error" ng-show="(formIdioma.$submitted || formIdioma.tituloCrearIdo.$touched) && formIdioma.tituloCrearIdo.$error.required">(Obligatorio)</span>
                                            <div class="input-group">
                                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                                <input type="text" name="tituloCrearIdo" id="addLangTitulo" class="form-control" ng-model="idiomaInforme.nombre" required/>
                                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(formIdioma.$submitted || formIdioma.tituloCrearIdo.$touched) && formIdioma.tituloCrearIdo.$error.required"></span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formIdioma.$submitted || formIdioma.descripCrearIdo.$touched) && formIdioma.descripCrearIdo.$error.required]">
                                            <label class="control-label" for="addLangDescripcion">Descripción</label> <span style="font-size: .6em;color: darkgrey;" ng-if="idiomaInforme.descripcion.length > 0">@{{idiomaInforme.descripcion.length}} / 500</span><span class="text-error" ng-show="(formIdioma.$submitted || formIdioma.descripCrearIdo.$touched) && formIdioma.descripCrearIdo.$error.required">(Obligatorio)</span>
                                            <textarea class="form-control" name="descripCrearIdo" id="addLangDescripcion" style="resize: none" rows="6" ng-model="idiomaInforme.descripcion" maxlength="500" placeholder="Máx 500 caracteres" required></textarea>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(formIdioma.$submitted || formIdioma.palabrasCrearIdo.$touched) && formIdioma.palabrasCrearIdo.$error.required]">
                                            <label class="control-label" for="addLangPalabrasClave">Palabras clave</label> <span style="font-size: .6em;color: darkgrey;" ng-if="idiomaInforme.palabrasclaves.length > 0">@{{idiomaInforme.palabrasclaves.length}} / 500</span><span class="text-error" ng-show="(formIdioma.$submitted || formIdioma.palabrasCrearIdo.$touched) && formIdioma.palabrasCrearIdo.$error.required">(Obligatorio)</span>
                                            <textarea class="form-control" name="palabrasCrearIdo" id="addLangPalabrasClave" style="resize: none" rows="4" ng-model="idiomaInforme.palabrasclaves" maxlength="500" placeholder="Máx 500 caracteres" required></textarea>

                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" ng-click="guardarIdioama()">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalEliminarIdioma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Eliminar idioma</h4>
                        </div>
                        <form role="form" name="formElIdioma">
                            <div class="modal-body">
                                <div class="alert alert-danger" ng-if="errores != null || err!=null">
                                    <label><b>Corrige los errores:</b></label>
                                    <br />
                                    <div ng-repeat="error in errores" ng-if="error.errores.length>0">
                                        -@{{error.errores[0].ErrorMessage}}
                                    </div>
                                    -@{{err}}
                                </div>
                                    <p>Seleccione el idioma para el que quiere eliminar información de actividad</p><br />
                                    <div class="form-group">
                                        <select class="form-control" ng-model="selectedIdiomaEliminar" required>
                                            <option value="" disabled selectd >-- Seleccione un idioma --</option>
                                            <option ng-repeat="item in informe.idiomas" value="@{{item.idioma_id}}" ng-if="item.idioma_id!=1">@{{item.idioma.nombre}}</option>
                                        </select>
                                        <span class="messages" ng-show="formElIdioma.$submitted || formElIdioma.selectedIdioma2.$touched">
                                            <span ng-show="formElIdioma.selectedIdioma2.$error.required">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" ng-click="eliminarIdioma()">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

</div>
@endsection


@section('javascript')
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/informes/servicios.js')}}"></script>
    <script src="{{asset('/js/informes/appAdmin.js')}}"></script>
@endsection
