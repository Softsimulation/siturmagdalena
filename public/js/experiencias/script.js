
var destinos = [], categorias = [], perfiles = [];
var exp = undefined;

function addElement (array, element){
    if (!$.isArray(array)){
        return false;
    }
    array.push(element);
}

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
    console.log(array);
}

