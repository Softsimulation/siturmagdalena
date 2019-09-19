<?php 
    $hasFilter = isset($_GET["nombreVacante"]) || isset($_GET["municipio"]) || isset($_GET["proveedor"]) || isset($_GET["tipoCargo"]) || isset($_GET["nivelEducacion"]);
?>
@extends('layout._publicLayout')

@section('Title', 'Bolsa de empleo - Vacantes')

@section('estilos')
<style>
.list-group-item:last-child {
    border-radius: 0;
    border-bottom: 0;
}

.list-group-item:first-child {
    border-radius: 0;
    border-top: 0;
}
.list-group-item {
    border-left: 0;
    border-right: 0;
    padding: .5rem 1rem;
}
.p-0{
    padding: 0;
}
.m-0{
    margin: 0;
}

.list-group-item a{
    color:#555;
    text-decoration: underline;
    text-decoration-style: dotted;
    text-decoration-color: #ddd;
    
}
.list-group-item a:hover{
    text-decoration-color: dodgerblue;
}
.ionicons-list{
    font-size: 1.25rem;
    color: #ddd;
}
.tile {
    padding-bottom: 1rem;
}

.text-right {
    text-align: right;
    position: absolute;
    bottom: .5rem;
    right: 1rem;
}
label{
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="container">
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif

    <h2>Bolsa de empleo <small>Vacantes</small></h2>
    <hr/>
    <div class="well">
        
        
        <form method="GET" action="/promocionBolsaEmpleo/vacantes">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="nombreVacante" class="control-label">Nombre de vacante</label>
                        <input class="form-control" type="text" name="nombreVacante" id="nombreVacante" maxlength="255" placeholder="¿Qué desea buscar?" @if(isset($_GET["nombreVacante"])) value="{{$_GET['nombreVacante']}}" @endif/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="municipio" class="control-label">Municipio</label>
                        <select class="form-control" id="municipio" name="municipio">
                            <option value="" selected disabled>Seleccione el nivel de educación</option>
                            @foreach($municipios as $municipio)
                                <option value="{{$municipio->id}}" @if(isset($_GET["municipio"]) && $_GET['municipio'] == $municipio->id) selected @endif>{{$municipio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <label for="proveedor" class="control-label">Prestador de servicio turístico</label>
                        <select class="form-control" id="proveedor" name="proveedor">
                            <option value="" selected disabled>Seleccione un PST</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}" @if(isset($_GET["proveedor"]) && $_GET['proveedor'] == $proveedor->id) selected @endif>{{$proveedor->razon_social}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <label for="tipoCargo" class="control-label">Tipo de cargo</label>
                        <select class="form-control" id="tipoCargo" name="tipoCargo">
                            <option value="" selected disabled>Seleccione un tipo de cargo</option>
                            @foreach($tiposCargos as $cargo)
                                <option value="{{$cargo->id}}" @if(isset($_GET["tipoCargo"]) && $_GET['tipoCargo'] == $cargo->id) selected @endif>{{$cargo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <label for="nivelEducacion" class="control-label">Nivel de educación</label>
                        <select class="form-control" id="nivelEducacion" name="nivelEducacion">
                            <option value="" selected disabled>Seleccione un nivel de educación</option>
                            @foreach($nivelesEducacion as $nivel)
                                <option value="{{$nivel->id}}" @if(isset($_GET["nivelEducacion"]) && $_GET['nivelEducacion'] == $nivel->id) selected @endif>{{$nivel->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3 text-center" style="align-self: flex-end">
    				<button type="submit" class="btn btn-block btn-success" style="margin-bottom: 1rem;">
    				    <span class="glyphicon glyphicon-search"></span>
    				    Buscar
				    </button>
    			</div>
			</div>
        </form>
            
        
    </div>
    @if($hasFilter)
    <div class="text-center" style="margin-bottom: 1rem;">
        <a role="button" class="btn btn-default" href="/promocionBolsaEmpleo/vacantes">Reiniciar filtros</a>
       
    </div>
        
    @endif
    <div class="tiles">
    @foreach($vacantes as $vacante)
        <div class="tile">
            <div class="tile-body">
                <div class="tile-caption">
                    <h3 class="text-uppercase"><a href="/promocionBolsaEmpleo/ver/{{$vacante->id}}">{{$vacante->nombre}}</a></h3>
                </div>
                <ul class="list-group">
                  <li class="list-group-item">
                      <div class="media">
                          <div class="media-left">
                                <span class="media-object ionicons-list ion-android-home"></span>
                                <span class="sr-only">Ofertante</span>
                          </div>
                          <div class="media-body">
                              <p class="media-heading p-0 m-0"><a href="/promocionBolsaEmpleo/vacantes?proveedor={{$vacante->proveedores_rnt_id}}">{{$vacante->proveedoresRnt->razon_social}} <small>{{$vacante->proveedoresRnt->nit}}</small></a></p>
                          </div>
                      </div>
                  </li>
                  <li class="list-group-item">
                      <div class="media">
                          <div class="media-left">
                                <span class="media-object ionicons-list ion-android-pin"></span>
                                <span class="sr-only">Ubicación</span>
                          </div>
                          <div class="media-body">
                              <p class="media-heading p-0 m-0">
                                  {{$vacante->proveedoresRnt->direccion}}. <a href="/promocionBolsaEmpleo/vacantes?municipio={{$vacante->municipio_id}}">{{$vacante->municipio->nombre}}</a>
                              </p>
                          </div>
                      </div>
                  </li>
                  <li class="list-group-item">
                      <div class="media">
                          <div class="media-left">
                                <span class="media-object ionicons-list ion-university"></span>
                                <span class="sr-only">Nivel de educación</span>
                          </div>
                          <div class="media-body">
                              <p class="media-heading p-0 m-0">
                                  <a href="/promocionBolsaEmpleo/vacantes?nivelEducacion={{$vacante->nivel_educacion_id}}">{{$vacante->nivelEducacion->nombre}}</a>
                              </p>
                          </div>
                      </div>    
                  </li>
                  <li class="list-group-item">
                      <div class="media">
                          <div class="media-left">
                                <span class="media-object ionicons-list ion-podium"></span>
                                <span class="sr-only">Tipo de cargo</span>
                          </div>
                          <div class="media-body">
                              <p class="media-heading p-0 m-0">
                                  <a href="/promocionBolsaEmpleo/vacantes?tipoCargo={{$vacante->tipo_cargo_vacante_id}}">{{$vacante->tiposCargosVacante->nombre}}</a>
                              </p>
                          </div>
                      </div>      
                  </li>
                </ul>
                
                <div class="text-right">
                    <a href="/postulado/postular/{{$vacante->id}}" class="btn btn-xs btn-success">Postularme</a>
                    <a href="/promocionBolsaEmpleo/ver/{{$vacante->id}}" class="btn btn-xs btn-link">Ver más</a>
                </div>
            </div>
        </div>
        <br>
    @endforeach
    </div>
    <div class="text-center">
		{{$vacantes->links()}}
	</div>
    
</div>
    
    
@endsection