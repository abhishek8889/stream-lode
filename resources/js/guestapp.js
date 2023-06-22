import './bootstrap';

let authidd = $('#authid').val();
    window.Echo.channel('chat'+authidd)
    .listen('.message',(e)=>{
        
        $('#without_notification').hide();
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
       
        if(e.sender_id == reciever_id && e.reciever_id == sender_id){
            let timeString_ = moment(e.time).format("YYYY-MM-DD hh:mm A");
            $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><span class="direct-chat-name float-left">'+e.username.first_name+'</span><span class="direct-chat-name float-right">'+timeString_+'</span>:<div class="direct-chat-text message-reciever">'+e.message+'</div></div>');
            
        } else{
        // console.log(e);
       let count = parseInt($('.messagecount').html());
       let authid = $('#authid').val();
       let base_url = $('#base-url').val();
    
    if(authid == e.reciever_id){
        // console.log('done');
        $('#guestmessage').append('<a href="'+base_url+'/message/'+e.username.unique_id+'" class="dropdown-item" id="'+e.sender_id+'"><div class="media"><div class="media-body"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b></p></div></div></a>');
        $('.messagecount').html(count+1);
    }
}
          
    });
    

    