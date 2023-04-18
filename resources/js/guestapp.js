import './bootstrap';

let authidd = $('#authid').val();
    window.Echo.channel('chat'+authidd)
    .listen('.message',(e)=>{
        
       let count = parseInt($('.messagecount').html());
       let authid = $('#authid').val();
       let base_url = $('#base-url').val();
    
    if(authid == e.reciever_id){
        // console.log('done');
        $('#guestmessage').append('<a href="'+base_url+'/message/'+e.username.unique_id+'" class="dropdown-item" id="'+e.sender_id+'"><div class="media"><div class="media-body"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b></p></div></div></a>');
        $('.messagecount').html(count+1);

    }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
       
        if(e.sender_id == reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><b>'+e.username.first_name+'</b>:<div class="direct-chat-text">'+e.message+'</div></div>');
            
        }    
    });
    

    