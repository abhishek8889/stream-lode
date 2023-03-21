import './bootstrap';


    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        // console.log(e);
       let count = parseInt($('.messagecount').html());
       let authid = $('#authid').val();
    //    console.log(authid);
    if(authid = e.reciever_id){
        // console.log('done');
        $('.messagecount').html(count+1);
    }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
        $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><b>'+e.username+'</b>:<div class="direct-chat-text">'+e.message+'</div></div>');
        
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><b>'+e.username+'</b>:<div class="direct-chat-text">'+e.message+'</div></div>');
            
        }
            

    });
    

    