/*
	function handleFileSelect(evt, idInput, idContentImg,idContentDiv) {
	    document.getElementById(idContentDiv).style.display = 'none';
	    document.getElementById(idContentImg).innerHTML = "";
	    
	    var files = evt.target.files; // FileList object

	    // Loop through the FileList and render image files as thumbnails.
	    for (var i = 0, f; f = files[i]; i++) {

	        // Only process image files.
	        if (!f.type.match('image.*')) {
	            continue;
	        }

	        var reader = new FileReader();

	        // Closure to capture the file information.
	        reader.onload = (function(theFile) {
	            return function(e) {
	                // Render thumbnail.
	                var span = document.createElement('div');
	                span.className = "col-xs-12 col-sm-3";

	                span.innerHTML = ['<div class="gallery-edit"><img src="', e.target.result,
                                      '" title="', escape(theFile.name), '"/></div>'].join('');
	                document.getElementById(idContentImg).insertBefore(span, null);



	            };
	        })(f);


	        // Read in the image file as a data URL.
	        reader.readAsDataURL(f);
	    }
	    var more = document.createElement('div');
	    more.className = "col-xs-12 col-sm-3";
	    if (idInput == 'portada') {
	        more.innerHTML = ['<div class="upload-file"><label for="portada"><div class="content-upload-file"><span class="glyphicon glyphicon-floppy-open"></span></div></label><input type="file" id="portada" name="portada" file-input="portada"/></div>'].join('');
	    } else {
	        more.innerHTML = ['<div class="upload-file"><label for="' + idInput + '"><div class="content-upload-file"><span class="glyphicon glyphicon-floppy-open"></span></div></label><input type="file" id="' + idInput + '" name="' + idInput + '" file-input="' + idInput + '" multiple/></div>'].join('');
	    }
	    document.getElementById(idContentImg).insertBefore(more, null);

	}
    */

	/*
	if (document.getElementById('galerias') != null) {
	    document.getElementById('galerias').addEventListener('change', function (event) { handleFileSelect(event, 'galerias','imgs-prev', 'upload-ini') }, false);
	}
	if (document.getElementById('portada') != null) {
	    document.getElementById('portada').addEventListener('change', function (event) { handleFileSelect(event, 'portada', 'imgs-prev', 'upload-ini') }, false);
	    document.getElementById('galeria').addEventListener('change', function (event) { handleFileSelect(event, 'galeria', 'imgs-prev-2', 'upload-ini-2') }, false);
	} else {
	    if (document.getElementById('galeria') != null) {
	        document.getElementById('galeria').addEventListener('change', function (event) { handleFileSelect(event, 'galeria','imgs-prev', 'upload-ini') }, false);
	    }
	}
    */