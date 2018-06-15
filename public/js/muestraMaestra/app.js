(function(){

    angular.module("appMuestraMaestra", [ 'ngSanitize', 'ui.select', 'checklist-model', "ADM-dateTimePicker",  "serviciosMuestraMaestra", "ngMap" ] )
    
    .config(["ADMdtpProvider", function(ADMdtpProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" });
    }])
    
    .controller("MuestraMaestraCtrl", ["$scope","ServiMuestra", "NgMap", function($scope,ServiMuestra,NgMap){
        
        $scope.dataPerido = {};
       
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                $scope.dataPerido = data.periodo; 
                $scope.digitadores = data.digitadores; 
                for(var i=0; i< data.proveedores.length; i++){
                    
                    switch ( data.proveedores[i].estados_proveedor_id ) {
                        case 1: data.proveedores[i].icono = "/Content/IconsMap/green.png";  break;
                        case 2: data.proveedores[i].icono = "/Content/IconsMap/yellow.png"; break;
                        case 3: data.proveedores[i].icono = "/Content/IconsMap/red.png";    break;
                        default: break;
                    }
                    
                }
                $scope.proveedores = data.proveedores; 
            });
        
        $scope.openModalZona = function (zona) {
            $scope.zona = zona ? angular.copy(zona) : { encargados:[] };
            $scope.esCrearZona = zona ? false : true;
            
            if(zona){
                var ids = [];
                for(var i=0; i<zona.encargados.length; i++){
                    ids.push(zona.encargados[i].pivot.digitador_id);
                }
                $scope.zona.encargados = ids;
            }
            else{
               
                var sw = false;
                for(var i=0; i<$scope.dataPerido.zonas.length; i++){
                   if($scope.dataPerido.zonas[i].isEditar){ sw=1; break;}
                }
               
                if(sw){ swal("No se puede agregar una zona", "No se puede agregar una zona, ya que existe una zona en edición de posición, guardela y vuelva a intentarlo", "info"); return; }
                
            }
            
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalAddZona").modal("show");
        }
        
        $scope.agregarZona = function(){
            
            if($scope.esCrearZona){
                $scope.dataPerido.zonas.push({
                                nombre: $scope.zona.nombre,
                                encargados: $scope.zona.encargados,
                                posicion_1: $scope.map.getCenter().lat() + ( $scope.map.getZoom() > 10 ? 0.01 : 0.5 ), 
                                posicion_2: $scope.map.getCenter().lng() + ( $scope.map.getZoom() > 10 ? 0.01 : 0.5 ),
                                posicion_3: $scope.map.getCenter().lat(),
                                posicion_4: $scope.map.getCenter().lng() ,
                                isNuevo: true,
                              });
               $("#modalAddZona").modal("hide");
            }
            else{
                $scope.guardarZona($scope.zona);
            }
        }
      
        $scope.guardarZona = function (item) {

          
            var data = angular.copy(item);
            data.periodo =    $("#periodo").val();
            if( ($scope.esCrearZona || data.isEditar) && $scope.ne && $scope.sw ){
                data.posicion_1 = $scope.ne.lat(); 
                data.posicion_2 = $scope.ne.lng();
                data.posicion_3 = $scope.sw.lat();
                data.posicion_4 = $scope.sw.lng();
            }
            
            /* VALIDAR ZONAS */
            for(var i=0; i<$scope.dataPerido.zonas.length; i++){
                var zona = $scope.dataPerido.zonas[i];
                
                if(  data.id != zona.id  ){
                    if( (parseFloat(zona.posicion_1)>=data.posicion_1 && parseFloat(zona.posicion_3)<=data.posicion_1) || 
                        (parseFloat(zona.posicion_1)>=data.posicion_3 && parseFloat(zona.posicion_3)<=data.posicion_3) ||
                        (data.posicion_1>=parseFloat(zona.posicion_1) && data.posicion_3<=parseFloat(zona.posicion_3)) ){
                         
                            if( (parseFloat(zona.posicion_2)>=data.posicion_2 && parseFloat(zona.posicion_4)<=data.posicion_2) || 
                                (parseFloat(zona.posicion_2)>=data.posicion_4 && parseFloat(zona.posicion_4)<=data.posicion_4) ||
                                (data.posicion_2>=parseFloat(zona.posicion_2) && data.posicion_4<=parseFloat(zona.posicion_4)) ){
                                swal("Error", "La zona que intestas guardar, no debe colisionar con otra zona.", "error"); return;
                            }   
                            
                    }
                }
                
            }
            /*______FIN VALIDACIONES ZONAS_____*/
            
            if(data.isEditar){
                var ids = [];
                for(var i=0; i<data.encargados.length; i++){
                    ids.push(data.encargados[i].pivot.digitador_id);
                }
                data.encargados = ids;
            }
            
            ServiMuestra.guardarZona(data).then(function (data) {
                       
                        if (data.success) {
                            $scope.dataPerido = data.data;
                            swal("¡Zona guardada!", "La zona se ha guardado exitosamnete", "success");
                            $("#modalAddZona").modal("hide");
                        }
                        else {
                            if(data.Error){
                                swal("Error", data.Error, "error"); 
                            }
                            else{
                                $scope.errores = data.errores;
                                sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                            }
                        }
                        $("body").attr("class", "cbp-spmenu-push");
                        
                    }).catch(function () {
                        $("#modalAddZona").modal("hide");
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
      
        $scope.verDetalleZona = function(zona){
          alert("ok");  
        }
        
        $scope.boundsChanged = function() {
            
            $scope.ne = this.getBounds().getNorthEast();
            $scope.sw = this.getBounds().getSouthWest();
            
            $scope.coordenadas = this;
            
            if(this.getBounds()){
                $scope.dataPerido.zonas[this.index].tex1 = this.getBounds().getNorthEast().lat();
                $scope.dataPerido.zonas[this.index].tex2 = this.getBounds().getSouthWest().lng();
            }
        };
        
        $scope.coordenadasRectangulo = function(zona){
            if(zona){
                return [ [ parseFloat(zona.posicion_3) , parseFloat(zona.posicion_4) ], [ parseFloat(zona.posicion_1) , parseFloat(zona.posicion_2) ] ];
            }
            return [];
        }
        
        $scope.editarPosicionZona = function(zona){
           var sw = false;
           for(var i=0; i<$scope.dataPerido.zonas.length; i++){
               if($scope.dataPerido.zonas[i].isEditar){ sw=1; break;}
           }
           
           if(sw){ swal("No se puede editar la zona", "No se puede editar la zona, ya que existe una zona en edición de posición, guardela y vuelva a intentarlo", "info"); return; }
            
            zona.isEditar=true;
            $scope.ne = null;
            $scope.sw = null;
        }
        
        NgMap.getMap().then(function(map) { $scope.map = map;  });

    }])
     
    .controller("ListarPeriodosCtrl", ["$scope","ServiMuestra", "NgMap", function($scope,ServiMuestra,NgMap){
        
        $scope.periodo = {};
        
        ServiMuestra.getListadoPeridos()
        .then(function(data){ $scope.periodos = data; });
        
        
        $scope.openModalAddPeriodo = function () {
            $scope.periodo = {};
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $scope.IndexEditar = null;
            $("#modalAgregarPerido").modal("show");
        }
        
        $scope.openModalEditPeriodo = function (item, index) {
            $scope.periodo = angular.copy(item);;
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $scope.IndexEditar = index;
            $("#modalAgregarPerido").modal("show");
        }
        
        
        $scope.guardarPeriodo = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiMuestra.guardarPeriodo($scope.periodo).then(function (data) {
                       
                        if (data.success) {
                            if($scope.esCrear){
                               $scope.peridos.push(data.periodo);
                            }
                            else{ $scope.periodos[$scope.IndexEditar] = data.periodo; }
                            swal("¡Periodo guardado!", "El perido se ha guardado exitosamnete", "success");
                            $("#modalAgregarPerido").modal("hide");
                        }
                        else {
                            if(data.Error){
                                swal("Error", data.Error, "error");
                            }
                            else{
                                $scope.errores = data.errores;
                                sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                            }
                        }
                       
                        $("body").attr("class", "cbp-spmenu-push");
                       
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }

    }]) 
     
}());