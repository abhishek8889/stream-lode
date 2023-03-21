import './bootstrap';


    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        // console.log(e);
        let count = parseInt($('#messagecount').html());
        let count1 = parseInt($('#notificationcount').html());
       let authid = $('#hostauthid').val();
       if(authid = e.reciever_id){
        $('#messagecount').html(count+1);
        $('#notificationcount').html(count1+1);
       }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
        $('#messages').append('<p><strong>'+e.username+'</strong>'+ ': ' + e.message +'</p>');
        // $('#message').val('');
        
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<p><strong>'+e.username+'</strong>'+ ': ' + e.message +'</p>');
            $('#message').val('');
            }
            if(e.reciever_id === 'public'){
                $('#messages').append('<p><strong>'+e.username+'</strong>'+ ': ' + e.message +'</p>');
            }
    });