import './bootstrap';



    window.Echo.channel('chat')
    .listen('.message',(e)=>{
        console.log(e);
        let count = parseInt($('#messagecount').html());
        let count1 = parseInt($('#notificationcount').html());
       let authid = $('#hostauthid').val();
       if(authid == e.reciever_id){
        $('#messagecount').html(count+1);
        // $('#messagedropdown').append('<a href="{{ url(Auth()->user()->unique_id."/message/"'+e.username._id+') }}" class="dropdown-item"><div class="media"><div class="media-body"><p class="text-sm"><b>new message from'+e.username.first_name+'</b></p></div></div></a><div class="dropdown-divider"></div>');
       }
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id = sender_id && e.reciever_id == reciever_id){
            $('#messages').append('<div class="direct-chat-msg right" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">'+e.username.first_name+'</span></div><div class="direct-chat-text" style="margin-right:0px;text-align: right; margin-left:40%;">'+e.message+'</div></div>');
        // $('#messages').append('<p><strong>'+e.username.first_name+'</strong>'+ ': ' + e.message +'</p>');
       
        }
        if(e.sender_id = reciever_id && e.reciever_id == sender_id){
            $('#messages').append('<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">'+e.username.first_name+'</span> </div> <div class="direct-chat-text" style="margin-left:0px; margin-right:40%;">'+e.message+'</div></div>');
            // $('#messages').append('<p><strong>'+e.username.first_name+'</strong>'+ ': ' + e.message +'</p>');
           
            }
        if(e.reciever_id === "public"){
            $('#notificationbox').append('<div class="direct-chat-msg right" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">'+e.username.first_name+'</span></div><div class="direct-chat-text" style="margin-right:0px;text-align: right; margin-left:40%;">'+e.message+'</div></div>');

        }
       
    });
    