import './bootstrap';


    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        // console.log(e);
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
        $('#messages').append('<p><strong>'+e.username+'</strong>'+ ': ' + e.message +'</p>');
        $('#message').val('');
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<p><strong>'+e.username+'</strong>'+ ': ' + e.message +'</p>');
            $('#message').val('');
            }

    });