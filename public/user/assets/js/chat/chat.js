$(document).ready(function () {


    $("#message").emojioneArea({
        inline: true,
    });
    $('#message').val("");
    $('.emojionearea-editor').html('');

    $('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")});

    $("#send").click(function () {
        let message = $('#message').val();
        let course_id = $('#course_id').val();
        if(message.length>0){
            let data = {
                message: message,
                course_id: course_id,
                _token: $('meta[name="csrf-token"]').attr('content'),
            }
            $.ajax({
                url:  "/chat/send",
                method: 'POST',
                dataType: 'JSON',
                data: data
            })
        }
    });

    function addMessage(data){
        let id = data.user_id;
        let el = createMessage(id);
        el.find('.message').text(data.message);
        el.find('.author').text(data.username);
        if (data.course_id === $('#course_id').val()){
            $('#messages').append(el)
        }
        $('#message').val("");
        $('.emojionearea-editor').html('');
        $('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")});
    }

    function createMessage(id){
        let user_id = Number($('#user_id').val());
        let staff_id =  Number($('#staff_id').val());
        let guard = Number($('#guard').val());
        let text = '';
        if ((user_id && guard && user_id===id) || (staff_id && !guard && staff_id===id)){
            text = $('#chat-message-auth').text();
        }else {
            text = $('#chat-message-other').text();
        }
        return $(text);
    }

    let pusher = new Pusher('86decffb3c4edd0b7ac9', {
        cluster: 'ap1'
    });
    let channel = pusher.subscribe('my-channel');
    channel.bind('form-chat', addMessage);
})
