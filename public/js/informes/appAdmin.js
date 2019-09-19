angular.module('AppInformes', [ "InformesServices", "ADM-dateTimePicker" , "angularUtils.directives.dirPagination" ])

.config(['ADMdtpProvider', function(ADMdtp) {
    ADMdtp.setOptions({
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: '',
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    });
}])

.controller("InformesAdminCtrl", ['$scope', 'informesServi',function ($scope,informesServi) {

    $scope.tipos = [];
    $scope.categorias = [];
    $scope.informes = [];
    $scope.informeEdit = {};

    informesServi.getData()
                .then(function(data){
                    $scope.informes = data.informes;
                    $scope.tipos = data.tipos;
                    $scope.categorias = data.categorias;
                    $scope.idiomas = data.idiomas;
                });
    

    
    $scope.editarInforme = function (inf) {
        $scope.informeEdit = angular.copy(inf);
        $scope.informeEdit.tipo_documento_id = $scope.informeEdit.tipo_documento_id +"";
        $scope.informeEdit.categoria_doucmento_id = $scope.informeEdit.categoria_doucmento_id +"";
    }
    
    $scope.ModalIdiomas = function(idioma, informe){
        $scope.idiomaInforme = idioma ? angular.copy(idioma) : { publicaciones_id:informe.id };
        
        $scope.idiomasFiltrados = [];
        
        if(!idioma){
            for(var i=0; i<$scope.idiomas.length; i++){
                sw = 0;
                for(var j=0; j<informe.idiomas.length; j++){
                    if($scope.idiomas[i].id == informe.idiomas[j].idioma_id ){ sw=1; break; }
                }  
                if(sw==0){ $scope.idiomasFiltrados.push($scope.idiomas[i]); }
            }
        }
        else{ $scope.idiomasFiltrados=$scope.idiomas; }
        
        $scope.formIdioma.$setPristine();
        $scope.formIdioma.$setUntouched();
        $scope.formIdioma.$submitted = false;
        $("#modalIdioma").modal("show");
    }
    
    $scope.guardarIdioama = function(){
        
        if (!$scope.formIdioma.$valid) {
            swal("Error", "Verifique los errores en el formulario", "error");  return;
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        informesServi.guardarIdioama($scope.idiomaInforme)
           .then(function(data){
                
                if(data.success){
                    for(var i=0; i<$scope.informes.length; i++){
                       if($scope.informes[i].id==data.idioma.publicaciones_id){ 
                          
                           if($scope.idiomaInforme.idioma){
                                for(var j=0; j<$scope.informes[i].idiomas.length; j++){
                                    if($scope.informes[i].idiomas[j].idioma_id == data.idioma.idioma_id ){
                                      $scope.informes[i].idiomas[j] = data.idioma;  
                                      break;
                                    }
                                }
                           }
                           else{
                               $scope.informes[i].idiomas.push(data.idioma);
                           } 
                           break;
                       }
                    }
                    swal("Registro guardado", "El idioma se ha guardado exitosamente", "success");
                    $("#modalIdioma").modal("hide");
                    $("body").attr("class", "cbp-spmenu-push"); 
                }
               
           
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
                $("body").attr("class", "cbp-spmenu-push"); 
            });
        
    }
    
    $scope.cambiarEstado = function (inf) {
    
        swal({
            title: (inf.estado? "Desactivar" : "Activar ") + " informe",
            text: "¿Esta seguro que desea " +(inf.estado? "desactivar" : "activar ")+ " el informe?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            informesServi.cambiarEstado(inf.id)
               .then(function(data){
                    if(data.success){
                       inf.estado = data.estado;
                       swal("¡Modificado!", "El cambio de estado se ha realizado satisfactoriamente", "success");
                    }
                    else{
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    }
                }).catch(function () {
                    swal("Error", "Error en la carga, por favor recarga la página", "error");
                    $("body").attr("class", "cbp-spmenu-push"); 
                });
        });

    };
    
    $scope.ModalEliminarIdioma = function(informe){
        $scope.informe = informe;
        $scope.formElIdioma.$setPristine();
        $scope.formElIdioma.$setUntouched();
        $scope.formElIdioma.$submitted = false;
        $("#modalEliminarIdioma").modal("show");
    }
    
    $scope.eliminarIdioma = function () {
        
        if (!$scope.formElIdioma.$valid) {
            swal("Error", "Verifique los errores en el formulario", "error");  return;
        }
        
        
        var data = {
            publicaciones_id: $scope.informe.id,
            idioma_id: $scope.selectedIdiomaEliminar
        };
        
        swal({
            title: "Estas seguro de eliminar el idioma?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si!",
            cancelButtonText: "No",
            showLoaderOnConfirm: true,
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                informesServi.eliminarIdioma(data)
                   .then(function(data){
                        if(data.success){
                            for(var j=0; j<$scope.informe.idiomas.length; j++){
                                if($scope.selectedIdiomaEliminar == $scope.informe.idiomas[j].idioma_id ){ $scope.informe.idiomas.splice(j,1);  break; }
                            }  
                           swal("¡Eliminado!", "El idioma se ha eliminado satisfactoriamente", "success");
                           $("#modalEliminarIdioma").modal("hide");
                        }
                        else{
                            swal("Error", "Error en la carga, por favor recarga la página", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            } 
        });
        
    }

}]);


