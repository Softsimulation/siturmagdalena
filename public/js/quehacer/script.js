
var destinos = [], categorias = [], perfiles = [];
var exp = undefined;
let slider = null;

function addElement (array, element){
    if (!$.isArray(array)){
        return false;
    }
    array.push(element);
}

$(document).ready(function(){
    $("#demo").ionRangeSlider({
        type: "double",
        grid: false,
        min: 0,
        max: 1000000,
        from: 0,
        to: 1000000,
        prefix: "$"
    });
});


function deleteElement (array, element){
    if (!$.isArray(array)){
        return false;
    }else {
        if (array.length == 0){
            return false;
        }
    }
    $.each(array, function(index, value){
        if (value == element){
            array.splice(index, 1);
            return;
        }
    });
}

function change (object, array, element){
    if (!$(object).is(':checked')){
        deleteElement (array, element);
    }else{
        addElement (array, element);
    }
}

function formSubmit(){
    var slider = $("#demo").data("ionRangeSlider");
    $(".carga").css("display", "block");
    $.ajax({
      type: "POST",
      url: url,
      data: {
          'experiencia': exp,
          'destinos': destinos,
          'categorias': categorias,
          'perfiles': perfiles,
          'valor_inicial': slider.old_from,
          'valor_final': slider.old_to
      },
      success: function (data){
          if (!data.success){
              alert('No hay resultados para su búsqueda');
          }
          var html = '';
          for(var i = 0; i < data.query.length; i++){
            if(!tipoItem || (tipoItem && data.query[i].tipo == tipoItem)){
                html += '<div class="tile tile-overlap">'
                            +'<div class="tile-img">';
                    if(data.query[i].portada != ""){
                        html += '<img src="'+data.query[i].portada +'" alt="Imagen de presentación de '+ data.query[i].nombre +'"/>';
                    }
                html +=     +'</div>'
                                +'<div class="tile-body">'
                                    +'<div class="tile-caption">'
                                        +'<h3><a href="'+getItemType(data.query[i].tipo).path+data.query[i].id +'">'+ data.query[i].nombre +'</a></h3>'
                                        +'<span class="label '+colorTipo[data.query[i].tipo - 1]+'">'+getItemType(data.query[i].tipo).name+'</span>'
                                    +'</div>'
                                    +'<div class="tile-buttons">'
                                        +'<div class="inline-buttons">';
                //Acá falta las fechas en los eventos
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 0.0) ? ((data.query[i].calificacion_legusto <= 0.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 1.0) ? ((data.query[i].calificacion_legusto <= 1.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 2.0) ? ((data.query[i].calificacion_legusto <= 2.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 3.0) ? ((data.query[i].calificacion_legusto <= 3.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>'; 
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 4.0) ? ((data.query[i].calificacion_legusto <= 4.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button></div></div></div></div></div>';
          }
          }
          $('#listado').html(html);
          $(".carga").css("display", "none");
      },
      dataType: 'json'
    });
}

function clearFilters(){
    var slider = $("#demo").data("ionRangeSlider");
    destinos = [];
    categorias = [];
    perfiles = [];
    exp = undefined;
    $('input:checkbox').removeAttr('checked');
    $('input[type="radio"]').prop('checked', false);
    slider.reset();
    $(".carga").css("display", "block");
    $.ajax({
      type: "GET",
      url: resetUrl,
      success: function (data){
          var html = '';
          for(var i = 0; i < data.query.length; i++){
            if(!tipoItem || (tipoItem && data.query[i].tipo == tipoItem)){
                html += '<div class="tile tile-overlap">'
                            +'<div class="tile-img">';
                    if(data.query[i].portada != ""){
                        html += '<img src="'+data.query[i].portada +'" alt="Imagen de presentación de '+ data.query[i].nombre +'"/>';
                    }
                html +=     +'</div>'
                                +'<div class="tile-body">'
                                    +'<div class="tile-caption">'
                                        +'<h3><a href="'+getItemType(data.query[i].tipo).path+data.query[i].id +'">'+ data.query[i].nombre +'</a></h3>'
                                        +'<span class="label '+colorTipo[data.query[i].tipo - 1]+'">'+getItemType(data.query[i].tipo).name+'</span>'
                                    +'</div>'
                                    +'<div class="tile-buttons">'
                                        +'<div class="inline-buttons">';
                //Acá falta las fechas en los eventos
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 0.0) ? ((data.query[i].calificacion_legusto <= 0.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 1.0) ? ((data.query[i].calificacion_legusto <= 1.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 2.0) ? ((data.query[i].calificacion_legusto <= 2.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 3.0) ? ((data.query[i].calificacion_legusto <= 3.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>'; 
                html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 4.0) ? ((data.query[i].calificacion_legusto <= 4.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button></div></div></div></div></div>';
          }
          }
          $('#listado').html(html);
          $(".carga").css("display", "none");
      },
      dataType: 'json'
    });
}