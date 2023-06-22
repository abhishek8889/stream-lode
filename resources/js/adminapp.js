import './bootstrap.js';
let authid = $('#hostauthid').val();
    window.Echo.channel('chat'+authid)
    .listen('.message',(e)=>{
        // console.log(authid);
        // console.log(e);
        // console.log(e.sender_id);
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id == reciever_id && e.reciever_id == sender_id){
            let timeString_ = moment(e.time).format("YYYY-MM-DD hh:mm A");
            $('#messages').append('<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">'+e.username.first_name+'</span><span class="direct-chat-name float-right">'+timeString_+'</span> </div> <div class="direct-chat-text m-0 message-reciever" >'+e.message+'</div></div>');
           
            }else{
        let base_url = $('#base_url').val();
        let count = parseInt($('#messagecount').html());
        let count1 = parseInt($('#notificationcount').html());
       let span = parseInt($('.user'+e.username._id).html());
       if(authid == e.reciever_id){
        // console.log(e.username._id);
        $('#messagecount').html(count+1);
        $('.user'+e.username._id).html(span+1);
        $('#messagedropdown').append('<a href="'+base_url+'/admin/host-details/'+e.username.unique_id+'" class="dropdown-item" id="'+e.reciever_id+'"><div class="media"><div class="media-body" id="messages-notification"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b</p> </div></div></a>');
       }
    } 
    });
   
   window.Echo.channel('notifications')
   .listen('.notification',(e)=>{
    // console.log(e);
   });
 