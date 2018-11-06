@extends('layout._publicLayout')

@section('Title', $vacante->nombre)

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
    
    
    
    <h2><small class="btn-block">Vacante</small> {{$vacante->nombre}}</h2>
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
              @if(isset($vacante->salario_minimo) || isset($vacante->salario_maximo))
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-cash"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Salario estimado</label>
                              @if(isset($vacante->salario_minimo) && isset($vacante->salario_maximo))
                              <p class="media-heading p-0 m-0">
                                  Entre ${{number_format($vacante->salario_minimo)}} y ${{number_format($vacante->salario_minimo)}}
                              </p>
                              @endif
                              @if(isset($vacante->salario_minimo) && !isset($vacante->salario_maximo))
                              <p class="media-heading p-0 m-0">
                                  Desde ${{number_format($vacante->salario_minimo)}}
                              </p>
                              @endif
                              @if(!isset($vacante->salario_minimo) && isset($vacante->salario_maximo))
                              <p class="media-heading p-0 m-0">
                                  Hasta ${{number_format($vacante->salario_maximo)}}
                              </p>
                              @endif
                          </div>
                          
                      </div>
                  </div>      
              </li>
              @endif
              @if(isset($vacante->anios_experiencia))
              <li class="list-group-item">
                  <div class="media">
                      <div class="media-left">
                            <span class="media-object ionicons-list ion-clipboard"></span>
                      </div>
                      <div class="media-body">
                          <div class="form-group m-0">
                              <label>Años de experiencia</label>
                              <p class="media-heading p-0 m-0">
                                  {{$vacante->anios_experiencia}}
                              </p>
                          </div>
                          
                      </div>
                  </div>      
              </li>
              @endif
            </ul>
        </div>
        <div class="col-xs-12 col-md-7">
            <h4>Perfil</h4>
            <p style="white-space:pre-line;">{{$vacante->descripcion}}</p>
            <h4>Requisitos</h4>
            <p style="white-space:pre-line;">{{$vacante->requisitos}}</p>
        </div>
    </div>
    
    
    
    <div class="text-center">
            <a role="button" href="/postulado/postular/{{$vacante->id}}" class="btn btn-lg btn-success">Postularme</a>
       
            <a role="button" href="/promocionBolsaEmpleo/vacantes" class="btn btn-lg btn-default">Volver</a>
    </div>
    @if(count($otrasVacantes) > 0)
    <h2>Otras vacantes</h2>
    <div class="tiles">
        
        @foreach($otrasVacantes as $otraVacante)
            <div class="tile col-xs-12 col-md-4">
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="/promocionBolsaEmpleo/ver/{{$otraVacante->id}}">{{$otraVacante->nombre}}</a></h3>
                    </div>
                    <p style="white-space:nowrap;overflow: hidden; text-overflow: ellipsis">{{$otraVacante->descripcion}}</p>
                    <div class="text-right">
                        <a href="/promocionBolsaEmpleo/ver/{{$otraVacante->id}}" class="btn btn-xs btn-lnik">Ver más</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>
    
    
@endsection