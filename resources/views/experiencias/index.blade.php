@extends('layout._publicLayout')

@section('Title', 'Experiencias en el Magdalena')

@section('meta_og')
<meta property="og:title" content="Experiencias" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="Conoce las experiencias que te esperan en el departamento Magdalena"/>

@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/forms.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        header{
            margin-bottom: 2%;   
        }
        .page{
            display:flex;
            flex-wrap: wrap;
            position:relative;
        }
        .page-filter{
            display:none;
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            height: 100%;
            padding: .5rem;
            background-color: white;
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.4);
            overflow-y: auto;
            z-index: 10;
        }
        .page-filter.show{
            display:block;
        }
        .btn-circle{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            
        }
        #btnFilter{
            display:block;
            position: fixed;
            right: 4%;
            bottom: 1rem;
            background-color: orange;
            color:white;
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.4);
            font-size: 1.5rem;
            z-index: 20;
        }
        .panel-heading {
            padding: 0;
        }
        .panel-heading>.panel-title {
            font-size: 1rem;
        }
        
        .panel-heading a {
            padding: .5rem 1rem;
            display: block;
            font-weight: 500;
            font-size: 1rem;
        }
        .panel-group .panel+.panel {
            margin-top: 0;
        }
        .panel-default>.panel-heading {
            border: 0;
            background-color: white;
        }
        .panel-default {
            border: 0;
        }
        .panel-default:not(:last-child)>.panel-heading {
            border-bottom: 1px solid #eee;
        }
        .filter-list{
            list-style: none;
            margin: 0;
            padding: 0;
        }
        @media only screen and (min-width: 768px) {
            .page{
                padding: 1rem 2%;
            }
            
        }
        @media only screen and (min-width: 992px) {
            .page-filter{
                display:block;
                width: 300px;
                border:1px solid #ddd;
                border-radius: 4px;
                padding: 1rem;
                position:static;
                box-shadow: none;
            }
            .page-container{
                width: calc(100% - 300px);
            }
            #btnFilter{
                display: none;
            }
        }
    </style>
@endsection

@section('content')
<div class="page">
    <div class="page-filter">
        <button type="button" class="btn btn-xs btn-link" title="Cerrar panel de filtros">&times;<span class="sr-only">Cerrar panel de filtros</span></button>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Destinos
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <ul class="filter-list">
                    <li>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck1">
                          <label class="custom-control-label" for="customCheck1">Opción #1</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck2">
                          <label class="custom-control-label" for="customCheck2">Opción #2</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck3">
                          <label class="custom-control-label" for="customCheck3">Opción #3</label>
                        </div>    
                    </li>
                    <li>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck4">
                          <label class="custom-control-label" for="customCheck4">Opción #4</label>
                        </div>
                    </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Perfiles
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Tipos de experiencias
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="page-container">
        {{$destinos}}
    </div>
    <button type="button" id="btnFilter" class="btn btn-circle" title="Filtrar registros">
        <span class="ion-funnel" aria-hidden="true"></span>
        <span class="sr-only">Filtrar elementos</span>
    </button>
</div>
 {{$destinos}}
@endsection
@section('javascript')
<script>
    $('#btnFilter').on('click', function(){
        if($('.page-filter').hasClass('show')){
            $('.page-filter').removeClass('show');
        }else{
            $('.page-filter').addClass('show');
        }
    });    
</script>

@endsection