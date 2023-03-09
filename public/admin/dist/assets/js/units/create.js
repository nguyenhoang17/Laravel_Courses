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

});
