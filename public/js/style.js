$(document).ready(function(){
    $(".list-group .list-group-item").bind("click",function(){
        var clickedItem = $(this);
        $('.list-group .list-group-item').each(function(){
            $(this).removeClass('active');
        })
        clickedItem.addClass('active');
    });
});