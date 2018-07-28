@extends('layout._sostenibilidadHogarLayout')

@section('title', 'SOSTENIBILIDAD DE LAS ACTIVIDADES TURÍSTICAS- HOGARES')


@section('estilos')
    <style>
        .title-section {
            background-color: #16469e !important;
        }
    </style>
    <style>
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

@section('TitleSection', '')

@section('Progreso', '0%')

@section('NumSeccion', '0')

@section('controller','ng-controller="crearController"')

@section('content')
<div class="container">
    
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
    <form name="crearForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Datos de la encuesta </b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">Fecha de aplicación</label>
                           <adm-dtp name="fecha" id="fecha" ng-model='social.fecha_aplicacion' mindate="'2017/01/01'" maxdate="@{{fechaActual}}" options="optionFecha" ng-required="true"></adm-dtp>
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.fecha.$touched">
                            <span class="label label-danger" ng-show="crearForm.fecha.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label" for="nombre">Nombre del encuestado</label>
                           <input type="text" name="nombre" id="nombre" class="form-control" ng-model="social.nombre_encuestado" ng-maxlength="250" placeholder="Ingrese el nombre. Máximo 150 caracteres" required />
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.nombre.$touched">
                            <span class="label label-danger" ng-show="crearForm.nombre.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="sexo">Género</label><br/>
                            <label class="radio-inline"><input type="radio" ng-model="social.sexo" ng-value="true" required name="sexo">Masculino</label>
                            <label class="radio-inline"><input type="radio" ng-model="social.sexo" ng-value="false" required name="sexo">Femenino</label>
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.sexo.$touched">
                            <span class="label label-danger" ng-show="crearForm.sexo.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Barrio</label>
                            <select name="barrios" class="form-control" id="barrios" ng-model="social.barrio_id" required ng-options="ite.id as ite.nombre for ite in barrios">
                                <option selected disable value="">Seleccione un barrio</option>
                            </select>
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.barrios.$touched">
                            <span class="label label-danger" ng-show="crearForm.barrios.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Estratos</label>
                            <select name="estratos" class="form-control" id="estratos" ng-model="social.estrato_id" required ng-options="ite.id as ite.nombre for ite in estratos">
                                <option selected disable value="">Seleccione un estrato</option>
                            </select>
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.estratos.$touched">
                            <span class="label label-danger" ng-show="crearForm.estratos.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Encuestado</label>
                            <select name="encuestadores" class="form-control" id="encuestadores" ng-model="social.digitador_id" required ng-options="ite.id as ite.user.username for ite in encuestadores">
                                <option selected disable value="">Seleccione el encuestador</option>
                            </select>
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.encuestadores.$touched">
                            <span class="label label-danger" ng-show="crearForm.encuestadores.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Dirección</label>
                             <input type="text" name="direccion" id="direccion" class="form-control" ng-model="social.direccion" ng-maxlength="150" placeholder="Ingrese la dirección. Máximo 150 caracteres" required />
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.direccion.$touched">
                            <span class="label label-danger" ng-show="crearForm.direccion.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Celular</label>
                             <input type="text" name="celular" id="celulargit" class="form-control" ng-model="social.celular" ng-maxlength="150" placeholder="Ingrese la dirección. Máximo 150 caracteres" required />
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.celular.$touched">
                            <span class="label label-danger" ng-show="crearForm.celular.$error.required">*El campo es requerido.</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Correo electrónico</label>
                             <input type="email" name="email" id="email" class="form-control" ng-model="social.email" ng-maxlength="250" placeholder="Ingrese la dirección. Máximo 150 caracteres" required />
                        </div>
                        <span ng-show="crearForm.$submitted || crearForm.email.$touched">
                            <span class="label label-danger" ng-show="crearForm.email.$error.required">*El campo es requerido.</span>
                             <span class="label label-danger" ng-show="crearForm.email.$error.email">*No es un email válido.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <button type="submit" class="btn btn-raised btn-success" ng-click="guardar()">Guardar</button>
        </div>
    </form>
    
      <div class='carga'>

    </div>
</div>


@endsection