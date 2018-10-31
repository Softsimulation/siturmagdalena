@extends('layout._publicLayout')

@section('Title', 'Postular')

@section('estilos')
<style>
    label{
        font-weight: 500;
        margin: 0;
    }
    .inputfile {
    	width: 0.1px;
    	height: 0.1px;
    	opacity: 0;
    	overflow: hidden;
    	position: absolute;
    	z-index: -1;
    }
    .inputfile + label {
        font-size: 1rem;
        font-weight: 500;
        padding: .5rem 1rem;
        border-radius: 4px;
        color: white;
        background-color: dodgerblue;
        display: inline-block;
        cursor: pointer;
        margin-bottom: 1rem;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 80%;
    }
    .inputfile:focus + label {
    	outline: 1px dotted #000;
    	outline: -webkit-focus-ring-color auto 5px;
    }
    
    .inputfile:focus + label,
    .inputfile + label:hover {
        background-color: #1d4a87;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2><small class="btn-block">Vacante</small> {{$vacante->nombre}}</h2>
    <hr/>
    <div class="well">
        Para postularse a una vacante:
        <ul>
            <li>Presione en el botón "Cargar hoja de vida" ubicado a continuación. Se abrirá una ventana de selección de archivos.</li>
            <li>Seleccione el archivo desde su computador.</li>
            <li>Una vez seleccionado presione el botón "Enviar".</li>
            <li><strong style="font-weight: 500;">Formatos soportados: .pdf, .doc, .docx, .txt.</strong></li>
        </ul>
        
    </div>
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
            <div class="col-xs-12 text-center">
                
                <input type="file" name="archivo" id="archivo" class="inputfile" accept="application/msword, text/plain, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" required />        
                <label for="archivo" class="control-label"> <span class="ion-android-upload" aria-hidden="true" style="font-size: 1.325rem;"></span> <span class="name">Cargar hoja de vida</span></label>
            </div>
        </div>
        
        
        <div class="row" style="text-align: center;">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-lg btn-success" >Enviar</button>
                <a role="button" href="/promocionBolsaEmpleo/vacantes" class="btn btn-lg btn-default">Volver</a>
            </div>
        </div>
        
    </form>
</div>
    
    
@endsection

@section('javascript')
<script>
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
    	var label	 = input.nextElementSibling,
    		labelVal = label.innerHTML;
    
    	input.addEventListener( 'change', function( e )
    	{
    		var fileName = '';
    		fileName = e.target.value.split( '\\' ).pop();
    
    		if( fileName )
    			label.querySelector( 'span.name' ).innerHTML = fileName;
    		else
    			label.innerHTML = labelVal;
    	});
    });
</script>
@endsection