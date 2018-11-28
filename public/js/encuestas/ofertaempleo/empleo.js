angular.module('empleo.Empleo', [])

.controller('empleoMensual', ['$scope', 'ofertaServi',function ($scope, ofertaServi){
    $scope.empleo = {};
    $scope.url = "";
    $scope.dataTable = "<th>M</th> <th>F</th>"; 

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
         ofertaServi.cargarDatosEmplMensual($scope.id).then(function (data) {
                 $("body").attr("class", "cbp-spmenu-push")
                $scope.empleo = data.empleo;
                $scope.tipo_cargo = data.tipo_cargo;
                $scope.url = data.url;
                $scope.proveedor =data.proveedor;
                if($scope.empleo.VacanteOperativo == null){
                    $scope.empleo.VacanteGerencial = 0;
                    $scope.empleo.VacanteAdministrativo = 0;
                    $scope.empleo.VacanteOperativo = 0;
                    
                }
                  
        }).catch(function () {
              $("body").attr("class", "cbp-spmenu-push")
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
       
        
    });


    

    $scope.cargo = function(tipo){
        if($scope.empleo.Sexo){
        for(i = 0; i < $scope.empleo.Sexo.length ; i ++){
            
            if($scope.empleo.Sexo[i].tipo_cargo_id == tipo ){
                
                return $scope.empleo.Sexo[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.hombres = 0;
        obj.mujeres = 0;
        
        $scope.empleo.Sexo.push(obj);
        
        return obj;

        }        
    }

    $scope.Totalcargo = function(){
        if($scope.empleo.Sexo){
            
            var    total = 0;
            for(i = 0; i < $scope.empleo.Sexo.length ; i ++){
                  total = total +  $scope.empleo.Sexo[i].hombres  +  $scope.empleo.Sexo[i].mujeres;
                
                }
                
            }else{
                
                return 0;
            }
        
            return total;    
     

        }        
    

     $scope.Total = function(item,item2){
        if($scope.empleo[item]){
            
            var    total = 0;
            for(i = 0; i < $scope.empleo[item].length ; i ++){
                total =  total + ($scope.empleo[item][i][item2] == null ? 0 : ($scope.empleo[item][i][item2] == undefined ? 0 : $scope.empleo[item][i][item2]));
                
                }
                
            }else{
                
                return 0;
            }
        
            return total;    
     

        }   

    $scope.totalfila = function(obj,tipo,sexo){
        if(obj){
                for(i = 0; i < obj.length ; i ++){
                    
                    if(obj[i].tipo_cargo_id == tipo && obj[i].sexo == sexo ){
                        var suma = 0;
                        for (item in obj[i]) {
                        if(!(item == "id" || item == "sexo" || item == "tipo_cargo_id" || item == "encuestas_id" || item == "encuesta_id"))
                                suma = suma + (obj[i][item] == null ? 0 : (obj[i][item] == undefined ? 0 :obj[i][item]));
                              
                            
                        }
                        return suma;
                    }
                    
                }
        
        }
        return 0;

                
    }
    

    $scope.edadempleado = function(tipo,sexo){
        if($scope.empleo.Edad){
        for(i = 0; i < $scope.empleo.Edad.length ; i ++){
            
            if($scope.empleo.Edad[i].tipo_cargo_id == tipo && $scope.empleo.Edad[i].sexo == sexo ){
                
                return $scope.empleo.Edad[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
		obj.docea18 = 0;
		obj.diecinuevea25 = 0;
		obj.ventiseisa40 = 0;
		obj.cuarentayunoa64 = 0;
		obj.mas65 = 0;
        $scope.empleo.Edad.push(obj);
        
        return obj;

        }        
    }

    
       $scope.eduacionempleado = function(tipo,sexo){
        if($scope.empleo.Educacion){
        for(i = 0; i < $scope.empleo.Educacion.length ; i ++){
            
            if($scope.empleo.Educacion[i].tipo_cargo_id == tipo && $scope.empleo.Educacion[i].sexo == sexo ){
                
                return $scope.empleo.Educacion[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false;
		obj.ninguno = 0;
		obj.posgrado = 0;
		obj.bachiller = 0;
		obj.primaria = 0;
		obj.universitario = 0;
		obj.tecnico = 0;
		obj.tecnologo = 0;
        $scope.empleo.Educacion.push(obj);
        
        return obj;

        }        
    }


  $scope.ingleempleado = function(tipo,sexo){
        if($scope.empleo.ingles){
        for(i = 0; i < $scope.empleo.ingles.length ; i ++){
            
            if($scope.empleo.ingles[i].tipo_cargo_id == tipo && $scope.empleo.ingles[i].sexo == sexo ){
                
                return $scope.empleo.ingles[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
        obj.sabeningles = 0;
        $scope.empleo.ingles.push(obj);
        
        return obj;

        }        
    }


  $scope.vinculacionempleado = function(tipo,sexo){
        if($scope.empleo.Vinculacion){
        for(i = 0; i < $scope.empleo.Vinculacion.length ; i ++){
            
            if($scope.empleo.Vinculacion[i].tipo_cargo_id == tipo && $scope.empleo.Vinculacion[i].sexo == sexo ){
                
                return $scope.empleo.Vinculacion[i];
            }
            
        }
        
        obj = {};
        obj.sexo = sexo == 1 ? true : false ;
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
		obj.contrato_direto = 0;
		obj.personal_permanente = 0;
		obj.personal_agencia = 0;
		obj.trabajador_familiar = 0;
		obj.propietario = 0;
		obj.aprendiz = 0;
		obj.cuenta_propia = 0;
        $scope.empleo.Vinculacion.push(obj);
        
        return obj;

        }        
    }


  $scope.tiempoempleado = function(tipo,sexo){
        if($scope.empleo.Empleo){
        for(i = 0; i < $scope.empleo.Empleo.length ; i ++){
            
            if($scope.empleo.Empleo[i].tipo_cargo_id == tipo && $scope.empleo.Empleo[i].sexo == sexo ){
                
                return $scope.empleo.Empleo[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
		obj.tiempo_completo = 0;
		obj.medio_tiempo = 0;
        $scope.empleo.Empleo.push(obj);
        
        return obj;

        }        
    }

  $scope.remuneracion = function(tipo,sexo){
        if($scope.empleo.Remuneracion){
        for(i = 0; i < $scope.empleo.Remuneracion.length ; i ++){
            
            if($scope.empleo.Remuneracion[i].tipo_cargo_id == tipo && $scope.empleo.Remuneracion[i].sexo == sexo ){
                
                return $scope.empleo.Remuneracion[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
		obj.valor = 0;
        $scope.empleo.Remuneracion.push(obj);
        
        return obj;

        }        
    }

    $scope.promedio = function(){
        
        if( $scope.remuneracion(1,1) == null){
            return 0;
        }
        var valor =  ($scope.remuneracion(1,1).valor*$scope.cargo(1).hombres) + ($scope.remuneracion(1,0).valor*$scope.cargo(1).mujeres) + ($scope.remuneracion(2,1).valor*$scope.cargo(2).hombres) + ($scope.remuneracion(2,0).valor*$scope.cargo(2).mujeres) + ($scope.remuneracion(3,1).valor*$scope.cargo(3).hombres) + ($scope.remuneracion(3,0).valor*$scope.cargo(3).mujeres) ; 
        
        var valor2 =  ( $scope.cargo(1).mujeres + $scope.cargo(1).hombres + $scope.cargo(2).mujeres + $scope.cargo(2).hombres + $scope.cargo(3).mujeres + $scope.cargo(3).hombres)
        if (valor2 != 0){ 
        return valor / valor2
        }
        return 0
    }

    $scope.vacantesSi = function(){
        var vacante  = ( $scope.empleo.VacanteOperativo == null ? 0 : ($scope.empleo.VacanteOperativo  == undefined ? 0 :$scope.empleo.VacanteOperativo ));
         var vacante2  = ( $scope.empleo.VacanteAdministrativo == null ? 0 : ($scope.empleo.VacanteAdministrativo  == undefined ? 0 :$scope.empleo.VacanteAdministrativo ));
        var vacante3  = ( $scope.empleo.VacanteGerencial == null ? 0 : ($scope.empleo.VacanteGerencial  == undefined ? 0 :$scope.empleo.VacanteGerencial ));
       
        
        if((  vacante +  vacante2  + vacante3   ) > 0){
        return true;
        }else{
            if($scope.empleo != null){
                $scope.empleo.Razon = {};
                $scope.empleo.Razon.apertura = 0;
                $scope.empleo.Razon.crecimiento = 0;
                $scope.empleo.Razon.remplazo = 0;
            }
            return false;
        }
    }
    
     $scope.validacion = function(){
        
        
        return true;
    }
    
        
    $scope.guardar = function () {
        $scope.empleo.Encuesta = $scope.id;
        if ($scope.empleoForm.$valid && $scope.validacion()) {
            
            $("body").attr("class", "cbp-spmenu-push charging")
            
               ofertaServi.guardarEmpleoMensual($scope.empleo).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                          window.location.href = data.ruta;
                    }, 1000);
    
    
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
            
            
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }
    }

}])

/*.controller('numeroEmpleados',  ['$scope', 'ofertaServi',function ($scope, ofertaServi){
    $scope.empleo = {};


$scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
         ofertaServi.cargarDatosNumEmp($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.empleo = data.empleo;
    
        }).catch(function () {
              $("body").attr("class", "cbp-spmenu-push")
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
       
        
    });


    $scope.guardar = function () {
        $scope.empleo.Encuesta = $scope.id;

        if ($scope.empleoForm.$valid) {
            $("body").attr("class", "cbp-spmenu-push charging")
            
            
            ofertaServi.guardarNumeroEmp($scope.empleo).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                          window.location.href = "/ofertaempleo/empleadoscaracterizacion/" + $scope.id;
                    }, 1000);
    
    
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
            
  
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }
    }
}])
*/

.controller('empleoCaracterizacion',  ['$scope', 'ofertaServi',function ($scope, ofertaServi) {
    $scope.empleo = {};
    
   $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
         ofertaServi.cargarDatosEmplCaract($scope.id).then(function (data) {
                 $("body").attr("class", "cbp-spmenu-push")

              
                $scope.empleo = data.empleo;
                $scope.data = data.data;
                $scope.proveedor =data.proveedor;
                
        }).catch(function () {
              $("body").attr("class", "cbp-spmenu-push")
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
       
        
    });

    $scope.agregar = function(){
        
        obj = {};
        obj.realizada_empresa = 0;
        $scope.empleo.tematicas.push(obj);
    }
    
    $scope.quitar = function(obj){
        $scope.empleo.tematicas.splice($scope.empleo.tematicas.indexOf(obj),1);
    }
    
        
   $scope.existeOpcion = function(obj){
        
       for (var i = 0; i < $scope.empleo.medios.length; i++) {
            if($scope.empleo.medios[i] == obj){
                return true;
            }
        }
        return false;
    }
    
 
    
   $scope.existeTipo = function(obj){
        
       for (var i = 0; i < $scope.empleo.tipos.length; i++) {
            if($scope.empleo.tipos[i] == obj){
                return true;
            }
        }
        return false;
    }
    
    
    $scope.nivel1 = function(obj){
       if($scope.empleo.lineasadmin.indexOf(obj) >= 0){
           return false;
       }else{
           
           if( $scope.empleo.lineasadmin.length ==3){
               return true;
           }else{
               return false;
           }
       }
        
    }
    
    
   $scope.nivel2 = function(obj){
       if($scope.empleo.lineasopvt.indexOf(obj) >= 0){
           return false;
       }else{
           
           if( $scope.empleo.lineasopvt.length ==3){
               return true;
           }else{
               return false;
           }
       }
        
    }
    
    
       $scope.nivel2 = function(obj){
       if($scope.empleo.lineasopvt.indexOf(obj) >= 0){
           return false;
       }else{
           
           if( $scope.empleo.lineasopvt.length ==3){
               return true;
           }else{
               return false;
           }
       }
        
    }
    
    
   $scope.mediovalue = function(obj){
       if($scope.empleo.medios.indexOf(obj) >= 0){
           return false;
       }else{
           
           if( $scope.empleo.medios.length ==3){
               return true;
           }else{
               return false;
           }
       }
        
    }
    
   $scope.tipovalue = function(obj){
       if($scope.empleo.tipos.indexOf(obj) >= 0){
           return false;
       }else{
           
           if( $scope.empleo.tipos.length ==3){
               return true;
           }else{
               return false;
           }
       }
        
    }
    
    
    
    
   $scope.validar = function(){
        
        
        if($scope.empleo.capacitacion == 1 && $scope.empleo.tematicas.length == 0){
            
            return true;
        }
        
        if($scope.empleo.medios.length < 1 || $scope.empleo.medios.length >3 ){
            
            return true;
        }
       
       if($scope.empleo.tipos.length < 1 || $scope.empleo.tipos.length >3 ){
            
            return true;
        }
        
        if($scope.empleo.lineasadmin.length < 1 || $scope.empleo.lineasadmin.length >3 ){
            
            return true;
        }
        
        if($scope.empleo.lineasopvt.length < 1 || $scope.empleo.lineasopvt.length >3 ){
            
            return true;
        }
        return false;
    }
    
    
    $scope.guardar = function () {
        $scope.empleo.Encuesta = $scope.id;


        if ($scope.empleoForm.$valid && !$scope.validar()) {
            $("body").attr("class", "cbp-spmenu-push charging")
                ofertaServi.guardarEmpCaracterizacion($scope.empleo).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                           window.location.href = data.ruta;
                    }, 1000);
    
    
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }
    }
}])

.controller('empleo', ['$scope', 'ofertaServi',function ($scope, ofertaServi){
    $scope.empleo = {};
    $scope.url = "";
    $scope.dataTable = "<th>M</th> <th>F</th>"; 

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
         ofertaServi.cargarDatosEmplomensual($scope.id).then(function (data) {
                 $("body").attr("class", "cbp-spmenu-push")
                $scope.empleo = data.empleo;
                $scope.proveedor =data.proveedor;
                if($scope.empleo.VacanteOperativo == null){
                    $scope.empleo.VacanteGerencial = 0;
                    $scope.empleo.VacanteAdministrativo = 0;
                    $scope.empleo.VacanteOperativo = 0;
                    
                }
                $scope.url = data.url;
                  
        }).catch(function () {
              $("body").attr("class", "cbp-spmenu-push")
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
       
        
    });

   $scope.tiempoempleado = function(tipo,sexo){
        if($scope.empleo.Empleo){
        for(i = 0; i < $scope.empleo.Empleo.length ; i ++){
            
            if($scope.empleo.Empleo[i].tipo_cargo_id == tipo && $scope.empleo.Empleo[i].sexo == sexo ){
                
                return $scope.empleo.Empleo[i];
            }
            
        }
        
        obj = {};
        obj.tipo_cargo_id = tipo;
        obj.sexo = sexo == 1 ? true : false ;
		obj.tiempo_completo = 0;
		obj.medio_tiempo = 0;
        $scope.empleo.Empleo.push(obj);
        
        return obj;

        }        
    }

   $scope.Total = function(item,item2){
        if($scope.empleo[item]){
            
            var    total = 0;
            for(i = 0; i < $scope.empleo[item].length ; i ++){
                total =  total + ($scope.empleo[item][i][item2] == null ? 0 : ($scope.empleo[item][i][item2] == undefined ? 0 : $scope.empleo[item][i][item2]));
                
                }
                
            }else{
                
                return 0;
            }
        
            return total;    
     

        }  

   $scope.vacantesSi = function(){
        var vacante  = ( $scope.empleo.VacanteOperativo == null ? 0 : ($scope.empleo.VacanteOperativo  == undefined ? 0 :$scope.empleo.VacanteOperativo ));
         var vacante2  = ( $scope.empleo.VacanteAdministrativo == null ? 0 : ($scope.empleo.VacanteAdministrativo  == undefined ? 0 :$scope.empleo.VacanteAdministrativo ));
        var vacante3  = ( $scope.empleo.VacanteGerencial == null ? 0 : ($scope.empleo.VacanteGerencial  == undefined ? 0 :$scope.empleo.VacanteGerencial ));
       
        
        if((  vacante +  vacante2  + vacante3   ) > 0){
        return true;
        }else{
            if($scope.empleo != null){
                $scope.empleo.Razon = {};
                $scope.empleo.Razon.apertura = 0;
                $scope.empleo.Razon.crecimiento = 0;
                $scope.empleo.Razon.remplazo = 0;
            }
            return false;
        }
    }

   $scope.validacion = function(){
        
        
        return true;
    }
    
        
    $scope.guardar = function () {
        $scope.empleo.Encuesta = $scope.id;
        if ($scope.empleoForm.$valid && $scope.validacion()) {
            
            $("body").attr("class", "cbp-spmenu-push charging")
            
               ofertaServi.guardarEmpleo($scope.empleo).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                          window.location.href = data.ruta;
                    }, 1000);
    
    
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
            
            
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }
    }

}])
