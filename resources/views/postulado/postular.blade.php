@extends('layout._publicLayout')

@section('Title', 'Postular')

@section('content')
    <h1>Vacante - {{$vacante->nombre}}</h1>
    
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif
    
    @if(Session::has('validaciones'))
        @foreach(Session::get('validaciones')  as $key => $value)
            <div class="alert alert-danger" role="alert" style="text-align: center;">{{$value[0]}}</div>
        @endforeach
    @endif
    <form role="form" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="vacante_id" value="{{$vacante->id}}" />
        <div class="row">
            <div class="col-xs-12">
                <label for="archivo" class="control-label">Cargar hoja de vida</label>
                <input type="file" name="archivo" required />        
            </div>
        </div>
        
        
        <div class="row" style="text-align: center;">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success" >Enviar</button>    
            </div>
        </div>
        
    </form>
    
@endsection