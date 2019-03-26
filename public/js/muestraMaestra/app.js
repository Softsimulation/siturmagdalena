
(function(){

    angular.module("appMuestraMaestra", [ 'ngSanitize', 'angularUtils.directives.dirPagination', 'ui.select', 'checklist-model', "ADM-dateTimePicker",  "serviciosMuestraMaestra", "ngMap" ] )
    
    .config(["ADMdtpProvider", function(ADMdtpProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" });
    }])
    
    .controller("CrearPeriodoCtrl", ["$scope","ServiMuestra", "NgMap", "$interval", function($scope,ServiMuestra,NgMap, $interval){
        
        
        $("body").attr("class", "cbp-spmenu-push charging");
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
                $scope.sectores = data.sectores;
                $scope.proveedores = data.proveedores.concat(data.proveedoresInformales);
                
                $("body").attr("class", "cbp-spmenu-push");
                
            });
        
        $scope.guardar = function(){
            
            if (!$scope.formCrear.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
            
            swal({
                title: "Guardar",
                text: "Recuerde que los bloques que se encuentran en el mapa, seran registradas con el nuevo periodo.",
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
                title: "Eliminar bloque",
                text: "¿Esta seguro de eliminar el bloque : "+ zona +" ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    swal("¡Zona eliminada!", "El bloque se ha eliminado exitosamnete", "success");
                    $scope.$apply(function () { $scope.dataPerido.zonas.splice(index,1); });
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
                    $scope.dataPerido.zonas[i].sector_id=$scope.zona.sector_id;
                    $scope.map.shapes[i].set('fillColor',$scope.zona.color);
                    break;
                }
            }
            $("#modalAddZona").modal("hide");
        }
    
        $scope.getIcono = function( p ){
            if(p){
                var ruta = "/Content/IconsMap/";
                
                switch ( p.categoria_rnt_id ) {
                    case 1: ruta  += "alojamientos/"; break;
                    case 2: ruta  += "establecimiento_gastronomia/"; break;
                    case 3: ruta  += "agencias_viajes/"; break;
                    //case 4: ruta  += "esparcimiento/"; break;
                    case 5: ruta  += "empresa_transporte/"; break;
                    case 6: ruta  += "arrendadores_vehiculos/"; break;
                    case 7: ruta  += "concesionarios_servicios/"; break;
                    case 8: ruta  += "empresa_tiempo/"; break;
                    case 9: ruta  += "empresas_captadoras/"; break;
                    case 10: ruta += "guia_turismo/"; break;
                    case 11: ruta += "oficina_turistica/"; break;
                    case 12: ruta += "operadores_profesionales/"; break;
                    case 13: ruta += "parques_tematicos/"; break;
                    case 14: ruta += "usuarios_operadores/"; break;
                    default: return null;
                }
                
                if(p.rnt){
                    switch ( p.estado_rnt_id ) {
                        case 1: ruta += "activo.png";     break;  // Activo
                        case 2: ruta += "cancelado.png";  break;  // Nnulado
                        case 3: ruta += "cancelado.png";  break;  // Cancelado
                        case 4: ruta += "cancelado.png";  break;  // Cancelado por traslado
                        case 5: ruta += "pendiente.png";  break;  // Pendiente actualización
                        case 6: ruta += "cancelado.png";  break;  // Suspendido
                        default: return null;
                    }
                }
                else{ ruta += "informal.png";  }
                
                return  ruta;
            }
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
        
    }])
    
    .controller("MuestraMaestraCtrl", ["$scope","ServiMuestra", "NgMap", "$timeout", "$interval", function($scope,ServiMuestra,NgMap,$timeout,$interval){
        
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.pantallaCompleta = false;
        $scope.TipoProveedorInformal = {};
        $scope.selectTipoProveedores = { select:[] };
        $scope.filtro = { tipo:[], categorias:[], estados:[], sectoresProv:[], municipios:[], verZonas:true, sectores:[], encargados:[], tipoProveedores:1 };
        $scope.dataPerido = { zonas:[] };
        $scope.zona = {};
        $scope.styloMapa = [{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ];
        $scope.centro = [10.4113014,-74.4056612];
        $scope.filterTabla = {};
        $scope.clusterProveedores = null;
        $scope.markersProveedores = [];
        $scope.sharpesAndPopus = [];
        definePopupClass();
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                $scope.sectoresZonasIDS = [];
                $scope.sectoresZonas = [];
                
                for(var i=0; i< data.periodo.zonas.length; i++){
                    
                    if( $scope.sectoresZonasIDS.indexOf( data.periodo.zonas[i].sector_id )==-1 && data.periodo.zonas[i].sector_id ){
                        $scope.sectoresZonasIDS.push( data.periodo.zonas[i].sector_id );
                        $scope.sectoresZonas.push( $scope.buscarAbjetoInArray(data.sectores,data.periodo.zonas[i].sector_id) );
                    }
                    
                    $scope.crearPolygono( data.periodo.zonas[i] );
                    
                }
                
                $scope.dataPerido = data.periodo;
                $scope.digitadores = data.digitadores; 
                $scope.digitadores2 = data.digitadores; 
                $scope.proveedores = data.proveedores;
                
                $scope.tiposProveedoresInfo = [];
                
                for(var i=0; i<data.tiposProveedores.length; i++){
                    $scope.tiposProveedoresInfo.push( { id:data.tiposProveedores[i].id , nombre:data.tiposProveedores[i].tipo_proveedores_con_idiomas[0].nombre, cantidad:[0,0] } );
                    
                    data.tiposProveedores[i].cantidad = $scope.getCantidadProveedores( data.tiposProveedores[i].id, "categoria_rnt_id" );
                    
                    for(var j=0; j<data.tiposProveedores[i].categoria_proveedores.length; j++){
                        data.tiposProveedores[i].categoria_proveedores[j].cantidad = $scope.getCantidadProveedores( data.tiposProveedores[i].categoria_proveedores[j].id, "subcategoria_rnt_id" );
                    }
                    
                }
                
                for(var i=0; i<data.estados.length; i++){
                    data.estados[i].cantidad = $scope.getCantidadPorEstado(data.estados[i].id);
                }
                
                for(var i=0; i<data.municipios.length; i++){
                    data.municipios[i].cantidad = $scope.getCantidadProveedores(data.municipios[i].id, "municipio_rnt_id");
                }
                
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.sectores = data.sectores;
                $scope.estados = data.estados;
                $scope.municipios = data.municipios;
                
                $scope.TotalFormales = 0;
                $scope.TotalInformales = 0;
                $scope.dynMarkers = [];
                
                for (var i=0; i<$scope.proveedores.length; i++) {  
                    var marker = $scope.crearMarker($scope.proveedores[i]);
                    $scope.markersProveedores.push( marker );
                    $scope.dynMarkers.push( marker );
                    
                    if($scope.proveedores[i].rnt){ $scope.TotalFormales +=1; }
                    else{ $scope.TotalInformales +=1; }
                    
                };
              
                $scope.clusterProveedores = new MarkerClusterer($scope.map, $scope.dynMarkers, {});
                $scope.clusterProveedores.setMaxZoom(14);
                
                for(var i=0; i<$scope.sectoresZonas.length; i++){
                    $scope.sectoresZonas[i].cantidad = $scope.getCantidadPorSector($scope.sectoresZonas[i].id);
                }
                
                $("body").attr("class", "cbp-spmenu-push");
                
                $scope.validarProveedoresFueraZona();
                $interval( function(){ $scope.validarProveedoresFueraZona(); } , 20000);
                
            });
        
        $scope.crearMarker = function(pro){
            
            var marker = new google.maps.Marker(
                            {
                                position: new google.maps.LatLng(pro.latitud, pro.longitud),
                                dataProveedor: pro,
                                icon: { url: $scope.getIcono(pro), scaledSize: new google.maps.Size(20, 20), labelOrigin: new google.maps.Point(12, -10) }
                            });
            
            marker.addListener('click',  $scope.showInfoMapa );
            
            return marker;
        }
        
        $scope.crearPolygono = function(zona){
            
            var Polygon = new google.maps.Polygon({ map: $scope.map, paths: $scope.getCoordenadasZona( zona.coordenadas ), fillColor: zona.color, fillOpacity: 0.35, dataZona : zona });
            
            Polygon.addListener('click',  $scope.showInfoNumeroPS );
            Polygon.addListener('dragend',  $scope.ChangedPositions );
            
            Polygon.getPaths().forEach(function(path, index){

                  google.maps.event.addListener(path, 'insert_at', function(){
                     $scope.popupEditarPos.position = Polygon.getPath().getArray()[0];
                  });
                
                  google.maps.event.addListener(path, 'remove_at', function(){
                    $scope.popupEditarPos.position = Polygon.getPath().getArray()[0];
                  });
                
                  google.maps.event.addListener(path, 'set_at', function(){
                    $scope.popupEditarPos.position = Polygon.getPath().getArray()[0];
                  });
                
            });
            
            var div = document.createElement('div');
            div.innerHTML = zona.nombre;
            
            var popup = new Popup( new google.maps.LatLng(zona.coordenadas[0].x, zona.coordenadas[0].y), div );
            popup.setMap($scope.map);
            
            $scope.sharpesAndPopus.push( { sharpe: Polygon, popup: popup } );
            
            return Polygon;
        }
        
        $scope.getCoordenadasZona = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push({ lat: coordenadas[j].x, lng: coordenadas[j].y });
            }
            return array;
        }
        
        $scope.validarProveedoresFueraZona =  function(){
            ServiMuestra.validarProveedoresFueraZona($scope.markersProveedores,$scope.sharpesAndPopus) .then(function(data){  $scope.proveedoresFuera = data; });
        }
        
        
        $scope.exportarFileKML = function(){
            
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiMuestra.getGeoJson( $("#periodo").val() )
                .then(function(geojson){ 
                    var a = document.createElement("a");
                    var file = new Blob([geojson], {type: "text/plain"});
                    a.href = URL.createObjectURL(file);
                    a.download = "mapa.kml"; 
                    a.click();
                    $("body").attr("class", "cbp-spmenu-push");
                });
            
        }
        
        $scope.exportarFileExcelZona = function(zona){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiMuestra.getExcel( zona.id )
                .then(function(response){ 
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(response);
                    link.download = zona.nombre;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $("body").attr("class", "cbp-spmenu-push");
                    zona.es_generada = true;
                });
            
        }
        
        $scope.exportarFileExcelGeneral = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiMuestra.getExcelGeneral( $("#periodo").val() )
                .then(function(response){ 
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(response);
                    link.download = $scope.dataPerido.nombre;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $("body").attr("class", "cbp-spmenu-push");
                });
            
        }
        
        
        $scope.openMensajeAddZona = function(){
            
            swal({ 
                    title: "Agregar bloque", 
                    text: "Por favor primero seleccione la zona en el mapa.", 
                    type: "info", 
                    showCancelButton: true,
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true,
                    closeOnCancel: true
            },

              function (isConfirm) {
                  if (isConfirm) {
                        $scope.$apply(function(){ 
                            $scope.es_crear_zona = true;
                            $scope.figuraCrear = "polygon";
                        });
                  }
              });
            
        }
        
        
        $scope.openMensajeAddProveedorInformal = function(){
            
            swal({ 
                    title: "Agregar proveedor informal", 
                    text: "Por favor primero seleccione la ubicación en el mapa.", 
                    type: "info", 
                    showCancelButton: true,
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true,
                    closeOnCancel: true
            },

              function (isConfirm) {
                  if (isConfirm) {
                        $scope.$apply(function(){ 
                            $scope.es_crear_proveedor = true;
                            $scope.figuraCrear = "marker";
                        });
                  }
              });
            
        }
        
        
        $scope.cancelarAgregarZonaPRoveedor = function(){
            if($scope.figura){
                $scope.figura.setMap(null);
            }
            $("#modalAddZona").modal("hide");
            $("#modalAddProveedor").modal("hide");
            $scope.es_crear_zona = false;
            $scope.es_crear_proveedor = false;
        }

        $scope.onMapOverlayCompleted = function(e){
            
            $scope.figura = e.overlay;
            
            if(e.type=="polygon"){
                
                $scope.dataPerido.coordenadas = [];
                
                if($scope.figura.getPath().getArray().length>=3){
                    $scope.$apply(function () {
                        $scope.openModalZona();
                    });
                    
                    $scope.figura.getPath().getArray().forEach(function (position) {
                        $scope.zona.coordenadas.push( { x: position.lat(), y: position.lng() } );
                    });
                }
                else{ $scope.figura.setMap(null); }
            }
            
            else if(e.type=="marker"){
                $scope.openModalZonaProveedores();
            }
            
        }
     
        
        $scope.openModalZonaProveedores = function (pro) {
            
            if(pro){
                $scope.proveedorInformal = angular.copy(pro);
                $scope.TipoProveedorInformal.select = $scope.buscarAbjetoInArray( $scope.tiposProveedores, pro.categoria_rnt_id );
            }
            else{
                $scope.proveedorInformal = { latitud: $scope.figura.position.lat(),  longitud: $scope.figura.position.lng() };
            }
           
            $scope.proveedorInformal.idPeriodo = $("#periodo").val();
           
            $scope.formP.$setPristine();
            $scope.formP.$setUntouched();
            $scope.formP.$submitted = false;
            $("#modalAddProveedor").modal({ backdrop: 'static', keyboard: true, show: true });
        }
        
        
        $scope.openModalZona = function (zona) {
            $scope.zona = zona ? angular.copy(zona) : { periodo: $("#periodo").val(), encargados:[], coordenadas:[], color: "#000000" };
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
            $("#modalAddZona").modal({ backdrop: 'static', keyboard: true, show: true });
        }
        
        
        $scope.guardarProveedorInformal = function () {
            
            if (!$scope.formP.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");

            ServiMuestra.agregarProveedorInformal($scope.proveedorInformal)
                    .then(function (data) {
                       
                        if (data.success) {
                            if(!$scope.proveedorInformal.id){
                                $scope.markersProveedores.push( $scope.crearMarker(data.proveedor) );
                                $scope.validarProveedoresFueraZona();
                                $scope.TotalInformales +=1;
                                for(var i=0; i<$scope.tiposProveedores.length; i++){
                                    if($scope.tiposProveedores[i].id==data.proveedor.categoria_rnt_id){
                                        $scope.tiposProveedores[i].cantidad.informales +=1;
                                        for(var j=0; j<$scope.tiposProveedores[i].categoria_proveedores.length; j++){
                                            if($scope.tiposProveedores[i].categoria_proveedores[j].id==data.proveedor.subcategoria_rnt_id){
                                                $scope.tiposProveedores[i].categoria_proveedores[j].cantidad.informales +=1; break;
                                            }
                                        }
                                        break;
                                    }
                                }
                            }
                            else{
                                for(var i=0; i<$scope.markersProveedores.length; i++){
                                    if( $scope.markersProveedores[i].dataProveedor.id==data.proveedor.id && !$scope.markersProveedores[i].dataProveedor.rnt ){
                                        $scope.markersProveedores[i].dataProveedor = data.proveedor;
                                        $scope.proveedorInformal = angular.copy(data.proveedor);
                                        break;
                                    }
                                }
                            }
                            
                            $scope.clusterProveedores.clearMarkers();
                            $scope.clusterProveedores.addMarkers($scope.markersProveedores);
                            $scope.clusterProveedores.redraw();
                            
                            swal("¡Proveedor guardado!", "El proveedor se ha guardado exitosamnete", "success");
                            $("#modalAddProveedor").modal("hide");
                            $scope.cancelarAgregarZonaPRoveedor();
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
        
        $scope.guardarZona = function (item) {
            
            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error"); return;
            }
            
             $("body").attr("class", "cbp-spmenu-push charging");
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
                            $scope.crearPolygono(data.zona);
                            swal("¡Bloque guardado!", "El bloque se ha guardado exitosamnete", "success");
                            $scope.cancelarAgregarZonaPRoveedor();
                        }
                        else {
                            if(data.error){
                                swal("Error", data.error, "error"); 
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
                            
                            for(var i=0; i<$scope.sharpesAndPopus.length;i++){
                                if($scope.sharpesAndPopus[i].sharpe.dataZona.id==data.zona.id){
                                    $scope.sharpesAndPopus[i].sharpe.dataZona.sector_id = data.zona.sector_id;
                                    $scope.sharpesAndPopus[i].sharpe.dataZona.nombre = data.zona.nombre;
                                    $scope.sharpesAndPopus[i].sharpe.dataZona.encargados = data.zona.encargados;
                                    $scope.sharpesAndPopus[i].sharpe.dataZona.color = data.zona.color;
                                    $scope.sharpesAndPopus[i].sharpe.set('fillColor',data.zona.color);
                                    $scope.sharpesAndPopus[i].popup.anchor.childNodes[0].children[0].innerHTML = data.zona.nombre;
                                    
                                    $scope.detalleZona = angular.copy( $scope.sharpesAndPopus[i].sharpe.dataZona );
                                    break;
                                }
                            }
                            swal("¡Bloque guardado!", "El bloque se ha guardado exitosamnete", "success");
                            $("#modalAddZona").modal("hide");
                        }
                        else {
                            if(data.error){
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
        
        $scope.eliminarZona = function (zona) {
            swal({
                title: "Eliminar bloque",
                text: "¿Esta seguro de eliminar el bloque : "+ zona.nombre +" ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    
                    ServiMuestra.eliminarZona( { zona:zona.id , periodo:$("#periodo").val()}  )
                    .then(function (data) {
                        if (data.success) {
                            $scope.zonaEditarPos.setMap(null);
                            $scope.popupEditarPos.setMap(null);
                            swal("¡Bloque eliminado!", "El bloque se ha eliminado exitosamnete", "success");
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
        
        $scope.filtroProveedoresInput = function($event){
            
            if( $event.keyCode!=13 ){ return; }
            
            $scope.filterProveedores();
            
            if( !$scope.filtro.busqueda ){ return; }
            if( $scope.filtro.busqueda=="" || $scope.filtro.busqueda==" " ){ return; }
            
            var proveedores = $scope.clusterProveedores.getMarkers();
            var dynMarkers = [];
            var aux;
            
            for(var i=0; i<proveedores.length; i++){
                aux = JSON.stringify( proveedores[i].dataProveedor ).toLowerCase();
                if( aux.includes( $scope.filtro.busqueda.toLowerCase() ) ){
                    dynMarkers.push( proveedores[i] ); 
                }
            }
            
            $scope.clusterProveedores.clearMarkers();
            
            if(dynMarkers.length>0){
                
                $scope.clusterProveedores.addMarkers(dynMarkers);
                $scope.clusterProveedores.redraw();
                
                $scope.map.setZoom(15);
                $scope.map.setCenter( dynMarkers[0].position );
            }
            
        }
        
        $scope.filterProveedores = function(){
            
            var dynMarkers = [];
            
            for( var i=0; i<$scope.markersProveedores.length; i++ ){
                var pro = $scope.markersProveedores[i].dataProveedor;
                
                var sw0 = 0; var sw1 = 0; var sw2 = 0; var sw3 = 0; var sw4 = 0;
            
                if( $scope.filtro.tipoProveedores!=1){
                    sw0 = (($scope.filtro.tipoProveedores==2 && pro.rnt) || ($scope.filtro.tipoProveedores==3 && !pro.rnt)) ? 1 : -1;
                }
                
                if($scope.filtro.tipo.length>0){
                    sw1 = $scope.filtro.tipo.indexOf(pro.categoria_rnt_id);
                    
                    if($scope.filtro.categorias.length>0){ sw1 =  $scope.filtro.categorias.indexOf(pro.subcategoria_rnt_id); }
                }
                
                if($scope.filtro.estados.length>0){ sw2 = $scope.filtro.estados.indexOf(pro.estado_rnt_id); }
                
                if($scope.filtro.municipios.length>0){ sw3 = $scope.filtro.municipios.indexOf(pro.municipio_rnt_id); }
                
                if( $scope.filtro.sectoresProv.length > 0){ 
                    
                    sw4 = -1;
                    
                    for(var k=0; k<$scope.sharpesAndPopus.length; k++){
                        
                        if( $scope.filtro.sectoresProv.indexOf( $scope.sharpesAndPopus[k].sharpe.dataZona.sector_id )!=-1 ){
                            if( google.maps.geometry.poly.containsLocation( $scope.markersProveedores[i].position , $scope.sharpesAndPopus[k].sharpe ) ){
                                sw4 = 1; break;    
                            }
                        }
                        
                    }
                    
                }
                
                if( ( (sw0>=0?true:false) && (sw1>=0?true:false) && (sw2>=0?true:false) && (sw3>=0?true:false) && (sw4>=0?true:false) ) ){
                    dynMarkers.push( $scope.markersProveedores[i] );
                }
                
            }
            
            $scope.clusterProveedores.clearMarkers();
            $scope.clusterProveedores.addMarkers(dynMarkers);
            $scope.clusterProveedores.redraw();
            
        }
        
        $scope.filterZonas = function(){
            
            var item, sw, sw1, sw2;
            
            for(var i=0;i<$scope.sharpesAndPopus.length; i++){
                
                sw1 = 0;
                sw2 = 0;
                item = $scope.sharpesAndPopus[i].sharpe.dataZona;
                
                if($scope.filtro.encargados.length>0){
                    sw1 = -1;
                    for(var j=0; j<item.encargados.length; j++){
                        if($scope.filtro.encargados.indexOf(item.encargados[j].id)!=-1){ sw1 = 1; break; }
                    }
                }
                
                if($scope.filtro.sectores.length>0){
                    sw2 = $scope.filtro.sectores.indexOf(item.sector_id); 
                }
                
                sw = ((sw1>=0?true:false) && (sw2>=0?true:false));
                $scope.sharpesAndPopus[i].sharpe.setVisible( sw );
                $scope.sharpesAndPopus[i].popup.setMap( sw ? $scope.map : null );
                
            }
            
        }
        
        $scope.limpiarFiltros = function(){
            $scope.filtro = { tipo:[], categorias:[], estados:[], municipios:[], sectoresProv:[], verZonas:true, sectores:[], encargados:[], tipoProveedores:1 };
        }
        
        $scope.getIcono = function( p ){
            
            if(p){
                var ruta = "";
                
                switch ( p.categoria_rnt_id ) {
                    case 1: ruta  += "/Content/IconsMap/alojamientos/"; break;
                    case 2: ruta  += "/Content/IconsMap/establecimiento_gastronomia/"; break;
                    case 3: ruta  += "/Content/IconsMap/agencias_viajes/"; break;
                    //case 4: ruta  += "esparcimiento/"; break;
                    case 5: ruta  += "/Content/IconsMap/empresa_transporte/"; break;
                    case 6: ruta  += "/Content/IconsMap/arrendadores_vehiculos/"; break;
                    case 7: ruta  += "/Content/IconsMap/concesionarios_servicios/"; break;
                    case 8: ruta  += "/Content/IconsMap/empresa_tiempo/"; break;
                    case 9: ruta  += "/Content/IconsMap/empresas_captadoras/"; break;
                    case 10: ruta += "/Content/IconsMap/guia_turismo/"; break;
                    case 11: ruta += "/Content/IconsMap/oficina_turistica/"; break;
                    case 12: ruta += "/Content/IconsMap/operadores_profesionales/"; break;
                    case 13: ruta += "/Content/IconsMap/parques_tematicos/"; break;
                    case 14: ruta += "/Content/IconsMap/usuarios_operadores/"; break;
                    default: break;
                }
                
                if(ruta != ""){
                    if(p.rnt){
                        switch ( p.estado_rnt_id ) {
                            case 1: ruta += "activo.png";     break;  // Activo
                            case 2: ruta += "cancelado.png";  break;  // Nnulado
                            case 3: ruta += "cancelado.png";  break;  // Cancelado
                            case 4: ruta += "cancelado.png";  break;  // Cancelado por traslado
                            case 5: ruta += "pendiente.png";  break;  // Pendiente actualización
                            case 6: ruta += "cancelado.png";  break;  // Suspendido
                            default: return null;
                        }
                    }
                    else{ ruta += "informal.png";  }
                }
                
                return  ruta;
            }
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        
        $scope.verOcultarZonas = function(){
            for(var i=0;i<$scope.sharpesAndPopus.length; i++){
               $scope.sharpesAndPopus[i].sharpe.setVisible($scope.filtro.verZonas);
               $scope.sharpesAndPopus[i].popup.setMap( $scope.filtro.verZonas ? $scope.map : null );
            }
        }
        
        $scope.verOcultarLabels = function(verLabels){
            
            $scope.dynMarkers = $scope.clusterProveedores.getMarkers();
            
            for( var i = 0; i < $scope.dynMarkers.length; i++ ){
                $scope.dynMarkers[i].setLabel( verLabels ? $scope.dynMarkers[i].dataProveedor.concat : null );
            }
            
            $scope.clusterProveedores.clearMarkers();
            $scope.clusterProveedores.addMarkers($scope.dynMarkers);
            $scope.clusterProveedores.redraw();
            
        }
        
        $scope.showInfoMapa = function(){ 
            
            if( $scope.proveedor ){
                $scope.cancelarEditarPosicionProveedor();
            }
            $scope.proveedor = this.dataProveedor;
            $scope.proveedorEditarPos = this;
            document.getElementById("mySidenav").style.width = "350px";
            $scope.detalleZona = null;
            $scope.$apply();
        }  
        
        $scope.showInfoNumeroPS = function(){
            
            if($scope.detalleZona){
                if( $scope.detalleZona.editar ){ return; }
            }
            
            $scope.zonaEditarPos = this;
            var zona = this.dataZona;
            
            for(var i=0; i<$scope.sharpesAndPopus.length; i++){
                if( $scope.sharpesAndPopus[i].sharpe.dataZona.id == zona.id  ){
                    $scope.popupEditarPos = $scope.sharpesAndPopus[i].popup; break;
                }
            }
            
            var proveedores = $scope.clusterProveedores.getMarkers(); 
            
            var numeroPrestadoresFormales = 0 ;
            var numeroPrestadoresInformales = 0 ;
            
            var tiposProveedores = angular.copy($scope.tiposProveedoresInfo);
            var estadosProveedores =  angular.copy($scope.estados);
            
            for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
            
            for(var i=0; i<proveedores.length; i++){
                
                if( google.maps.geometry.poly.containsLocation( proveedores[i].position , this) ){
                    
                    for(var j=0; j<tiposProveedores.length; j++){ 
                        
                        if(tiposProveedores[j].id==proveedores[i].dataProveedor.categoria_rnt_id){
                            
                            if(proveedores[i].dataProveedor.rnt){ tiposProveedores[j].cantidad[0] += 1; numeroPrestadoresFormales+=1; }
                            else{ tiposProveedores[j].cantidad[1] += 1; numeroPrestadoresInformales+=1; }
                            break;
                        }
                        
                    }  
                    
                    for(var j=0; j< estadosProveedores.length; j++){ 
                       if( estadosProveedores[j].id == proveedores[i].dataProveedor.estado_rnt_id ){
                            estadosProveedores[j].cantidad += 1; break;
                        } 
                    } 
                    
                }
            }
            
            $scope.detalleZona = angular.copy(zona);
            $scope.detalleZona.tiposProveedores = tiposProveedores;
            $scope.detalleZona.estadosProveedores = estadosProveedores;
            $scope.detalleZona.numeroPrestadoresFormales = numeroPrestadoresFormales;
            $scope.detalleZona.numeroPrestadoresInformales = numeroPrestadoresInformales;
            
            document.getElementById("mySidenav").style.width = "350px";
            $scope.proveedor = null;
            $scope.$apply();
        }  
        
        $scope.closeInfoMapa = function(){
            $scope.proveedor = null;
            $scope.detalleZona = null;
            document.getElementById("mySidenav").style.width = "0";
        }
        
        $scope.editarPosicionProveedor = function(){
            $scope.proveedorEditarPos.setDraggable(true);
            $scope.proveedor.editar = true;
        }
        
        $scope.cancelarEditarPosicionProveedor = function(){
            if($scope.proveedor.editar){
                $scope.proveedorEditarPos.setPosition( new google.maps.LatLng($scope.proveedorEditarPos.dataProveedor.latitud, $scope.proveedorEditarPos.dataProveedor.longitud) );
                $scope.proveedor.editar = false;
                $scope.proveedorEditarPos.setDraggable(false);
            }
        }
        $scope.guardarEditarPosicionProveedor = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            var data = {
                         id : $scope.proveedorEditarPos.dataProveedor.id,
                         rnt : $scope.proveedorEditarPos.dataProveedor.rnt,
                         latitud : $scope.proveedorEditarPos.getPosition().lat() + "",
                         longitud : $scope.proveedorEditarPos.getPosition().lng() + ""
                       };
                       
            ServiMuestra.editarPosicionProveedor(data)
                    .then(function (data) {
                       
                        if (data.success) {
                            swal("¡Proveedor guardado!", "El proveedor se ha guardado exitosamnete", "success");
                            $scope.proveedor.editar = false;
                            
                            for( var i=0; i<$scope.markersProveedores.length; i++){
                                if( $scope.markersProveedores[i].dataProveedor.id == data.id ){
                                    $scope.markersProveedores[i].dataProveedor.latitud = data.latitud;
                                    $scope.markersProveedores[i].dataProveedor.longitud = data.longitud;
                                    $scope.markersProveedores[i].setPosition( new google.maps.LatLng(data.latitud, data.longitud) );
                                    break;
                                }
                            }
                            $scope.validarProveedoresFueraZona();
                            $scope.proveedorEditarPos.setDraggable(false);
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
        
        $scope.editarPosicionZona = function(zona,index){
            
            if($scope.detalleZona){
               if($scope.detalleZona.editar){
                   swal("No se puede editar el bloque", "Actualmente existe una bloque en edición, por favor cancele y vuelva a intentarlo.", "info"); return;
               } 
            }
            
            $scope.detalleZona = zona;
            $scope.detalleZona.editar = true;
            $scope.zonaEditarPos.setDraggable(true);
            $scope.zonaEditarPos.setEditable(true);
        }
        
        $scope.cancelarEditarPosicion = function(){
            
            $scope.zonaEditarPos.setPaths( $scope.getCoordenadasZona( $scope.detalleZona.coordenadas ) );
            $scope.popupEditarPos.position = $scope.zonaEditarPos.getPath().getArray()[0];
            $scope.detalleZona.editar = false;
            $scope.zonaEditarPos.setDraggable(false);
            $scope.zonaEditarPos.setEditable(false);
            
        }
        
        $scope.changeTipoProveedor = function(){
            
            $scope.cateGoriasPRoveedores = [];
            for(var i=0; i< $scope.filtro.tipo.length; i++){
                for(var j=0; j< $scope.tiposProveedores.length; j++){
                    if($scope.filtro.tipo[i]==$scope.tiposProveedores[j].id){
                        $scope.cateGoriasPRoveedores = $scope.cateGoriasPRoveedores.concat( $scope.tiposProveedores[j].categoria_proveedores );
                        break;
                    }
                }
            }
            
            if($scope.filtro.tipo.length==0){ $scope.filtro.categorias = []; }

        }
        
        $scope.guardarEditarPosicion = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            var data = { id: $scope.detalleZona.id, coordenadas:[] };
            
            $scope.zonaEditarPos.getPath().getArray()
                .forEach(function (position) {
                            data.coordenadas.push( [ position.lat(), position.lng() ] );
                        });
            
            ServiMuestra.editarPosicionZona(data)
                    .then(function (data) {
                       
                        if (data.success) {
                            $scope.zonaEditarPos.dataZona.coordenadas = data.zona.coordenadas;
                            $scope.detalleZona.coordenadas = $scope.zonaEditarPos.dataZona.coordenadas;
                            $scope.detalleZona.editar = false;
                            $scope.zonaEditarPos.setDraggable(false);
                            $scope.zonaEditarPos.setEditable(false);
                            $scope.validarProveedoresFueraZona();
                            swal("¡Bloque guardado!", "El bloque se ha guardado exitosamnete", "success");
                        }
                        else {
                            if(data.error){
                                swal("Error", data.error, "error"); 
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
        
        $scope.ChangedPositions = function() {
            $scope.popupEditarPos.position = this.getPath().getArray()[0];
        };
        
        $scope.verTablaZonas = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            $timeout(function() {
            
                $scope.detalle = [];
                var zona = null;
                
                for(var i=0; i<$scope.sharpesAndPopus.length; i++){
                    
                    var tiposProveedores =  angular.copy($scope.tiposProveedoresInfo);
                    var estadosProveedores =  angular.copy($scope.estados);
                    for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
                    
                    zona = angular.copy($scope.sharpesAndPopus[i].sharpe.dataZona);
                    
                    for(var k=0; k<$scope.markersProveedores.length; k++){
                        
                        if( google.maps.geometry.poly.containsLocation( $scope.markersProveedores[k].position , $scope.sharpesAndPopus[i].sharpe ) ){
                            
                            
                            for(var j=0; j< tiposProveedores.length; j++){ 
                                if(tiposProveedores[j].id==$scope.markersProveedores[k].dataProveedor.categoria_rnt_id){
                                
                                    if($scope.proveedores[k].rnt){ tiposProveedores[j].cantidad[0] += 1; }
                                    else{ tiposProveedores[j].cantidad[1] += 1; }
                                    break;
                                }
                            }  
                            
                            for(var j=0; j< estadosProveedores.length; j++){ 
                                if( estadosProveedores[j].id == $scope.markersProveedores[k].dataProveedor.estado_rnt_id ){
                                    estadosProveedores[j].cantidad += 1; break;
                                }
                            } 
                            
                        }
                            
                    }
                    
                    zona.tiposProveedores = tiposProveedores;
                    zona.estadosProveedores = estadosProveedores;
                    $scope.detalle.push(zona);
                }
                
                $("#modalDetallesZonas").modal("show");
                $("body").attr("class", "cbp-spmenu-push");
            
            },200);

        }
        
        $scope.getCantidadProveedores = function(id, idCompara){
            
            var sF = 0; var sI = 0;
            
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i][idCompara]==id ){  
                    if($scope.proveedores[i].rnt){ sF+=1; }
                    else{ sI+=1; }
                }
            }
            
            return {  formales: sF,  informales: sI };
        }
        
        $scope.getCantidadPorEstado = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].estado_rnt_id==id ){  s+=1;  }
            }
            return s;
        }
        
        $scope.getCantidadPorSector = function(id){
            
            var sF = 0; var sI = 0;
            
            for(var i=0; i<$scope.sharpesAndPopus.length; i++){
                if($scope.sharpesAndPopus[i].sharpe.dataZona.sector_id==id){
                    for(var k=0; k<$scope.markersProveedores.length; k++){
                        
                        if( google.maps.geometry.poly.containsLocation( $scope.markersProveedores[k].position , $scope.sharpesAndPopus[i].sharpe ) ){
                            
                            if($scope.markersProveedores[k].dataProveedor.rnt){ sF+=1; }
                            else{ sI+=1; }
                            
                        }
                            
                    }
                }
            }
            
            return {  formales: sF,  informales: sI };
        }
        
        $scope.centerMapa = function(){
            
            if($scope.proveedoresFiltrados.length>0){
                $timeout(function() {
                    if($scope.proveedoresFiltrados.length>0){
                        $scope.map.setZoom(15);
                        $scope.map.setCenter( new google.maps.LatLng($scope.proveedoresFiltrados[0].latitud, $scope.proveedoresFiltrados[0].longitud) );
                    }
                },1000);
                
            }
            
        }
        
        $scope.centrarMapaAlProveedor = function(pro){
            $scope.map.setZoom(21);
            $scope.map.setCenter( new google.maps.LatLng(pro.latitud, pro.longitud) );
        }
        
        $scope.buscarAbjetoInArray = function(array, id){
            for(var j=0; j<array.length; j++){
                if( array[j].id==id ){ return array[j]; }
            }
            return null;
         } 
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({ strokeColor: 'red', strokeWeight: 1, fillOpacity:0, clickable:false });
        });
        
    }])
     
    .controller("DetalleMuestraMaestraCtrl", ["$scope","ServiMuestra", "NgMap", "$timeout", function($scope,ServiMuestra,NgMap,$timeout){
        
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.selectTipoProveedores = { select:[] };
        $scope.filtro = { tipo:[], categorias:[], estados:[], sectoresProv:[], municipios:[], verZonas:true, sectores:[], encargados:[] };
        $scope.dataPerido = { zonas:[] };
        $scope.zona = {};
        $scope.styloMapa = [{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ];
         
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                $scope.sectoresZonasIDS = [];
                $scope.sectoresZonas = [];
                for(var i=0; i< data.periodo.zonas.length; i++){
                    data.periodo.zonas[i].coordenadas = $scope.getCoordenadas(data.periodo.zonas[i].coordenadas);
                    
                    if( $scope.sectoresZonasIDS.indexOf( data.periodo.zonas[i].sector_id )==-1 && data.periodo.zonas[i].sector_id ){
                        $scope.sectoresZonasIDS.push( data.periodo.zonas[i].sector_id );
                        $scope.sectoresZonas.push( $scope.getSector(data.sectores,data.periodo.zonas[i].sector_id) );
                    }
                }
                
                $scope.dataPerido = data.periodo;
                $scope.digitadores = data.digitadores; 
                $scope.proveedores = data.proveedores;
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.sectores = data.sectores;
                $scope.estados = data.estados;
                $scope.municipios = data.municipios;
                
                $scope.tiposProveedoresInfo = [];
                for(var i=0; i<data.tiposProveedores.length; i++){
                    $scope.tiposProveedoresInfo.push( { id:data.tiposProveedores[i].id , nombre:data.tiposProveedores[i].tipo_proveedores_con_idiomas[0].nombre, cantidad:0 } );
                }
                $("body").attr("class", "cbp-spmenu-push");
                
                
            });
        
         $scope.getSector = function(array, id){
            for(var j=0; j<array.length; j++){
                if( array[j].id==id ){ return array[j]; }
            }
            return null;
         } 
        
        $scope.exportarFileKML = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
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
       
 
        
        
        $scope.filterProveedores = function(pro){
            
            var sw1 = 0; var sw2 = 0; var sw3 = 0;
            
            if($scope.filtro.tipo.length>0){
                sw1 = $scope.filtro.tipo.indexOf(pro.categoria.tipo_proveedores_id);
                
                if($scope.filtro.categorias.length>0){
                    sw1 =  $scope.filtro.categorias.indexOf(pro.categoria_proveedores_id);
                }
            }
            
            if($scope.filtro.estados.length>0){
                sw2 = $scope.filtro.estados.indexOf(pro.estados_proveedor_id);
            }
            
            if($scope.filtro.municipios.length>0){
                sw3 = $scope.filtro.municipios.indexOf(pro.municipio_id);
            }
            
            
            return (sw1>=0?true:false) && (sw2>=0?true:false) && (sw3>=0?true:false);
            
        }
        
        $scope.filterProveedoresSectorMunicipio = function(pro){
            
            if( $scope.filtro.sectoresProv.length > 0){ 
                
                var point = new google.maps.LatLng( pro.latitud , pro.longitud );
                
                for (var i = 0; i < $scope.dataPerido.zonas.length; i++) { 
                    if( $scope.filtro.sectoresProv.indexOf( $scope.dataPerido.zonas[i].sector_id )!=-1 ){
                
                        if( google.maps.geometry.poly.containsLocation( point , $scope.map.shapes[i] ) ){
                            return true;
                        }
                        
                    }
                }
                return false;
            }
            
            return true;
        }
        
        $scope.filterZonas = function(item){
            
            var sw1 = 0;
            
            if($scope.filtro.encargados.length>0){
                for(var i=0; i<item.encargados.length; i++){
                    if($scope.filtro.encargados.indexOf(item.encargados[i].id)!=-1){ sw1 = 1; break; }
                }
                sw1 = sw1==1 ? 1 : 2;
            }
            
            if($scope.filtro.sectores.length>0){
                return sw1==1 ? true && $scope.filtro.sectores.indexOf(item.sector_id)!=-1 : $scope.filtro.sectores.indexOf(item.sector_id)!=-1; 
            }
            
            
            return true;
        }
        
        $scope.limpiarFiltros = function(){
            $scope.filtro = { tipo:[], categorias:[], estados:[], sectoresProv:[], verZonas:true, sectores:[], encargados:[] };
        }
        
        $scope.getIcono = function( p ){
            
            var ruta = "/Content/IconsMap/";
            
            switch ( p.idtipo ) {
                case 1: ruta  += "alojamientos/"; break;
                case 2: ruta  += "establecimiento_gastronomia/"; break;
                case 3: ruta  += "agencias_viajes/"; break;
                //case 4: ruta  += "esparcimiento/"; break;
                case 5: ruta  += "empresa_transporte/"; break;
                case 6: ruta  += "arrendadores_vehiculos/"; break;
                case 7: ruta  += "concesionarios_servicios/"; break;
                case 8: ruta  += "empresa_tiempo/"; break;
                case 9: ruta  += "empresas_captadoras/"; break;
                case 10: ruta += "guia_turismo/"; break;
                case 11: ruta += "oficina_turistica/"; break;
                case 12: ruta += "operadores_profesionales/"; break;
                case 13: ruta += "parques_tematicos/"; break;
                case 14: ruta += "usuarios_operadores/"; break;
                default: return null;
            }
            
            if(p.rnt){
                switch ( p.idestado ) {
                    case 1: ruta += "activo.png";     break;  // Activo
                    case 2: ruta += "cancelado.png";  break;  // Nnulado
                    case 3: ruta += "cancelado.png";  break;  // Cancelado
                    case 4: ruta += "cancelado.png";  break;  // Cancelado por traslado
                    case 5: ruta += "pendiente.png";  break;  // Pendiente actualización
                    case 6: ruta += "cancelado.png";  break;  // Suspendido
                    default: return null;
                }
            }
            else{ ruta += "informal.png";  }
            
            return  ruta;
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        
        $scope.verOcultarZonas = function(){
            for(var i in  $scope.map.shapes){
                $scope.map.shapes[i].setVisible($scope.filtro.verZonas);
                $scope.map.customMarkers[i].setVisible($scope.filtro.verZonas);
            }
        }
        
        $scope.showInfoMapa = function(event, proveedor){
            $scope.proveedor = proveedor;
            document.getElementById("mySidenav").style.width = "350px";
            $scope.detalleZona = null;
        }  
        
        $scope.showInfoNumeroPS = function(event, zona, proveedores){
            
            var numeroPrestadores = 0 ;
            
            var tiposProveedores = angular.copy($scope.tiposProveedoresInfo);
            var estadosProveedores =  angular.copy($scope.estados);
            
            for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
            
            for(var i=0; i<proveedores.length; i++){
                
                var point = new google.maps.LatLng( proveedores[i].latitud , proveedores[i].longitud );
                if( google.maps.geometry.poly.containsLocation( point , this) ){
                    numeroPrestadores++;
                    for(var j=0; j<tiposProveedores.length; j++){ 
                        if(tiposProveedores[j].id==proveedores[i].categoria.tipo_proveedores_id){
                            tiposProveedores[j].cantidad += 1; 
                        }
                    }  
                    
                    for(var j=0; j< estadosProveedores.length; j++){ 
                        if( estadosProveedores[j].id == $scope.proveedores[i].estados_proveedor_id ){
                            estadosProveedores[j].cantidad += 1; break;
                        }
                    } 
                    
                }
            }
            
            $scope.detalleZona = angular.copy(zona);
            $scope.detalleZona.tiposProveedores = tiposProveedores;
            $scope.detalleZona.estadosProveedores = estadosProveedores;
            $scope.detalleZona.total = numeroPrestadores;
            
            document.getElementById("mySidenav").style.width = "350px";
            $scope.proveedor = null;
        }  
        
        $scope.closeInfoMapa = function(){
            $scope.proveedor = null;
            $scope.detalleZona = null;
            document.getElementById("mySidenav").style.width = "0";
        }
        
        
        
        $scope.changeTipoProveedor = function(){
            
            $scope.cateGoriasPRoveedores = [];
            for(var i=0; i< $scope.filtro.tipo.length; i++){
                for(var j=0; j< $scope.tiposProveedores.length; j++){
                    if($scope.filtro.tipo[i]==$scope.tiposProveedores[j].id){
                        $scope.cateGoriasPRoveedores = $scope.cateGoriasPRoveedores.concat( $scope.tiposProveedores[j].categoria_proveedores );
                        break;
                    }
                }
            }
            
            if($scope.filtro.tipo.length==0){ $scope.filtro.categorias = []; }

        }
        
 
        
        $scope.verTablaZonas = function(){
            
            $scope.detalle = angular.copy($scope.dataPerido.zonas);
            
            
            var zona = null;
            
            for(var i=0; i<$scope.detalle.length; i++){
                
                zona = $scope.map.shapes[i];
                
                var tiposProveedores =  angular.copy($scope.tiposProveedoresInfo);
                var estadosProveedores =  angular.copy($scope.estados);
            
                for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
                
                
                for(var k=0; k<$scope.proveedores.length; k++){
                    
                    var point = new google.maps.LatLng( $scope.proveedores[k].latitud , $scope.proveedores[k].longitud );
                    if( google.maps.geometry.poly.containsLocation( point , zona ) ){
                        
                        for(var j=0; j< tiposProveedores.length; j++){ 
                            if( tiposProveedores[j].id == $scope.proveedores[k].categoria.tipo_proveedores_id ){
                                tiposProveedores[j].cantidad += 1;  break;
                            }
                        }  
                        
                        for(var j=0; j< estadosProveedores.length; j++){ 
                            if( estadosProveedores[j].id == $scope.proveedores[k].estados_proveedor_id ){
                                estadosProveedores[j].cantidad += 1; break;
                            }
                        } 
                        
                    }
                    
                }
                
                
           
                
                $scope.detalle[i].tiposProveedores = tiposProveedores;
                $scope.detalle[i].estadosProveedores = estadosProveedores;
                
            }
            
            
            $("#modalDetallesZonas").modal("show");
        }
        
        $scope.getCantidadPorTipo = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].categoria.tipo_proveedores_id==id ){  s+=1;  }
            }
            return s;
        }
        
        $scope.getCantidadPorCategoria = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].categoria_proveedores_id==id ){  s+=1;  }
            }
            return s;
        }
        
        $scope.getCantidadPorEstado = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].estados_proveedor_id==id ){  s+=1;  }
            }
            return s;
        }
        
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
           /*
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({
              strokeColor: 'red',
              strokeWeight: 1,
              fillOpacity:0,
              clickable:false
            });
            */
        });
        
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
    
    .controller("LlenatInfoZonaCtrl", ["$scope","ServiMuestra", function($scope,ServiMuestra){
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        ServiMuestra.getDataLLenarInfoZona( $("#id").val() )
            .then(function(data){ 
                $scope.zona = data.zona; 
                $scope.proveedores = data.proveedores; 
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.estados = data.estados;
                $("body").attr("class", "cbp-spmenu-push");
            });
        
        $scope.openModalEditPeriodo = function (item, index) {
            $scope.periodo = angular.copy(item);;
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $scope.IndexEditar = index;
            $("#modalAgregarPerido").modal("show");
        }
        
        
        $scope.guardar = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            var data = {
                zona: $("#id").val(),
                proveedores: $scope.proveedores,
            };
            
            ServiMuestra.guardarDataInfoZona(data)
                .then(function (data) {
                       
                        if (data.success) {
                            swal("¡Periodo guardado!", "El perido se ha guardado exitosamnete", "success");
                            $("#modalAgregarPerido").modal("hide");
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


        $scope.initSelectTipo = function(id){
            
            if(id){
                for(var i=0; i<$scope.tiposProveedores.length; i++){
                    if($scope.tiposProveedores[i].id==id){ return $scope.tiposProveedores[i]; }
                }
            }
            return null;
        }
        
        
        $scope.exportarFileExcelZona = function(){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiMuestra.getExcelZona( $scope.zona.id )
                .then(function(response){ 
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(response);
                    link.download = $scope.zona.nombre;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $("body").attr("class", "cbp-spmenu-push");
                    zona.es_generada = true;
                });
            
        }
        
    }]) 
    
    .controller("DetalleZonasCtrl", ["$scope","ServiMuestra", function($scope,ServiMuestra){
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                
                $scope.TotalFormales = data.proveedores.length;
                $scope.TotalInformales = data.proveedoresInformales.length;
                
                $scope.dataPerido = data.periodo;
                $scope.digitadores = data.digitadores; 
                $scope.proveedores = data.proveedores.concat(data.proveedoresInformales);
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.estados = data.estados;
                $scope.municipios = data.municipios;
                
                $scope.tiposProveedoresInfo = [];
                for(var i=0; i<data.tiposProveedores.length; i++){
                    $scope.tiposProveedoresInfo.push( { id:data.tiposProveedores[i].id , nombre:data.tiposProveedores[i].tipo_proveedores_con_idiomas[0].nombre, cantidad:[0,0] } );
                }
                
                $scope.calcular();
                
                $("body").attr("class", "cbp-spmenu-push");
                
            });
        
        
        $scope.calcular = function(){
            
            $scope.detalle = angular.copy($scope.dataPerido.zonas);
            
            
            var zona = null;
            
            for(var i=0; i<$scope.detalle.length; i++){
                
                zona = $scope.map.shapes[i];
                
                var tiposProveedores =  angular.copy($scope.tiposProveedoresInfo);
                var estadosProveedores =  angular.copy($scope.estados);
            
                for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
                
                
                for(var k=0; k<$scope.proveedores.length; k++){
                    
                    var point = new google.maps.LatLng( $scope.proveedores[k].latitud , $scope.proveedores[k].longitud );
                    if( google.maps.geometry.poly.containsLocation( point , zona ) ){
                        
                        
                        
                        for(var j=0; j< tiposProveedores.length; j++){ 
                            if(tiposProveedores[j].id==$scope.proveedores[i].idtipo){
                            
                                if($scope.proveedores[k].rnt){ tiposProveedores[j].cantidad[0] += 1; }
                                else{ tiposProveedores[j].cantidad[1] += 1; }
                                break;
                            }
                        }  
                        
                        for(var j=0; j< estadosProveedores.length; j++){ 
                            if( estadosProveedores[j].id == $scope.proveedores[k].idestado ){
                                estadosProveedores[j].cantidad += 1; break;
                            }
                        } 
                        
                    }
                    
                }
                
                
           
                
                $scope.detalle[i].tiposProveedores = tiposProveedores;
                $scope.detalle[i].estadosProveedores = estadosProveedores;
                
            }
            
        }
        
    }]) 
    
    
}());


