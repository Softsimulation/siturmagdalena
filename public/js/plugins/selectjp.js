function putfalse(array) {

    for (var i = 0; i < array.length; i++) {
        array[i]['selected'] = false;
    }
}

function inicializar(array, array2) {
    
    if (array2 != null) {

        for (var i = 0; i < array.length; i++) {
            for (var j = 0; j < array2.length; j++) {
                if (array2[j] == array[i].Id) {

                    array[i].selected = true;
                }
            }

        }
    }

}