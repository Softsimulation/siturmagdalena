(function(){

    angular.module("appProyect", [ 'ngTagsInput','ngSanitize', 'ui.select', 'checklist-model','angularUtils.directives.dirPagination', "ADM-dateTimePicker", "dndLists", "servicios", "generadorCampos" ] )
    
    
    
    .config(["ADMdtpProvider", function(ADMdtpProvider,ChartJsProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" })
    }])
    
    .directive('fileInput', ['$parse', function ($parse) {
        
            return {
                restrict: 'A',
                link: function (scope, elm, attrs) {
                    elm.bind('change', function () {
                        $parse(attrs.fileInput).assign(scope, elm[0].files);
                        scope.$apply();
                    })
                }
            }
        }])

    .controller("publicacionCrearCtrl", ["$scope","ServiPublicacion", function($scope,ServiPublicacion){
        $scope.publicacion ={};
        $scope.publicacion.personas = [];
        $scope.publicacion.temas = [];
        ServiPublicacion.getData()
                            .then(function(data){
                                $scope.tipos = data.tipos;
                                $scope.paises = data.paises;
                                $scope.personas = data.personas;
                                $scope.temas = data.temas;
                                
                            });   
                            
                            
        
        $scope.agregarPublicacion = function(){
            
            if ((!$scope.formCrear.$valid) || $scope.publicacion.personas.length == 0 || $scope.publicacion.temas.length == 0 || $scope.soporte_carta == null || $scope.soporte_publicacion == null || $scope.portada == null ) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
        var input = $('#soporte_publicacion');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
        var input = $('#portada');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
          var input = $('#soporte_carta');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
     
        var fd = new FormData();
        for (item in $scope.publicacion) {
          
            if ($scope.publicacion[item] != null && $scope.publicacion[item] != "" && $scope.publicacion[item] != "temas" && $scope.publicacion[item] != "personas" && $scope.publicacion[item] != "palabrasClaves") {
                fd.append(item, $scope.publicacion[item])
            }
        }
        

        for (i = 0; i < $scope.publicacion.temas.length; i++) {
          
            fd.append("temas[]",$scope.publicacion.temas[i]);
            

        }
        
         fd.append("personas",JSON.stringify($scope.publicacion.personas));
         fd.append("palabrasClaves",JSON.stringify($scope.publicacion.palabrasClaves));
        
        if ($scope.soporte_carta != null) {
            fd.append("soporte_carta", $scope.soporte_carta[0]);
        }
        
        if ($scope.soporte_publicacion != null) {
            fd.append("soporte_publicacion", $scope.soporte_publicacion[0]);
        }    
        
         if ($scope.portada != null) {
            fd.append("portada", $scope.portada[0]);
        }    
           $("body").attr("class", "charging");
         ServiPublicacion.agregarPublicacion(fd).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push")
                swal({
                    title: "Realizado",
                    text: "Se ha guardado satisfactoriamente la correspondencia.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                
                 location.href="/publicaciones/listadoadmin";
                 
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = data.errores;
            }
           $("body").attr("class", "cbp-spmenu-push")
        }).catch(function () {
            $('#processing').removeClass('process-in');
             $("body").attr("class", "cbp-spmenu-push")
        })
            
            
            
            
        }
        
        $scope.abrirAgregarPersona = function(){
            
             var persona = {};
            $scope.formCrear.$setPristine();
            $scope.formCrear.$setUntouched();
            $scope.formCrear.$submitted = false;
            $scope.publicacion.personas.push(persona);
                
        }
         $scope.remove = function(i){
                    $scope.publicacion.personas.splice(i,1);
         }
        
        
  
        
        $scope.buscarPersona = function(obj){
            
            for(i = 0; i < $scope.personas.length; i++){
                if(obj.email == $scope.personas[i].email){
                    obj.nombres = $scope.personas[i].nombres;
                    obj.apellidos = $scope.personas[i].apellidos;
                    obj.paises_id = $scope.personas[i].paises_id;
                    return
                    
                }
                obj.id = -1;
            }
        }
        

        
        
        
    }])
    
     .controller("ListadoPublicacionCtrl", ["$scope","ServiPublicacion", function($scope,ServiPublicacion){

$("body").attr("class", "charging");
    ServiPublicacion.getListado()
                            .then(function(data){
                                 $("body").attr("class", "cbp-spmenu-push")
                                $scope.publicaciones = data.Publicaciones;
                                for(var i=0;i<$scope.publicaciones.length;i++){
                                    $scope.publicaciones[i].estado = $scope.publicaciones[i].estado_publicacion.nombre;
                                    $scope.publicaciones[i].tipoPublicacion = $scope.publicaciones[i].tipopublicacion.idiomas[0].nombre;
                                }
                                $scope.estados = data.estados;
                            });   
                            
        
       $scope.cambiarEstado = function (obj) {
        swal({
            title: "cambiar estado publicación ",
            text: "¿Está seguro que desea cambiar el estado de la publicación ?",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            $("body").attr("class", "charging");
            ServiPublicacion.cambiarEstadoPublicacion(obj).then(function (data) {
                 $("body").attr("class", "cbp-spmenu-push")
                if (data.success) {
                    obj.estado = !obj.estado;
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                } else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
            }).catch(function () {
                swal("Error", "Error en la petición, intente de nuevo", "error");
            })

        })


    }
    
    $scope.cambiarEstadoPublicacion = function (item) {
        $scope.estado = angular.copy(item);
        $scope.indexitem = $scope.publicaciones.indexOf(item);
        $scope.cambiarForm.$setPristine();
        $scope.cambiarForm.$setUntouched();
        $scope.cambiarForm.$submitted = false;
       $scope.erroresEstado = null;
        $('#modalCambiarEstado').modal('show');
    }
    
     $scope.cambioEstado = function () {
         if (!$scope.cambiarForm.$valid) {
            return;
        }
       $scope.erroresEstado = null;
         $("body").attr("class", "charging");
        ServiPublicacion.EstadoPublicacion($scope.estado).then(function (data) {
             $("body").attr("class", "cbp-spmenu-push")
            if (data.success) {
               $scope.errores = null;
                $scope.publicaciones[$scope.indexitem] = data.publicacion;
                swal({
                    type: "success",
                    title: "Realizado",
                    text: "Se ha agregado satisfactoriamente la agenda.",
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#modalCambiarEstado').modal('hide');
            } else {
               $scope.erroresEstado  = data.errores;
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
            }
            $('#processing').removeClass('process-in');
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
      
          }
    
    
       $scope.eliminar = function (obj) {
        swal({
            title: "Eliminar publicación ",
            text: "¿Está seguro que desea eliminar la publicación ?",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
             $("body").attr("class", "charging");
            ServiPublicacion.eliminarPublicacion(obj).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                if (data.success) {
                    $scope.publicaciones.splice($scope.publicaciones.indexOf(obj),1)
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                } else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
            }).catch(function () {
                swal("Error", "Error en la petición, intente de nuevo", "error");
            })

        })


    }
        
        
    }])
    
     .controller("publicacionEditarCtrl", ["$scope","ServiPublicacion", function($scope,ServiPublicacion){

        $scope.$watch("id", function() {
              $("body").attr("class", "charging");
        if($scope.id){
                ServiPublicacion.getEncuesta($scope.id)
                            .then(function(data){
                                $("body").attr("class", "cbp-spmenu-push")
                                $scope.tipos = data.tipos;
                                $scope.paises = data.paises;
                                $scope.personas = data.personas;
                                $scope.temas = data.temas;
                                $scope.publicacion = data.publicacion;
                            });
            }
        });
       
                            
        
      $scope.editarPublicacion = function(){
            
        if ((!$scope.formEditar.$valid) || $scope.publicacion.personas.length == 0 || $scope.publicacion.temas.length == 0 ) {
            swal("Error", "Verifique los errores en el formulario", "error");
            return;
        }
            
           var input = $('#soporte_publicacion');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
        var input = $('#portada');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
          var input = $('#soporte_carta');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 15728640) {
                swal("Error", "Por favor el soporte debe tener un peso menor de " + (15728640 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
     
     
        var fd = new FormData();
        for (item in $scope.publicacion) {
          
            if ($scope.publicacion[item] != null && $scope.publicacion[item] != "" && item != "temas" && item != "personas" && item != "palabrasClaves" && item != "portada") {
                fd.append(item, $scope.publicacion[item])
            }
        }
        

        for (i = 0; i < $scope.publicacion.temasId.length; i++) {
          
            fd.append("temasId[]",$scope.publicacion.temasId[i]);
            

        }
        
         fd.append("personas",JSON.stringify($scope.publicacion.personas));
         fd.append("palabrasClaves",JSON.stringify($scope.publicacion.palabras));
        
        if ($scope.soporte_carta != null) {
            fd.append("soporte_carta", $scope.soporte_carta[0]);
        }
        
        if ($scope.soporte_publicacion != null) {
            fd.append("soporte_publicacion", $scope.soporte_publicacion[0]);
        }    
        
         if ($scope.portada != null) {
            fd.append("portada", $scope.portada[0]);
        }    
           $("body").attr("class", "charging");    
         ServiPublicacion.editarPublicacion(fd).then(function (data) {
              $("body").attr("class", "cbp-spmenu-push")
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Se ha guradado satisfactoriamente la correspondencia.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                 location.href="/publicaciones/listadoadmin";
                 
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = data.errores;
            }
            $('#processing').removeClass('process-in');
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
            
            
            
            
        }
        
        $scope.abrirAgregarPersona = function(){
            
             var persona = {};
            $scope.publicacion.personas.push(persona);
                
        }
         $scope.remove = function(i){
                    $scope.publicacion.personas.splice(i,1);
         }
        
        
  
        
        $scope.buscarPersona = function(obj){
            
            for(i = 0; i < $scope.personas.length; i++){
                if(obj.email == $scope.personas[i].email){
                    obj.nombres = $scope.personas[i].nombres;
                    obj.apellidos = $scope.personas[i].apellidos;
                    obj.paises_id = $scope.personas[i].paises_id;
                    return
                    
                }
                obj.id = -1;
            }
        }
        

        
        
        
    }])
    
    .controller("ConfigurarEncuestaCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        $scope.tabOpen = { activo:0} ;
        
        $scope.$watch("id", function() {
            if($scope.id){
                ServiEncuesta.getData($scope.id)
                            .then(function(data){
                                $scope.encuesta = data.encuesta;
                                $scope.idiomas = data.idiomas;
                                $scope.tiposCamos = data.tiposCamos;
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
                opciones : []
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
                        
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
            
        }
        
        
        $scope.activarDesactivarPeegunta = function (pregunta) {
            swal({
                title: "Cambio de estado",
                text: "¿Esta seguro de "+(pregunta.estado ? "activar":"desactivar" )+" la pregunta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    ServiEncuesta.activarDesactivarPeegunta( {id:pregunta.id} ).then(function (data) {
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
            
            for(var i=0; i<$scope.ordenarPreguntas; i++){ $scope.guardarOrden.preguntas.push($scope.ordenarPreguntas[i].id); }
            
            ServiEncuesta.guardarOrdenPreguntas( $scope.guardarOrden ).then(function (data) {
                if (data.success) {
                    $scope.encuesta = data.data;
                    swal("¡Orden modificado!", "El nuevo orden de las preguntas se ha registrado exitosamente", "success");
                    $("#openModalOrdenPreguntas").modal("hide");
                }
                else {
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            });
        }
        
        
        $scope.OpenModalAgregarIdiomaPregunta = function(pregunta){
           
            $scope.idomaPregunta = {
                idSeccion : pregunta.secciones_encuestas_id,
                idPregunta : pregunta.id,
                idEncuesta : $scope.encuesta.id,
                tipoCampo : pregunta.tipo_campos_id,
                opciones :  $scope.getOpcionesPregunta(pregunta)
            }
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
                opciones : []
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
        
        
        $scope.guardarIdiomaPregunta = function () {

            if (!$scope.formPreguntaIdioma.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            ServiEncuesta.guardarIdiomaPregunta($scope.idomaPregunta).then(function (data) {
                       
                        if (data.success) {
                            $scope.encuesta = data.data;
                            swal("¡Idioma agregado!", "El idioma se agregado exitosamente", "success");
                            $("#modalAgregarIdiomaPregunta").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                        
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
            
        }
        
        
    }])
     
    .controller("EncuestaCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        
             ServiEncuesta.getDataSeccionEncuesta($scope.id)
                            .then(function(data){
                                $scope.seccion = data;
                            });   
                          
        
    }])
    
}());