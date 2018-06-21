
(function(){

    angular.module("appMuestraMaestra", [ 'ngSanitize', 'ui.select', 'checklist-model', "ADM-dateTimePicker",  "serviciosMuestraMaestra", "ngMap" ] )
    
    .config(["ADMdtpProvider", function(ADMdtpProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" });
    }])
    
    .controller("CrearPeriodoCtrl", ["$scope","ServiMuestra", "NgMap", function($scope,ServiMuestra,NgMap){
        
        $scope.dataPerido = { zonas:[] };
        $scope.zona = {};
        $scope.styloMapa = [{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ];
        var PrestadoresInfowindow = new google.maps.InfoWindow();
        
        ServiMuestra.getData($("#periodo").val())
           .then(function(data){ 
                
                if(data.periodo){
                
                    for(var i=0; i< data.periodo.zonas.length; i++){
                        data.periodo.zonas[i].coordenadas = $scope.getCoordenadas(data.periodo.zonas[i].coordenadas);
                        
                        var ids = [];
                        for(var j=0; j<data.periodo.zonas[i].encargados.length; j++){
                            ids.push( data.periodo.zonas[i].encargados[j].id );
                        }
                        data.periodo.zonas[i].encargados = ids;
                    }
                    
                    $scope.dataPerido = data.periodo;
                    $scope.dataPerido.nombre = null;
                    $scope.dataPerido.fecha_inicio = null;
                    $scope.dataPerido.fecha_fin = null;
                }
                
                $scope.digitadores = data.digitadores; 
                $scope.proveedores = data.proveedores;
                
            });
        
        
        $scope.guardar = function(){
            
            if (!$scope.formCrear.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
            
            swal({
                title: "Guardar",
                text: "Recuerde que las zonas que se encuentran en el mapa, seran registradas con el nuevo periodo.",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    
                    ServiMuestra.crearPeriodo($scope.dataPerido)
                    .then(function (data) {
                       
                        if (data.success) {
                            
                            swal({
                                title: "¡Periodo guardado!",
                                text: "El perido se ha guardado exitosamnete",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                            }, function () {
                                setTimeout(function () {
                                    window.location.href = "/MuestraMaestra/periodo/"+data.id;
                                }, 500);
                            });
                            
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
                    
                    
                }, 500);
            });
            
        }
        
        $scope.eliminarZona = function (zona,index) {
            swal({
                title: "Eliminar zona",
                text: "¿Esta seguro de eliminar la zona : "+ zona +" ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    swal("¡Zona eliminada!", "La zona se ha eliminado exitosamnete", "success");
                    $scope.dataPerido.zonas.splice(index,1);
                }, 500);
            });
        }
            
        
        $scope.openModalZona = function (zona) {
            $scope.zona = angular.copy(zona);
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalAddZona").modal("show");
        }
        
        
        $scope.guardarzona = function(){
            
            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
            for(var i=0; i< $scope.dataPerido.zonas.length; i++){
                if($scope.dataPerido.zonas[i].id==$scope.zona.id){
                    $scope.dataPerido.zonas[i].nombre=$scope.zona.nombre;
                    $scope.dataPerido.zonas[i].encargados=$scope.zona.encargados;
                    $scope.dataPerido.zonas[i].color=$scope.zona.color;
                    $scope.map.shapes[i].set('fillColor',$scope.zona.color);
                    break;
                }
            }
            $("#modalAddZona").modal("hide");
        }
    
        $scope.getIcono = function( estado ){
            var icono = null;
            switch ( estado ) {
                case 1: icono = "/Content/IconsMap/green.png";  break;
                case 2: icono = "/Content/IconsMap/yellow.png"; break;
                case 3: icono = "/Content/IconsMap/red.png";    break;
                default: break;
            }
            return  icono ? { url: "\""+icono+"\"" } : null;
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        
        $scope.showInfoMapa = function(event, proveedor){
            $scope.proveedor = proveedor;
            $scope.map.showInfoWindow('infoProveedor', this );
            
        }  
        
        $scope.showInfoNumeroPS = function(event, zona, proveedores){
            
            var numeroPrestadores = 0 ;
            for(var i=0; i<proveedores.length; i++){
                
                var point = new google.maps.LatLng( proveedores[i].latitud , proveedores[i].longitud );
                if( google.maps.geometry.poly.containsLocation( point , this) ){
                      numeroPrestadores++;
                }
            }
            
            
            PrestadoresInfowindow.setContent( "Numero de prestadores: "+numeroPrestadores );
            PrestadoresInfowindow.setPosition(event.latLng);
            PrestadoresInfowindow.open($scope.map);
        }  
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({
              strokeColor: 'red',
              strokeWeight: 1,
              fillOpacity:0
            });
        });
        
    }])
    
    .controller("MuestraMaestraCtrl", ["$scope","ServiMuestra", "NgMap", function($scope,ServiMuestra,NgMap){
        
        $scope.filtro = { categorias:[] };
        $scope.dataPerido = { zonas:[] };
        $scope.zona = {};
        var PrestadoresInfowindow = new google.maps.InfoWindow();
        var drawingManager = null;
        $scope.styloMapa = [{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ];
         
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                for(var i=0; i< data.periodo.zonas.length; i++){
                    data.periodo.zonas[i].coordenadas = $scope.getCoordenadas(data.periodo.zonas[i].coordenadas);
                }
                
                $scope.dataPerido = data.periodo;
                $scope.digitadores = data.digitadores; 
                $scope.proveedores = data.proveedores;
                $scope.tiposProveedores = data.tiposProveedores;
            });
        
        
        $scope.exportarFileKML = function(){
            
            $scope.filtro.periodo = $("#periodo").val();
            $scope.filtro.tipoProveedor = $scope.tipoPro ? $scope.tipoPro.id : null;
            
            ServiMuestra.getGeoJson( $scope.filtro )
                .then(function(geojson){ 
                    var kmlDocumentName = tokml(geojson, {
                                                documentName: geojson.name,
                                                documentDescription: geojson.description
                                            });
                    var link = document.createElement("a");
                    link.download = "mapa.kml";
                    link.href = 'data:application/xml;charset=utf-8,' + encodeURIComponent(kmlDocumentName);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                });
        }
        
        $scope.openMensajeAddZona = function(){
            
            swal({ 
                    title: "Agregar zona", 
                    text: "Por favor primero seleccione la zona  en el mapa.", 
                    type: "info", 
                    showCancelButton: true,
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true,
                    closeOnCancel: true
            },

              function (isConfirm) {
                  if (isConfirm) {
                     $scope.functionAgregarZonaMap();
                  }
              });
            
        }
        
        $scope.functionAgregarZonaMap = function(){
             drawingManager = new google.maps.drawing.DrawingManager({
                            drawingControl: true,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [ google.maps.drawing.OverlayType.POLYGON ]
                            }
                        });
                        
            google.maps.event.addListener(drawingManager, 
                                          'overlaycomplete', 
                                            function(e){
                                                $scope.dataPerido.coordenadas = [];
                                                
                                                $scope.figura = e.overlay;
                                                
                                                $scope.$apply(function () {
                                                    $scope.openModalZona();
                                                });
                                                
                                                $scope.figura.getPath().getArray().forEach(function (position) {
                                                    $scope.zona.coordenadas.push( { x: position.lat(), y: position.lng() } );
                                                });
                                            }
            );
            
            drawingManager.setMap($scope.map);
        }
        
     
        
        $scope.cancelarAgregarZona = function(){
            if(drawingManager){
                drawingManager.setMap(null);
                $scope.figura.setMap(null);
            }
            $("#modalAddZona").modal("hide");
        }
        
        $scope.guardarZona = function (item) {
            
            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
            if($scope.esCrearZona){
                $scope.crearZona();
            }
            else{
                $scope.editarZona();
            }
            
        }
        
        $scope.crearZona = function(){
            
            ServiMuestra.agregarZona($scope.zona)
                    .then(function (data) {
                       
                        if (data.success) {
                            data.zona.coordenadas = $scope.getCoordenadas(data.zona.coordenadas);
                            $scope.dataPerido.zonas.push(data.zona);
                            swal("¡Zona guardada!", "La zona se ha guardado exitosamnete", "success");
                            $scope.cancelarAgregarZona();
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
        
        $scope.editarZona = function(){
            
            ServiMuestra.editarZona($scope.zona)
                    .then(function (data) {
                       
                        if (data.success) {
                            for(var i=0; i<$scope.dataPerido.zonas.length;i++){
                                if($scope.dataPerido.zonas[i].id==data.zona.id){
                                    $scope.dataPerido.zonas[i].nombre = data.zona.nombre;
                                    $scope.dataPerido.zonas[i].encargados = data.zona.encargados;
                                    $scope.dataPerido.zonas[i].color = data.zona.color;
                                    $scope.map.shapes[i].set('fillColor',data.zona.color);
                                    break;
                                }
                            }
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
        
        
        $scope.eliminarZona = function (zona, index) {
            swal({
                title: "Eliminar zona",
                text: "¿Esta seguro de eliminar la zona : "+ zona.nombre +" ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    
                    ServiMuestra.eliminarZona( { zona:zona.id , periodo:$("#periodo").val()}  )
                    .then(function (data) {
                        if (data.success) {
                            $scope.dataPerido.zonas.splice(index,1);
                            swal("¡Zona eliminada!", "La zona se ha eliminado exitosamnete", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error al elimar la zona.", "error");
                        }
                        $('#processing').removeClass('process-in');
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $('#processing').removeClass('process-in');
                    });
    
                }, 500);
            });
        }
            
        
        $scope.openModalZona = function (zona) {
            $scope.zona = zona ? angular.copy(zona) : { periodo: $("#periodo").val(), encargados:[], coordenadas:[] };
            $scope.esCrearZona = zona ? false : true;
            
            if(zona){
                var ids = [];
                for(var i=0; i<zona.encargados.length; i++){
                    ids.push(zona.encargados[i].pivot.digitador_id);
                }
                $scope.zona.encargados = ids;
            }
            
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalAddZona").modal("show");
        }
        
        
        $scope.filterProveedores = function(pro){
            
            if($scope.filtro.categorias.length>0){
                return $scope.filtro.categorias.indexOf(pro.categoria_proveedores_id)!=-1 
            }
            
            if($scope.tipoPro){
                return $scope.tipoPro.id == pro.categoria.tipo_proveedores_id;
            }
            
            return true;
        }
        
        $scope.getIcono = function( estado ){
            var icono = null;
            switch ( estado ) {
                case 1: icono = "/Content/IconsMap/green.png";  break;
                case 2: icono = "/Content/IconsMap/yellow.png"; break;
                case 3: icono = "/Content/IconsMap/red.png";    break;
                default: break;
            }
            return  icono ? { url: "\""+icono+"\"" } : null;
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({
              strokeColor: 'red',
              strokeWeight: 1,
              fillOpacity:0
            });
        });
        
        $scope.showInfoMapa = function(event, proveedor){
            $scope.proveedor = proveedor;
            $scope.map.showInfoWindow('infoProveedor', this );
            
        }  
        
        $scope.showInfoNumeroPS = function(event, zona, proveedores){
            
            var numeroPrestadores = 0 ;
            for(var i=0; i<proveedores.length; i++){
                
                var point = new google.maps.LatLng( proveedores[i].latitud , proveedores[i].longitud );
                if( google.maps.geometry.poly.containsLocation( point , this) ){
                      numeroPrestadores++;
                }
            }
            
            
            PrestadoresInfowindow.setContent( "Numero de prestadores: "+numeroPrestadores );
            PrestadoresInfowindow.setPosition(event.latLng);
            PrestadoresInfowindow.open($scope.map);
        }  

    }])
     
    .controller("ListarPeriodosCtrl", ["$scope","ServiMuestra", "NgMap", function($scope,ServiMuestra,NgMap){
        
        $scope.periodo = {};
        
        ServiMuestra.getListadoPeridos()
        .then(function(data){ $scope.periodos = data; });
        
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
            
            ServiMuestra.editarPeriodo($scope.periodo).then(function (data) {
                       
                        if (data.success) {
                            $scope.periodos[$scope.IndexEditar] = data.periodo;
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