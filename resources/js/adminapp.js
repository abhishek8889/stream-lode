import './bootstrap';

    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        console.log(e);
        let base_url = $('#base_url').val();
        let count = parseInt($('#messagecount').html());
        let count1 = parseInt($('#notificationcount').html());
       let authid = $('#hostauthid').val();
       let span = parseInt($('.user'+e.sender_id).html());
       if(authid == e.reciever_id){
        console.log(e.username);
        $('#messagecount').html(count+1);
        $('.user'+e.sender_id).html(span+1);
        $('#messagedropdown').append('<a href="'+base_url+'/admin/host-details/'+e.username.unique_id+'" class="dropdown-item" id="'+e.reciever_id+'"><div class="media"><div class="media-body" id="messages-notification"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b</p> </div></div></a>');
       }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
            $('#messages').append('<div class="direct-chat-msg" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">'+e.username.first_name+'</span></div><div class="direct-chat-text" style="margin-right:0px; margin-left:40%;">'+e.message+'</div></div>');
       
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">'+e.username.first_name+'</span> </div> <div class="direct-chat-text" style="margin-left:0px; margin-right:40%;">'+e.message+'</div></div>');
           
            }
        if(e.reciever_id === "public"){
            $('#notificationbox').append('<div class="direct-chat-msg right" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">'+e.username+'</span></div><div class="direct-chat-text" style="margin-right:0px; margin-left:40%;">'+e.message+'</div></div>');
            $('#notificationcount').html(count1 + 1);
        }
       
    });
 