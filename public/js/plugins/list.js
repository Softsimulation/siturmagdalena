$(document).ready(function() {
    if($('body').width() <= 500){
        $('.st-col-100').removeClass('size-list');
        $('.item').removeClass('view-list');
        $('.item').addClass('mosaico');
        $('#views').hide();
    }else{
        $('#views').show();
    }
    var items = document.getElementsByClassName('item');
    [].forEach.call(items, function (item)
    {
        
        if (item.childNodes[1].classList.contains('resizeName')) {
            item.childNodes[1].classList.remove('resizeName');
        }
        
        if (item.childNodes[1].clientWidth >= 60) {
            item.childNodes[1].classList.add('resizeName');
            
        }
    });
    $('.item').each(function(){
        var id = $(this).prop('id');
        resizeName('#'+id+'>.name');
    });
    $('#list').click(function(event){
        event.preventDefault(); $('.st-col-100').addClass('size-list');
        $('.item').removeClass('mosaico');
        $('.item').addClass('view-list');
        $('.item>.name').removeClass('decreaseName');
        $('.item>.pliegue').removeClass('decreasePliegue');
        $('.item>.name').removeClass('increaseName');
        $('.item>.pliegue').removeClass('increasePliegue');
        $('.item>.description').removeClass('decreaseDescription');
        $('.item>.description>.text').removeClass('decreaseDescription');
        $('.item>.description>.text').removeClass('increaseDescription');
        $('.item>.description').removeClass('increaseDescription');
        
    });
    $('#grid').click(function(event){
        event.preventDefault(); $('.st-col-100').removeClass('size-list');
        $('.item').removeClass('view-list');
        $('.item').addClass('mosaico');
        
    });

    $('.item').hover(function(){
        
        var id = $(this).prop('id');
        if ($('#' + id).hasClass('mosaico')) {
            
            $('#' + id + '>.name').removeClass('decreaseName');
            $('#' + id + '>.pliegue').removeClass('decreasePliegue');
            $('#' + id + '>.name').addClass('increaseName');
            $('#' + id + '>.date').addClass('increaseDate');
            $('#' + id + '>.pliegue').addClass('increasePliegue');
            $('#' + id + '>.description').addClass('increaseDescription');
            $('#' + id + '>.description>.text').addClass('increaseDescription');
            $('#' + id + '>.description').removeClass('decreaseDescription');
            $('#' + id + '>.description>.text').removeClass('decreaseDescription');
            resizeName('#' + id + '>.name');
            if ($('#' + id + '>.name').width() >= 100) {
                $('#' + id + '>.rating').addClass('relocateRating');
            }
            
            
        }
        
    },function(){
        
        var id = $(this).prop('id');
        if ($('#' + id).hasClass('mosaico')) {
            
            $('#' + id + '>.name').removeClass('increaseName');
            $('#' + id + '>.date').removeClass('increaseDate');
            $('#' + id + '>.pliegue').removeClass('increasePliegue');
            $('#' + id + '>.description>.text').removeClass('increaseDescription');
            $('#' + id + '>.description').removeClass('increaseDescription');
            $('#' + id + '>.name').addClass('decreaseName');
            $('#' + id + '>.pliegue').addClass('decreasePliegue');
            $('#' + id + '>.description').addClass('decreaseDescription');
            $('#' + id + '>.description>.text').addClass('decreaseDescription');
            resizeName('#' + id + '>.name');
            if ($('#' + id + '>.rating').hasClass('relocateRating')) {
                $('#' + id + '>.rating').removeClass('relocateRating');
            }
            
            
            
        }
        
    });
    
    $(window).resize(function(){
        if($('body').width() <= 500){
            $('.st-col-100').removeClass('size-list');
	        $('.item').removeClass('view-list');
	        $('.item').addClass('mosaico');
	        $('#views').hide();
        }else{
            $('#views').show();
        }
    });
    
    function resizeName(selector) {
        if (selector != null) {
            if ($(selector).hasClass('resizeName')) {
                $(selector).removeClass('resizeName');
            }
            if ($(selector).height() >= 60) {
                $(selector).addClass('resizeName');
            }
        }
        
    }
});