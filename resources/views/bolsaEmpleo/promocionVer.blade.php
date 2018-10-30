@extends('layout._publicLayout')

@section('Title', 'Vacante')

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
    color: #555;
}
label{
    font-weight: 500;
    margin: 0;
}
</style>
@endsection

@section('content')
<div class="container">
    
    
    
    <h2>{{$vacante->nombre}}</h2>
    <hr/>
    
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif
    
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <ul class="list-group">
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-android-home"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Proveedor</label>
                              <p class="media-heading p-0 m-0"><a href="/promocionBolsaEmpleo/vacantes?proveedor={{$vacante->proveedoresRnt->id}}">{{$vacante->proveedoresRnt->razon_social}} <small>{{$vacante->proveedoresRnt->nit}}</small></a></p>
                              
                          </div>
                          
                      </div>
                  </div>
              </li>
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-android-pin"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Ubicación</label>
                              <p class="media-heading p-0 m-0">
                                  {{$vacante->proveedoresRnt->direccion}}. <a href="/promocionBolsaEmpleo/vacantes?municipio={{$vacante->municipio_id}}">{{$vacante->municipio->nombre}}, {{$vacante->municipio->departamento->nombre}}</a>
                              </p>
                          </div>
                          
                      </div>
                  </div>
              </li>
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-university"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Nivel de educación</label>
                              <p class="media-heading p-0 m-0">
                                  <a href="/promocionBolsaEmpleo/vacantes?nivelEducacion={{$vacante->nivel_educacion_id}}">{{$vacante->nivelEducacion->nombre}}</a>
                              </p>
                          </div>
                          
                      </div>
                  </div>    
              </li>
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-podium"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Tipo de cargo</label>
                              <p class="media-heading p-0 m-0">
                                  <a href="/promocionBolsaEmpleo/vacantes?tipoCargo={{$vacante->tipo_cargo_vacante_id}}">{{$vacante->tiposCargosVacante->nombre}}</a>
                              </p>
                          </div>
                          
                      </div>
                  </div>      
              </li>
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-person-stalker"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>No. de vacantes</label>
                              <p class="media-heading p-0 m-0">
                                  {{$vacante->numero_vacantes}}
                              </p>
                          </div>
                          
                      </div>
                  </div>      
              </li>
            </ul>
        </div>
        <div class="col-xs-12 col-md-7"></div>
    </div>
    
    
    <div class="row">
        <div class="col-xs-12">
            <h2>{{$vacante->proveedoresRnt->razon_social}} - {{$vacante->proveedoresRnt->nit}}</h2>
            <p>{{$vacante->proveedoresRnt->direccion}}</p>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-4">
            @if(isset($vacante->fecha_vencimiento))<p>Cierre: {{$vacante->fecha_vencimiento}}</p>@endif
            <p>Lugar: {{$vacante->municipio->nombre}}, {{$vacante->municipio->departamento->nombre}}</p>
            <p>Nivel de educación: {{$vacante->nivelEducacion->nombre}}</p>
            <p>No. de vacantes: {{$vacante->numero_vacantes}}</p>
            @if(isset($vacante->salario_minimo))<p>Salario mínimo: {{$vacante->salario_minimo}}</p>@endif
            @if(isset($vacante->salario_maximo))<p>Salario mínimo: {{$vacante->salario_maximo}}</p>@endif
            <p>Años de experiencia: {{$vacante->anios_experiencia}}</p>
        </div>
        <div class="col-md-4">
            <p>
                Perfil:
                {{$vacante->descripcion}}
            </p>
            <p>
                Requisitos:
                {{$vacante->requisitos}}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <a href="/postulado/postular/{{$vacante->id}}">Postularme</a>
        </div>
        <div class="col-xs-12">
            <a href="/promocionBolsaEmpleo/vacantes">Volver</a>
        </div>
    </div>
    
    <div class="row">
        
        @foreach($otrasVacantes as $otraVacante)
            <div class="col-md-4">
                <p>{{$otraVacante->nombre}}</p>
                <p>{{$otraVacante->descripcion}}</p>
            </div>
        @endforeach
    </div>
</div>
    
    
@endsection