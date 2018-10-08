(function(){

    angular.module("appEncuestaDinamica", [ 'ngSanitize', 'angularUtils.directives.dirPagination', 'ui.select', 'checklist-model', "ADM-dateTimePicker", "dndLists", "chart.js", "serviciosAdmin" ] )
    
    .config(["ADMdtpProvider", "ChartJsProvider", function(ADMdtpProvider,ChartJsProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" });
         ChartJsProvider.setOptions({ colors : [ '#803690', '#00ADF9', '#DCDCDC', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360'] });
    }])
    
    .controller("ConfigurarEncuestaCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        $scope.tabOpen = { activo:0 };
        $scope.opcion = {};
        
        
        $scope.$watch("id", function() {
            if($scope.id){
                $("body").attr("class", "cbp-spmenu-push charging");
                ServiEncuesta.getData($scope.id)
                            .then(function(data){
                                $scope.encuesta = data.encuesta;
                                $scope.idiomas = data.idiomas;
                                $scope.tiposCamos = data.tiposCamos;
                                $("body").attr("class", "cbp-spmenu-push"); 
                            });
            }
        });
        
        
        $scope.agregarSeccion = function () {
            swal({
                title: "Agregar sección",
                text: "¿Esta seguro de agregar una nueva sección a al encuesta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.agregarSeccion( {id:$scope.encuesta.id} ).then(function (data) {
                        if (data.success) {
                            $scope.encuesta = data.data;
                            $scope.tabOpen.activo = $scope.encuesta.secciones.length-1;
                            swal("¡Modificado!", "El estado se ha modificado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        $scope.OpenModalAgregarPregunta = function(seccion){
           
            $scope.pregunta = {
                idSeccion : seccion.id,
                idEncuesta : seccion.encuestas_id,
                esRequerido : 0,
                opciones : [],
                subPreguntas : []
            }
            $scope.errores = null;
            $scope.formPregunta.$setPristine();
            $scope.formPregunta.$setUntouched();
            $scope.formPregunta.$submitted = false;
            $("#modalAgregarPregunta").modal("show");
            
        }
        
        $scope.guardarPregunta = function () {

            if (!$scope.formPregunta.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.agregarPregunta($scope.pregunta).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuesta = data.data;
                            swal("¡Pregunta agregada!", "La pregunta se agregado exitosamente", "success");
                            $("#modalAgregarPregunta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push"); 
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
        
        $scope.activarDesactivarPregunta = function (pregunta) {
            swal({
                title: "Cambio de estado",
                text: "¿Esta seguro de "+( !pregunta.es_visible ? "activar":"desactivar" )+" la pregunta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.activarDesactivarPregunta( {id:pregunta.id} ).then(function (data) {
                        if (data.success) {
                            pregunta.es_visible = data.estado;
                            swal("¡Modificado!", "El estado se ha modificado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        $scope.eliminarPregunta = function (pregunta, index ) {
            swal({
                title: "Eliminar pregunta",
                text: "¿Esta seguro de eliminar la pregunta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.eliminarPregunta( {id:pregunta.id} ).then(function (data) {
                        if (data.success) {
                            $scope.encuesta.secciones[$scope.tabOpen.activo].preguntas.splice(index,1);
                            swal("¡Eliminado!", "La pregunta se ha eliminado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        $scope.verDetallePregunta = function(pregunta){
            $scope.detallePregunta = pregunta;
            $("#modalDetallePregunta").modal("show");
        }
        
        
        $scope.openModalOrdenPreguntas = function(seccion){
            $scope.ordenarPreguntas = angular.copy(seccion.preguntas);
            $scope.guardarOrden = {
                idSeccion : seccion.id,
                idEncuesta : seccion.encuestas_id,
                preguntas : []
            };
            $("#openModalOrdenPreguntas").modal("show");
        }
        
        $scope.guardarOrdenPreguntas = function () {
            
            for(var i=0; i<$scope.ordenarPreguntas.length; i++){ $scope.guardarOrden.preguntas.push($scope.ordenarPreguntas[i].id); }
           
            $("body").attr("class", "cbp-spmenu-push charging");
           
            ServiEncuesta.guardarOrdenPreguntas( $scope.guardarOrden ).then(function (data) {
                if (data.success) {
                    $scope.encuesta = data.data;
                    swal("¡Orden modificado!", "El nuevo orden de las preguntas se ha registrado exitosamente", "success");
                    $("#openModalOrdenPreguntas").modal("hide");
                }
                else {
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
                $("body").attr("class", "cbp-spmenu-push"); 
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
                $("body").attr("class", "cbp-spmenu-push"); 
            });
        }
        
        
        $scope.OpenModalAgregarIdiomaPregunta = function(pregunta){
           
            $scope.idomaPregunta = {
                idSeccion : pregunta.secciones_encuestas_id,
                idPregunta : pregunta.id,
                idEncuesta : $scope.encuesta.id,
                tipoCampo : pregunta.tipo_campos_id,
                opciones :  $scope.getOpcionesPregunta(pregunta),
                subPreguntas : $scope.getSubPreguntas(pregunta),
                opcionesSubPreguntas : $scope.getOpcionesSubPreguntas(pregunta)
            }
            
            $scope.es_editar = false;
            $scope.detallePregunta = pregunta;
            $scope.errores = null;
            $scope.formPreguntaIdioma.$setPristine();
            $scope.formPreguntaIdioma.$setUntouched();
            $scope.formPreguntaIdioma.$submitted = false;
            $("#modalAgregarIdiomaPregunta").modal("show");
            
        }
        
        $scope.OpenModalEditarIdiomaPregunta = function(pregunta, preguntaIdioma){
           
            $scope.idomaPregunta = {
                idSeccion : pregunta.secciones_encuestas_id,
                idPregunta : pregunta.id,
                idIdiomaPregunta : preguntaIdioma.id,
                idEncuesta : $scope.encuesta.id,
                tipoCampo : pregunta.tipo_campos_id,
                idioma : preguntaIdioma.idiomas_id,
                opciones : [],
                subPreguntas : [],
                opcionesSubPreguntas : []
            }
            
            for(var i=0; i<pregunta.idiomas.length; i++){
                if( pregunta.idiomas[i].idiomas_id == preguntaIdioma.idiomas_id ){
                    $scope.idomaPregunta.pregunta = pregunta.idiomas[i].pregunta;
                }
            }
            
            if( pregunta.tipo_campos_id==3 || pregunta.tipo_campos_id==5 || pregunta.tipo_campos_id==6 || pregunta.tipo_campos_id==7 ){
                for(var i=0; i<pregunta.opciones.length ; i++ ){
                    for(var j=0; j<pregunta.opciones[i].idiomas.length ; j++ ){
                        if(pregunta.opciones[i].idiomas[j].idiomas_id==preguntaIdioma.idiomas_id){
                             $scope.idomaPregunta.opciones.push({ id:pregunta.opciones[i].idiomas[j].id, idOpcion:pregunta.opciones[i].id, texto:pregunta.opciones[i].idiomas[j].nombre  });
                             break;
                        }
                    }      
                }    
            }
            else if( pregunta.tipo_campos_id==8 || pregunta.tipo_campos_id==9 || pregunta.tipo_campos_id==10 || pregunta.tipo_campos_id==11 ){
                for(var i=0; i<pregunta.sub_preguntas.length ; i++ ){
                    for(var j=0; j<pregunta.sub_preguntas[i].idiomas.length ; j++ ){
                        if(pregunta.sub_preguntas[i].idiomas[j].idiomas_id==preguntaIdioma.idiomas_id){
                             $scope.idomaPregunta.subPreguntas.push({ id:pregunta.sub_preguntas[i].idiomas[j].id, idSubPregunta:pregunta.sub_preguntas[i].id, texto:pregunta.sub_preguntas[i].idiomas[j].nombre  });
                             break;
                        }
                    }      
                } 
                for(var i=0; i<pregunta.opciones_sub_preguntas.length ; i++ ){
                    for(var j=0; j<pregunta.opciones_sub_preguntas[i].idiomas.length ; j++ ){
                        if(pregunta.opciones_sub_preguntas[i].idiomas[j].idiomas_id==preguntaIdioma.idiomas_id){
                             $scope.idomaPregunta.opcionesSubPreguntas.push({ id:pregunta.opciones_sub_preguntas[i].idiomas[j].id, idOpcionSubPregunta:pregunta.opciones_sub_preguntas[i].id, texto:pregunta.opciones_sub_preguntas[i].idiomas[j].nombre  });
                             break;
                        }
                    }      
                } 
            } 
            
            $scope.es_editar = true;
            $scope.detallePregunta = pregunta;
            $scope.errores = null;
            $scope.formPreguntaIdioma.$setPristine();
            $scope.formPreguntaIdioma.$setUntouched();
            $scope.formPreguntaIdioma.$submitted = false;
            $("#modalAgregarIdiomaPregunta").modal("show");
            
        }
        
        $scope.getOpcionesPregunta = function(p){
            
            var x = [];
            if( p.tipo_campos_id==3 || p.tipo_campos_id==5 || p.tipo_campos_id==6 || p.tipo_campos_id==7 ){
                for(var i=0; i<p.opciones.length ;i++ ){
                    x.push({ idOpcion : p.opciones[i].id });
                }    
                return x;
            } 
            return x; 
        }
        
        $scope.getSubPreguntas = function(p){
            
            var x = [];
            if( p.tipo_campos_id==8 || p.tipo_campos_id==9 || p.tipo_campos_id==10 || p.tipo_campos_id==11 ){
                for(var i=0; i<p.sub_preguntas.length ;i++ ){
                    x.push({ idSubPregunta : p.sub_preguntas[i].id });
                }    
                return x;
            } 
            return x; 
        }
        
        $scope.getOpcionesSubPreguntas = function(p){
            
            var x = [];
            if( p.tipo_campos_id==8 || p.tipo_campos_id==9 || p.tipo_campos_id==10 || p.tipo_campos_id==11 ){
                for(var i=0; i<p.opciones_sub_preguntas.length ;i++ ){
                    x.push({ idOpcionSubPregunta : p.opciones_sub_preguntas[i].id });
                }    
                return x;
            } 
            return x; 
        }
        
        
        $scope.guardarIdiomaPregunta = function () {

            if (!$scope.formPreguntaIdioma.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
             $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.guardarIdiomaPregunta($scope.idomaPregunta).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuesta = data.data;
                            swal("¡Idioma "+($scope.es_editar?"editado":"agregado")+"!", "El idioma se guardado exitosamente", "success");
                            $("#modalAgregarIdiomaPregunta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push"); 
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
        
        $scope.openModalAgregarOpcion = function(pregunta){
            
            $scope.detallePregunta = pregunta;
            
            $scope.datOpcion = {
                idSeccion : pregunta.secciones_encuestas_id,
                idPregunta : pregunta.id,
                idEncuesta : $scope.encuesta.id,
                idiomas : []
            }
            
            for(var i=0; i<pregunta.idiomas.length; i++){
                $scope.datOpcion.idiomas.push(pregunta.idiomas[i].idioma);
            }
            
            $("#modalDetallePregunta").modal("hide");
            $("#modalAgregarOpcionPregunta").modal("show");
        }
        
        $scope.guardarOpcionPregunta = function () {

            if (!$scope.formOpcionIdioma.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.guardarOpcionPregunta($scope.datOpcion).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuesta = data.data;
                            swal("¡Opción agregada!", "La opcion se ha agregado exitosamente", "success");
                            $("#modalAgregarOpcionPregunta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push");
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push");
                    });
            
        }
        
        $scope.eliminarOpionPregunta = function ( index, id ) {
            swal({
                title: "Eliminar opción",
                text: "¿Esta seguro de eliminar la opcion?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.eliminarOpcionPregunta( {id:id} ).then(function (data) {
                        if (data.success) {
                            for(var i=0; i<$scope.encuesta.secciones[$scope.tabOpen.activo].preguntas.length; i++){
                                if($scope.encuesta.secciones[$scope.tabOpen.activo].preguntas[i].id == $scope.detallePregunta.id ){
                                    $scope.encuesta.secciones[$scope.tabOpen.activo].preguntas[i].opciones.splice(index,1);
                                    break;
                                }
                            }
                            $scope.detallePregunta.opciones.splice(index,1);
                            swal("¡Eliminado!", "La opción se ha eliminado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        
        $scope.agregarOpcion = function(){
            
            if( ($scope.pregunta.tipoCampo==3 || $scope.pregunta.tipoCampo==7) && $scope.opcion.otro ){
                for(var i=0; i<$scope.pregunta.opciones.length; i++){
                    if($scope.pregunta.opciones[i].otro){ sweetAlert("Oops...", "Ya existe una opción con otro, dentro de las opciones.", "error");  }
                }
            }
            
            $scope.pregunta.opciones( angular.copy($scope.opcion) );
            $scope.opcion = {};
        }
        
        
        
        $scope.duplicarPregunta = function(pregunta){
            $scope.preguntDuplicar = angular.copy(pregunta);
            $("#ModalDuplicarPregunta").modal("show");
        }
        
        $scope.guardarDuplicadoPregunta = function () {

            if (!$scope.preguntDuplicar.seccion) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            var data = {
                idEncuesta: $scope.encuesta.id,
                idPregunta: $scope.preguntDuplicar.id,
                idSeccion: $scope.preguntDuplicar.seccion
            };
            
            ServiEncuesta.duplicarPregunta(data).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuesta = data.data;
                            swal("¡Pregunta agregada!", "La pregunta se agregado exitosamente", "success");
                            $("#modalAgregarPregunta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push"); 
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
        
    }])
     
    .controller("ListarEncuestasCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        
        ServiEncuesta.getListadoEncuestas()
            .then(function(data){  
                $scope.encuestas = data.encuestas;
                for(var i=0;i<$scope.encuestas.length;i++){
                    for(var j=0;j<$scope.encuestas[i].idiomas.length;j++){
                        $scope.encuestas[i].nombreEsp = null;
                        if($scope.encuestas[i].idiomas[j].idiomas_id == 1){
                            $scope.encuestas[i].nombreEsp = $scope.encuestas[i].idiomas[j].nombre;
                        }
                    }
                }
                $scope.idiomas = data.idiomas;
                $scope.estados = data.estados;
                $scope.tipos = data.tipos;
                $scope.host = data.host;
            });
        
        
        $scope.openModalAddEncuesta = function(){
           
            $scope.encuesta = {};
            $scope.errores = null;
            $scope.formEncuesta.$setPristine();
            $scope.formEncuesta.$setUntouched();
            $scope.formEncuesta.$submitted = false;
            $("#modalAgregarEncuesta").modal("show");
            
        }
                     
        $scope.guardarEncuesta = function () {

            if (!$scope.formEncuesta.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.agregarEncuesta($scope.encuesta).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuestas.unshift(data.data);
                            swal("Encuesta agregada", "La encuesta se ha creado exitosamente", "success");
                            $("#modalAgregarEncuesta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push");
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push");
                    });
            
        }
        
        
        /*
        $scope.activarDesactivarEncuesta = function (encuesta) {
            swal({
                title: "Cambio de estado",
                text: "¿Esta seguro de "+( !encuesta.es_visible ? "activar":"desactivar" )+" la encuesta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.activarDesactivarEncuesta( {id:encuesta.id} ).then(function (data) {
                        if (data.success) {
                            encuesta.es_visible = data.estado;
                            swal("¡Modificado!", "El estado se ha modificado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        $scope.eliminarEncuesta = function (encuesta, index ) {
            swal({
                title: "Eliminar encuesta",
                text: "¿Esta seguro de eliminar la encuesta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.eliminarEncuesta( {id:encuesta.id} ).then(function (data) {
                        if (data.success) {
                            $scope.encuestas.splice(index,1);
                            swal("¡Eliminado!", "La pregunta se ha eliminado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        */
        
        $scope.OpenModalCambiarEstado = function(encuesta){
           
            $scope.CambiarEstado = angular.copy(encuesta);;
            $scope.errores = null;
            $scope.formEncuestaE.$setPristine();
            $scope.formEncuestaE.$setUntouched();
            $scope.formEncuestaE.$submitted = false;
            $("#modalEstadosEncuesta").modal("show");
            
        }
        
        $scope.guardarEstadoEncuesta = function () {

            if (!$scope.formEncuestaE.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            var data = {
                id : $scope.CambiarEstado.id,
                estado : $scope.CambiarEstado.estados_encuestas_id,
            };
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.cambiarEstadoEncuesta(data).then(function (data) {
                        if (data.success) {
                            for(var i=0; i<$scope.encuestas.length;i++){
                                if($scope.encuestas[i].id==$scope.CambiarEstado.id){
                                    $scope.encuestas[i].estados_encuestas_id = data.estado.id;
                                    $scope.encuestas[i].estado = data.estado;
                                    break;
                                }
                            }
                            swal("¡Cambio de estado!", "El estado se modificado exitosamente", "success");
                            $("#modalEstadosEncuesta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        $("body").attr("class", "cbp-spmenu-push");
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push");
                    });
            
        }
        
        
        $scope.OpenModalIdiomaEncuesta = function(encuesta, idioma ){
           
            $scope.idomaEncuesta = idioma ? angular.copy(idioma) : {};
            $scope.idomaEncuesta.idEncuesta = encuesta.id
            $scope.es_editar = idioma ? true : false;
            
            $scope.encuestaDetalle = encuesta;
            $scope.errores = null;
            $scope.formEncuestaI.$setPristine();
            $scope.formEncuestaI.$setUntouched();
            $scope.formEncuestaI.$submitted = false;
            $("#modalIdiomaEncuesta").modal("show");
            
        }
        
        $scope.guardarIdiomaEncuesta = function () {

            if (!$scope.formEncuestaI.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.guardarIdiomaEncuesta($scope.idomaEncuesta).then(function (data) {
                        if (data.success) {
                            for(var i=0; i<$scope.encuestas.length;i++){
                                if($scope.encuestas[i].id==data.data.id){
                                    $scope.encuestas[i] = data.data;
                                    break;
                                }
                            }
                            swal("¡Idioma "+($scope.es_editar?"editado":"agregado")+"!", "El idioma se guardado exitosamente", "success");
                            $("#modalIdiomaEncuesta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                            $("body").attr("class", "cbp-spmenu-push");
                        }
                        
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push");
                    });
            
        }
        
        
        $scope.duplicarEncuesta = function (encuesta) {
           
           $scope.duplicarencuesta = {
               id : encuesta.id,
               tipo : encuesta.tipos_encuestas_dinamica_id
           };
           $("#modalDuplicarEncuesta").modal("show"); 
          
        }
        $scope.guardarDuplicarEncuesta = function(){
           
           if (!$scope.formDE.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");  return;
            } 
           
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.duplicarEncuesta( $scope.duplicarencuesta )
            .then(function (data) {
                if (data.success) {
                    $scope.encuestas.unshift(data.data);
                    swal("¡Duplicada!", "La encuesta se ha duplicado exitosamente", "success");
                }
                else {
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
                
                $("body").attr("class", "cbp-spmenu-push");
                $("#modalDuplicarEncuesta").modal("hide"); 
                
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
                $("body").attr("class", "cbp-spmenu-push");
            });
        }
        
        $scope.openModalCopiar = function(item){
            
            if(item.tipos_encuestas_dinamica_id==1){
                $scope.link = $scope.host +  "/llenarEncuestaAdHoc/" +item.id;
            }
            else if(item.tipos_encuestas_dinamica_id==2){
                $scope.link = $scope.host +  "/encuestaAdHoc/" +item.id+ "/registro" ;
            }
            else{ return; }
            
            $("#modalCopyLink").modal("show");
        }
        
        $scope.copiarLink = function(){
            var copyText = document.getElementById("link");
            copyText.select();
            document.execCommand("copy");
        }  
        
        $scope.exportarData = function(id){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.getExcel( id )
                .then(function(response){ 
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(response);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $("body").attr("class", "cbp-spmenu-push");
                    zona.es_generada = true;
                });
            
        }
        
    }])
    
    .controller("ListarEncuestasRealizadasCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        
        ServiEncuesta.getListadoEncuestasRealidadas( $("#id").val() )
            .then(function(data){  
                $scope.encuesta = data.encuesta;
                $scope.host = data.host;
            });
        
        $scope.openModalAddEncuesta = function( ){
           
            $scope.usuario = { encuesta:$("#id").val() };
            $scope.errores = null;
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalAgregarEncuesta").modal("show");
        }   
        
        $scope.agregarencuestaUSuario = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.agregarencuestausuario($scope.usuario).then(function (data) {
                       
                if (data.success) {
                    $scope.encuesta.encuestas.push(data.encuesta);
                    sweetAlert("Encuesta agregada", "la encuesta se ha registrado exitosamenete en el sistema.", "success");
                    $("#modalAgregarEncuesta").modal("hide");
                }
                else {
                    $scope.errores = data.errores;
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
                $("body").attr("class", "cbp-spmenu-push");
            });
            
        }
        
        $scope.copiarLink = function(codigo){
            var $tempInput =  $("<textarea>");
            $("body").append($tempInput);
            $tempInput.val( $scope.host + "/encuestaAdHoc/" + codigo  ).select();
            document.execCommand("copy");
            $tempInput.remove();
        }        
        
    }])
    
    .controller("EstadisticasrEncuestasCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        $scope.options = {
                        legend: { display: true, position: 'bottom', labels: { fontColor: 'rgb(255, 99, 132)' }, },
                        scales: { xAxes: [{ display: true, stacked: true  }], yAxes: [{ display: true, stacked: true }] },
                        title: {  display: true, text: '', fontSize:16  }
                    };
        $scope.tipoGrafica = "bar";
        
        $scope.changePregunta = function(){
            
             $("body").attr("class", "cbp-spmenu-push charging");
             ServiEncuesta.estadisticasencuesta($scope.selectPregunta)
                .then(function(data){
                    $scope.data = data.data;
                    $scope.labels = data.labels;
                    $scope.series = data.series;
                    $scope.colores = [];
                    for(var i=0; i<$scope.data.length; i++){ $scope.colores.push($scope.getColor()); }
                    $scope.options.title.text = data.titulo;
                    $scope.options.legend.display = data.series.length==0 ? false : true;
                    $scope.isTablaContingencia = data.series.length==0 ? false : true;
                    $("body").attr("class", "cbp-spmenu-push");
                });
            
        };
        
        $scope.totales = function(){
            var s = 0;
            if($scope.data){ 
                for(var i=0; i<$scope.data.length; i++){
                   s  += $scope.data[i];    
                }    
            }
            return s;
        }
        
        $scope.getColor = function(){
        
            var r1 = Math.floor(Math.random()*256) ;
            var r2 = Math.floor(Math.random()*256) ;
            var r3 = Math.floor(Math.random()*256) ;
        
            return  {
                      backgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointBackgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointHoverBackgroundColor: "rgb("+r1+","+r2+","+r3+")",
                      borderColor: "rgb("+r1+","+r2+","+r3+")",
                      pointBorderColor: '#fff',
                      pointHoverBorderColor: "rgb("+r1+","+r2+","+r3+")"
                    };
        }
            
        
        $scope.descargarGrafica = function(){
            
             var link = document.createElement("a");
              link.download = "Grafica";
              link.href = document.getElementById('base').toDataURL(); //'image/jpeg', 1.0
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
              delete link;
        }    
            
    }])
    
}());