/** Defines the Popup class. */
function definePopupClass() {
  /**
   * A customized popup on the map.
   * @param {!google.maps.LatLng} position
   * @param {!Element} content
   * @constructor
   * @extends {google.maps.OverlayView}
   */
  Popup = function(position, content) {
    
    this.position = position;

    content.classList.add('popup-bubble-content');

    var pixelOffset = document.createElement('div');
    pixelOffset.classList.add('popup-bubble-anchor');
    pixelOffset.appendChild(content);

    this.anchor = document.createElement('div');
    this.anchor.classList.add('popup-tip-anchor');
    this.anchor.appendChild(pixelOffset);

    // Optionally stop clicks, etc., from bubbling up to the map.
    //this.stopEventPropagation();
  };
  // NOTE: google.maps.OverlayView is only defined once the Maps API has
  // loaded. That is why Popup is defined inside initMap().
  Popup.prototype = Object.create(google.maps.OverlayView.prototype);

  /** Called when the popup is added to the map. */
  Popup.prototype.onAdd = function() {
    this.getPanes().floatPane.appendChild(this.anchor);
  };

  /** Called when the popup is removed from the map. */
  Popup.prototype.onRemove = function() {
    if (this.anchor.parentElement) {
      this.anchor.parentElement.removeChild(this.anchor);
    }
  };

  /** Called when the popup needs to draw itself. */
  Popup.prototype.draw = function() {
    var divPosition = this.getProjection().fromLatLngToDivPixel(this.position);
    // Hide the popup when it is far out of view.
    var display =
        Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
        'block' :
        'none';

    if (display === 'block') {
      this.anchor.style.left = divPosition.x + 'px';
      this.anchor.style.top = divPosition.y + 'px';
    }
    if (this.anchor.style.display !== display) {
      this.anchor.style.display = display;
    }
  };

  /** Stops clicks/drags from bubbling up to the map. */
  Popup.prototype.stopEventPropagation = function() {
    var anchor = this.anchor;
    anchor.style.cursor = 'auto';

    ['click', 'dblclick', 'contextmenu', 'wheel', 'mousedown', 'touchstart',
     'pointerdown']
        .forEach(function(event) {
          anchor.addEventListener(event, function(e) {
            e.stopPropagation();
          });
        });
  };
  
  
}