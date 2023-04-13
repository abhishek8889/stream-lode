import './bootstrap';


    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        // console.log(e);
       let count = parseInt($('.messagecount').html());
       let authid = $('#authid').val();
       let base_url = $('#base-url').val();
    //    console.log(authid);
    if(authid == e.reciever_id){
        // console.log('done');
        $('#guestmessage').append('<a href="'+base_url+'/message/'+e.username.unique_id+'" class="dropdown-item" id="'+e.sender_id+'"><div class="media"><div class="media-body"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b></p></div></div></a>');
        $('.messagecount').html(count+1);

    }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
        $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><b>'+e.username.first_name+'</b>:<div class="direct-chat-text">'+e.message+'</div></div>');
        
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><b>'+e.username.first_name+'</b>:<div class="direct-chat-text">'+e.message+'</div></div>');
            
        }    
    });
    

    