$(function() {
    $('#search_data').on('click',function(){
        var name = $('.name').val();
        var category = $('#select').val();
        $.ajax({
            method:"get",
            url:'purchased_courses/search',
            data: {
                name:name,
                category:category
            },
            dataType:"json",
            success:function(response){
                $('#search_result').html(response);
            }
        });
    });
    $('#search').on('keyup',function(){
        var name = $('.name').val();
        var category = $('#select').val();
        $.ajax({
            method:"get",
            url:'purchased_courses/search',
            data: {
                name:name,
                category:category
            },
            success:function(response){
                $('#search_result').html(response);
            }
        });
    });
})
