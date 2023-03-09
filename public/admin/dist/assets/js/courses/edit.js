$(document).ready(function(){
    $(function() {
        $('.upload-video-file').on('change', function(){
            if (isVideo($(this).val())){
                $('.video-preview').attr('src', URL.createObjectURL(this.files[0]));
                $('.video-prev').show();
                $('#remove_video').show();
            }
        });
    });

    function isVideo(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'm4v':
            case 'avi':
            case 'mp4':
            case 'mov':
            case 'mpg':
            case 'mpeg':
                // etc
                return true;
        }
        return false;
    }

    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    $('#remove_video').click(function(){
        $('.upload-video-file').val('');
        $('.video-prev').show();
        $(this).hide();
        $('.video-preview').attr('src', '');
    });

    $('#type_course').change(function(){
        checkTypeCourse();
    });

    $("#kt_datepicker_3").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    $("#kt_datepicker_4").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    function checkTypeCourse(){
        if($('#type_course').val() == $('#type_live').val()){
            $('#option__live').removeClass('key_live');
            $('#option__live').addClass('active__type');
            $('#video__course').removeClass('active__type')
            $('#video__course').addClass('key_live');
        }
        if($('#type_course').val() == $('#type_ondemand').val()){
            $('#option__live').removeClass('active__type');
            $('#option__live').addClass('key_live');
            $('#video__course').removeClass('key_live');
            $('#video__course').addClass('active__type');
        }
    }
    checkTypeCourse();
    $('#check_featured').click(function (){
        if ($('#featured').is( ":checked" )){
            $('#featured').prop("checked");
            $('#featured').val($('#featured_course').val());
            $('#featured').css('background-color','blue');
        }else{
            $('#featured').val($('#no_featured_course').val());
            $('#featured').css('background-color','#ccc');
        }
    });
    function checkFeatured(){
        if(document.getElementById("featured").value == $('#featured_course').val()){
            document.getElementById("featured").checked = true;
            $('#featured').css('background-color','blue');
        };
    }
    checkFeatured();

    let customDatepicker = {
        enableTime: true,
        dateFormat:"Y-m-d H:i",
        locale: {
            weekdays: {
                shorthand: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
            },
            months: {
                longhand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
        },
    };
    $("#kt_datepicker_3").flatpickr(customDatepicker);
    $("#kt_datepicker_4").flatpickr(customDatepicker);
});
