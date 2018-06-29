
@extends('layout._encuestaDinamicaLayout')

@section('Title','@{{seccion.encuesta.idiomas[0].nombre}}')

@section('TitleSection','@{{seccion.encuesta.idiomas[0].nombre}}')
@section('Control','ng-controller="EncuestaCtrl"')


@section('contenido')
   
    <div class="row"  >
        
        <input type="hidden" id="idEncuesta" value="{{$idEncuesta}}" />
        <input type="hidden" id="idSeccion"  value="{{$idSeccion}}" />
        <input type="hidden" id="codigo"     value="{{$codigo}}" />
        
        <div class="col-md-12">
            
            <form name="form" novalidate >
            
                <div class="row">
                    
                    <div class="lds-facebook">
                        <div></div><div></div><div></div>
                    </div>
               
                    <campos-encuesta ng-repeat="pregunta in seccion.preguntas" pregunta="pregunta" form="form" repeat-end="onEnd()" ></campos-encuesta>
                
                 </div>
                 
                <div class="row btns hide"  >
                    @if($atras)
                       <a href="/encuestaAdHoc/{{$codigo}}?seccion={{$atras}}" class="btn btn-default">Anterior</a>
                    @endif
                    <input type="submit" class="btn btn-success" ng-click="guardarEncuesta()" value="siguiente" />
                </div>
             
            </form>
           
        </div>
      
    </div>

    
   
@endsection

@section('estilos')
    <style type="text/css">
        
        .lds-facebook {
            position: relative;
            width: 80px;
            display: block;
            margin: 0 auto;
        }
        .lds-facebook div {
          display: inline-block;
          position: absolute;
          width: 43px;
          background: #4caf50;
          animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }
        .lds-facebook div:nth-child(1) {
          left: 0px;
          animation-delay: -0.24s;
        }
        .lds-facebook div:nth-child(2) {
          left: 55px;
          animation-delay: -0.12s;
        }
        .lds-facebook div:nth-child(3) {
          left: 110px;
          animation-delay: 0;
        }
        @keyframes lds-facebook {
          0% {
            top: 5px;
            height: 101px;
          }
          50%, 100% {
            top: 35px;
            height: 81px;
          }
        }

        .btns{ text-align:center; }
        .error input, .error select, .error .ui-select-multiple, .error .ui-select-bootstrap > .ui-select-match > .btn{
                border: 1px solid red;
        }
        .error .info-error{ color: red; }
        form .row .col-md-6{ margin-bottom: 30px; }
    </style>
@endsection
