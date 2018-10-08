@extends('layout._publicLayout')

@section('Title', 'Bolsa de empleo - Vacantes')

@section('content')

    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif

    <h1>Bolsa de empleo - Vacantes</h1>
    
    <div class="row">
        
        <form method="GET" action="/promocionBolsaEmpleo/vacantes">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="proveedor" class="control-label">Proveedor</label>
                    <select class="form-control" id="proveedor" name="proveedor">
                        <option value="" selected disable>Seleccion proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->razon_social}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="municipio" class="control-label">Municipio</label>
                    <select class="form-control" id="municipio" name="municipio">
                        <option value="" selected disable>Seleccion nivel de educación</option>
                        @foreach($municipios as $municipio)
                            <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipoCargo" class="control-label">Tipo de cargo</label>
                    <select class="form-control" id="tipoCargo" name="tipoCargo">
                        <option value="" selected disable>Seleccion tipo de cargo</option>
                        @foreach($tiposCargos as $cargo)
                            <option value="{{$cargo->id}}">{{$cargo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nivelEducacion" class="control-label">Nivel de educación</label>
                    <select class="form-control" id="nivelEducacion" name="nivelEducacion">
                        <option value="" selected disable>Seleccion nivel de educación</option>
                        @foreach($nivelesEducacion as $nivel)
                            <option value="{{$nivel->id}}">{{$nivel->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombreVacante" class="control-label">Nombre vacante</label>
                    <input class="form-control" type="text" name="nombreVacante" id="nombreVacante" />
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
			</div>
        </form>
        
    </div>
    <br><br>
    @foreach($vacantes as $vacante)
        <div class="row">
            <div class="col-xs-12">
                <p>{{$vacante->nombre}}</p>
                <p><a href="/promocionBolsaEmpleo/vacantes?proveedor={{$vacante->proveedores_rnt_id}}">{{$vacante->proveedoresRnt->razon_social}} - {{$vacante->proveedoresRnt->nit}}</a></p>
                <p>{{$vacante->proveedoresRnt->direccion}}</p>
                <p><a href="/promocionBolsaEmpleo/vacantes?municipio={{$vacante->municipio_id}}">{{$vacante->municipio->nombre}}</a></p>
                <p><a href="/promocionBolsaEmpleo/vacantes?nivelEducacion={{$vacante->nivel_educacion_id}}">{{$vacante->nivelEducacion->nombre}}</a></p>
                <p><a href="/promocionBolsaEmpleo/vacantes?tipoCargo={{$vacante->tipo_cargo_vacante_id}}">{{$vacante->tiposCargosVacante->nombre}}</a></p>
                <p><a href="/promocionBolsaEmpleo/ver/{{$vacante->id}}">Ver</a></p>
            </div>
        </div>
        <br>
    @endforeach
    
    <div class="row">
		{{$vacantes->links()}}
	</div>
    
@endsection