angular.module('receptor.percepcion_viaje', [])

.controller('percepcion-crear', ['$scope', 'receptorServi', function ($scope, receptorServi) {

    $scope.bandera = false;
    $scope.estadoEncuesta = null;
    $scope.calificacion = {
        'Elementos': []
    }
    $scope.cal = {};
    $scope.calificacion.Evaluacion = [];

    $scope.Id = null;
    $scope.aspectos = {
        'Items': [],
        'radios': {}
    }

    $scope.$watch("Id", function () {

        if ($scope.Id != null) {
            $("body").attr("class", "cbp-spmenu-push charging");
            
            receptorServi.getDatosSeccionPercepcion($scope.Id).then(function (data) {
                if(data.success){
                    $("body").attr("class", "cbp-spmenu-push");
                    
                    $scope.aspectos = $scope.convertirObjeto(data.percepcion);
                    $scope.elementos = data.elementos;
                    $scope.veces = data.veces;
                    $scope.actividades = data.actividades;
    
                    if (data.respuestaElementos.length ==0 && data.valoracion == null) {
                        $scope.estadoEncuesta = 0;
                    } else {
                        $scope.calificacion.Alojamiento = data.alojamiento;
                        $scope.calificacion.Factores = data.factores;
                        $scope.calificacion.Ocio = data.ocio;
                        $scope.calificacion.Infra = data.infraestructura;
                        if($scope.calificacion.Infra == 1){
                            document.getElementById("infraestructuraSi").checked = true;
                        }else{
                            document.getElementById("infraestructuraNo").checked = true;
                        }
                        $scope.calificacion.Restaurante = data.restaurante;
                        $scope.calificacion.Elementos = data.respuestaElementos;
                        $scope.calificacion.Recomendaciones = data.valoracion.Recomendacion;
                        $scope.calificacion.Calificacion = data.valoracion.Calificacion;
                        $scope.calificacion.Volveria = data.valoracion.Volveria;
                        $scope.calificacion.Recomienda = data.valoracion.Recomienda;
                        $scope.calificacion.VecesVisitadas = data.valoracion.Veces;
                        $scope.calificacion.OtroElementos = data.otroElemento;
                        $scope.calificacion.Flora = data.flora;
                        $scope.calificacion.Sostenibilidad = data.sost;
                        $scope.estadoEncuesta = 1;
                        if (data.restaurante == -1) {
                            $scope.calificacion.Restaurante = 0;
                        }
                        if (data.alojamiento == -1) {
                            $scope.calificacion.Alojamiento = 0;
                        }
                        if (data.OtroElemento != null) {
                            $scope.calificacion.OtroElementos = data.OtroElemento;
                        }
                    }
                }else{
                    $("body").attr("class", "cbp-spmenu-push");
                    $scope.errores = data.errores;
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error");
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        }
    });
    
    $scope.convertirObjeto = function(arreglo){
        if(arreglo != undefined){
            for(var i = 0; i < arreglo.length; i++){
                for(var j = 0; j < arreglo[i].items_evaluars.length; j++){
                    if(arreglo[i].items_evaluars[j].calificacions.length > 0){
                        arreglo[i].items_evaluars[j].radios = {
                            Id : arreglo[i].items_evaluars[j].calificacions[0].item_evaluar_id,
                            Valor : arreglo[i].items_evaluars[j].calificacions[0].calificacion
                        };    
                    }
                }
            }    
        }
        return arreglo;
    }

    $scope.chequeado = function (id) {
        for (var i = 0; i < $scope.aspectos.length; i++) {
            for (var j = 0; j < $scope.aspectos[i].items_evaluars.length; j++) {
                if ($scope.aspectos[i].items_evaluars[j].radios.Id = id) {
                    return true;
                }
            }
            return false;
        }
    }

    $scope.limpiarFila = function(it){
        for (var i = 0; i < $scope.aspectos.length; i++) {
            for (var j = 0; j < $scope.aspectos[i].items_evaluars.length; j++) {
                if ($scope.aspectos[i].items_evaluars[j].radios != null) {
                    if ($scope.aspectos[i].items_evaluars[j].radios.Id == it) {
                        $scope.aspectos[i].items_evaluars[j].radios = null;
                        break;
                    }

                   
                }
            }
        }
    }

    $scope.limpiar = function (control,inicio,fin) {

       if (control == 0) {
            for (var i = 0; i < $scope.aspectos.length; i++) {
                for (var j = 0; j < $scope.aspectos[i].items_evaluars.length; j++) {    
                    if ($scope.aspectos[i].items_evaluars[j].radios!=null) {
                        for (var k = inicio; k <= fin; k++) {
                            if ($scope.aspectos[i].items_evaluars[j].radios.Id == k) {
                                $scope.aspectos[i].items_evaluars[j].radios = null;
                                break;
                            }
                          
                        }
                    }
                }
            }
        }
    }

    $scope.checkedRadio = function (id, obj, selected) {
        if ($scope.estadoEncuesta == 1) {
            if (obj == selected) {
                document.getElementById(id).checked = true;
            }
        }

    }

    $scope.guardar = function () {

        if (!$scope.PercepcionForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error");
            return;
        }


        $scope.calificacion.Evaluacion = [];
        for (var i = 0; i < $scope.aspectos.length; i++) {
            for (var j = 0; j < $scope.aspectos[i].items_evaluars.length; j++) {

                if ($scope.aspectos[i].items_evaluars[j].radios!=null) {
                    $scope.calificacion.Evaluacion.push($scope.aspectos[i].items_evaluars[j].radios);
                    //console.log($scope.aspectos[i].Items[j].radios)
                }
            }
        }
        $scope.calificacion.Id = $scope.Id;

        $("body").attr("class", "cbp-spmenu-push charging");
        
        
        receptorServi.guardarSeccionPercepcion($scope.calificacion).then(function (data) {
            if(data.success){
                $("body").attr("class", "cbp-spmenu-push");
                
                var msj;
                 if (data.sw == 0) {
                     msj = "guardado";
                 } else {
                     msj = "editado";
                 }
                 swal({
                     title: "Realizado",
                     text: "Se ha " + msj + " satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                   });
                    setTimeout(function () {
                        window.location.href = "/turismoreceptor/seccionfuentesinformacion/" + $scope.Id;
                     }, 1000);
            }else{
                $("body").attr("class", "cbp-spmenu-push");
                $scope.errores = data.errores;
                swal("Error", "Corrija los errores", "error");
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    }

    $scope.verificarOtro = function () {
        
        var i = $scope.calificacion.Elementos.indexOf(12)
        if ($scope.calificacion.OtroElementos != null && $scope.calificacion.OtroElementos != '') {
            if (i == -1) {
                $scope.calificacion.Elementos.push(12);
                $scope.bandera = true;
            }
        } else {
            if (i !== -1) {
                $scope.calificacion.Elementos.splice(i, 1);
                $scope.bandera = false;
            }
        }
    }

}])
.controller('percepcion-crear_visitante', ['$scope','$http',function ($scope, $http) {

    $scope.bandera = false;
    $scope.estadoEncuesta = null;
    $scope.calificacion = {
        'Elementos': []
    }
    $scope.cal = {};
    $scope.calificacion.Evaluacion = [];

    $scope.Id = null;
    $scope.aspectos = {
        'Items': [],
        'radios': {}
    }

    $scope.$watch("Id", function () {

        if ($scope.Id != null) {
            $("body").attr("class", "cbp-spmenu-push charging");
            $http.get('/EncuestaReceptorVisitante/cargarDatosPercepcion/' + $scope.Id)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.aspectos = data.percepcion;
                $scope.elementos = data.elementos;
                $scope.veces = data.veces;

                if (data.respuestaElementos == null && data.valoracion == null || data.respuestaElementos.length == 0) {
                    $scope.estadoEncuesta = 0;
                } else {
                    $scope.calificacion.Alojamiento = data.alojamiento;
                    $scope.calificacion.Restaurante = data.restaurante;
                    $scope.calificacion.Elementos = data.respuestaElementos;
                    $scope.calificacion.Recomendaciones = data.valoracion.Recomendacion;
                    $scope.calificacion.Calificacion = data.valoracion.Calificacion;
                    $scope.calificacion.Volveria = data.valoracion.Volveria;
                    $scope.calificacion.Recomienda = data.valoracion.Recomienda;
                    $scope.calificacion.VecesVisitadas = data.valoracion.Veces;
                    $scope.calificacion.OtroElementos = data.otroElemento;
                    $scope.estadoEncuesta = 1;
                    if (data.restaurante == -1) {
                        $scope.calificacion.Restaurante = 0;
                    }
                    if (data.alojamiento == -1) {
                        $scope.calificacion.Alojamiento = 0;
                    }
                    if (data.OtroElemento != null) {
                        $scope.calificacion.OtroElementos = data.OtroElemento;
                    }
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            })
        }

    });

    $scope.chequeado = function (id) {
        for (var i = 0; i < $scope.aspectos.length; i++) {
            for (var j = 0; j < $scope.aspectos[i].Items.length; j++) {
                if ($scope.aspectos[i].Items[j].radios.Id = id) {
                    return true;
                }
            }
            return false;
        }
    }

    $scope.limpiar = function (control, inicio, fin) {

        if (control == 0) {
            for (var i = 0; i < $scope.aspectos.length; i++) {
                for (var j = 0; j < $scope.aspectos[i].Items.length; j++) {
                    if ($scope.aspectos[i].Items[j].radios != null) {
                        for (var k = inicio; k <= fin; k++) {
                            if ($scope.aspectos[i].Items[j].radios.Id == k) {
                                $scope.aspectos[i].Items[j].radios = null;
                                break;
                            }

                        }
                    }
                }
            }
        }
    }

    $scope.checkedRadio = function (id, obj, selected) {
        if ($scope.estadoEncuesta == 1) {
            if (obj == selected) {
                document.getElementById(id).checked = true;
            }
        }

    }

    $scope.guardar = function () {

        if (!$scope.PercepcionForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error");
            return;
        }

        if ($scope.calificacion.Elementos == 0) {
            swal("Error", "Formulario incompleto corrige los errores", "error");
            return;
        }

        for (var i = 0; i < $scope.aspectos.length; i++) {
            for (var j = 0; j < $scope.aspectos[i].Items.length; j++) {

                if ($scope.aspectos[i].Items[j].radios != null) {
                    $scope.calificacion.Evaluacion.push($scope.aspectos[i].Items[j].radios);
                    //console.log($scope.aspectos[i].Items[j].radios)
                }
            }
        }

        $scope.calificacion.visitante = $scope.Id;
        $scope.mandar = null;
        if ($scope.estadoEncuesta == 0) {
            $scope.mandar = "guardarSeccionF";
        } else {
            $scope.mandar = "EditarSeccionF";
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/EncuestaReceptorVisitante/' + $scope.mandar + '', $scope.calificacion)
         .success(function (data) {
             $("body").attr("class", "cbp-spmenu-push");
             if (data.success == true) {
                 //swal("Exitoso", "Se ha guardado", "success")
                 $("body").attr("class", "cbp-spmenu-push");
                 var msj;
                 if ($scope.estadoEncuesta == 0) {
                     msj = "guardado";
                 } else {
                     msj = "editado";
                 }
                 swal({
                     title: "Realizado",
                     text: "Se ha " + msj + " satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                 });
                 setTimeout(function () {
                     window.location.href = "/EncuestaReceptorVisitante/FuentesInformacionVisitante/" + $scope.Id;
                 }, 1000);


             





             } else {
                 $("body").attr("class", "cbp-spmenu-push");
                 $scope.errores = data.errores;
                 swal("Error", "Error en la carga, por favor recarga la página", "error");
             }

         })
        //console.log($scope.calificacion.Evaluacion)

    }

    $scope.verificarOtro = function () {

        var i = $scope.calificacion.Elementos.indexOf(11);
        if ($scope.calificacion.OtroElementos != null && $scope.calificacion.OtroElementos != '') {
            if (i == -1) {
                $scope.calificacion.Elementos.push(11);
                $scope.bandera = true;
            }
        } else {
            if (i !== -1) {
                $scope.calificacion.Elementos.splice(i, 1);
                $scope.bandera = false;
            }
        }
    }


}])