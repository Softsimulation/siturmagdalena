
@extends('layout._AdminLayout')

@section('title', 'Editar proveedor')

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

@section('TitleSection', 'Editar idioma del proveedor')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="proveedoresApp"')

@section('controller','ng-controller="proveedoresIdiomaController"')

@section('titulo','Proveedores')
@section('subtitulo','Formulario para la modificación de información en otro idioma')

@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Idioma a modificar:</p>
        <h3 style="margin: 0">@{{idioma.nombre}}</h3>
    </div>
    
</div>
<input type="hidden" ng-model="id" ng-init="id={{$id}}" />
<input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>
</div>
<fieldset>
    <legend>Información básica</legend>
    <div class="alert alert-info">
        <p>Los campos marcados con asterisco (*) son obligatorios.</p>
    </div>
    <form novalidate role="form" name="editarProveedorForm">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.nombre.$touched) && editarProveedorForm.nombre.$error.required}">
                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                    <input max="150" ng-model="proveedor.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proveedor (Máximo 150 caracteres)"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="horario"> Horario</label>
                    <input max="255" ng-model="proveedor.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Horario del proveedor (Máximo 255 caracteres)"/>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.descripcion.$touched) && editarProveedorForm.descripcion.$error.required}">
                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                    <textarea min="100" max="1000" style="resize: none;" ng-model="proveedor.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del proveedor (De 100 a 1,000 caracteres)"></textarea>
                    
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <hr/>
                <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                <a href="{{asset('/administradorproveedores')}}" class="btn btn-lg btn-default">Cancelar</a>
            </div>
        </div>
    </form>
</fieldset>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/services.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
@endsection
