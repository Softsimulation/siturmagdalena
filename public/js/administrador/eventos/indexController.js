/* global angular */
/* global swal */
angular.module('eventos.index', [])

.controller('eventosIndexController', function($scope, eventosServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    eventosServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.eventos = data.eventos;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (evento){
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.postDesactivarActivar(evento.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                evento.estado = !evento.estado;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.sugerir = function (evento){
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.postSugerir(evento.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                evento.sugerido = !evento.sugerido;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.modalIdioma = function (atraccion){
        $scope.eventoEdit = atraccion;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradoreventos/idioma/"+ $scope.eventoEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
    $scope.busquedaEvento = function (query){
        
        if (query === undefined || query === ''){
            return;
        }
        
        return function (evento){
            return (evento.eventos_con_idiomas[0].nombre + ' - ' + evento.eventos_con_idiomas[0].edicion).toLocaleLowerCase().includes(query.toLocaleLowerCase());
        }
    }
    
});