var pp=angular.module('admin.modelospredictivos', ['adminservice','ui.select'])

.controller('IndexCtrl', ['$scope', 'adminService',function ($scope, adminService) {

    $scope.modelos={
        'variables':[]
    };
    $scope.aux=null;
    $scope.encabezados=[

        {'id':'actividad','nombre':'Actividad realizada'},
        {'id':'edad','nombre':'Edad'},
        {'id':'sexo','nombre':'Sexo'},
        {'id':'pais','nombre':'Pais'},
        {'id':'departamento','nombre':'Departamento'},
        {'id':'municipio','nombre':'Municipio'},
        {'id':'motivo_viaje','nombre':'Motivo de Viaje'},
        {'id':'numero_noches','nombre':'Numero de noches'},
        {'id':'gasto','nombre':'Gasto'}                        
        ];

    $scope.variablespredecir=[

        {'id':'edad','nombre':'Edad'},       
        {'id':'numero_noches','nombre':'Numero de noches'},
        {'id':'gasto','nombre':'Gasto'}                        
        ];
    $scope.ver=false;

    adminService.getDatos()
        .then(function(data){

            $scope.actividades=data.actividades;
            $scope.paises=data.pais;
            $scope.departamentos=data.departamentos;
            $scope.municipios=data.municipios;
            $scope.motivos=data.motivos;
            
        })
        .catch(function(){
            swal("Error","Hubo un error con los datos reinicie la pagina","error");
        });

    $scope.cambio=function(){

        var indice=$scope.buscar($scope.encabezados,'id',$scope.modelos.predicion);
        if(indice<0){
            return;
        }

        if($scope.aux != null){
            $scope.encabezados.push($scope.aux);
        }

        $scope.aux=$scope.encabezados[indice];
        $scope.encabezados.splice(indice,1);       

    }

    $scope.predecir=function()
    {
        $scope.ver=false;
        if(!$scope.addForm.$valid){
            alert("Error","Llene todos los campos obligatorios","error");
            return;
        }

        adminService.predecir($scope.modelos)
            .then(function(data){
                $scope.ver=data.success;
                $scope.data=data;
            })
            .catch(function(){
                swal("Error","Hubo un error con los datos reinicie la pagina","error");
            })
    }


    $scope.buscar=function(array,campo,filter){

        for(var i=0;i<array.length;i++){
            if(array[i][campo]==filter){
                return i;
            }
        }

        return -1;
    }
    
    
    
    

}])
