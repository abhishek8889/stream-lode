import './bootstrap';

let authidd = $('#hostauthid').val();
    window.Echo.channel('chat'+authidd)
    .listen('.message',(e)=>{
    //    console.log(e);
        let base_url = $('#base_url').val();
        let count = parseInt($('#messagecount').html());
        let sender_id = $('#sender_id').val();
        let reciever_id = $('#reciever_id').val();
        if(e.sender_id == reciever_id && e.reciever_id == sender_id){
            let timeString_ = moment(e.time).format("YYYY-MM-DD hh:mm A");
            $('#messages').append('<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">'+e.username.first_name+'</span><span class="direct-chat-name float-right">'+timeString_+'</span> </div> <div class="direct-chat-text message-reciever" style="margin-left:0px;">'+e.message+'</div></div>');
           
            }else{
       let authid = $('#hostauthid').val();
       let span = parseInt($('.user'+e.sender_id).html());
       if(authid == e.reciever_id){
        // console.log(e.username);
        $('#messagecount').html(count+1);
        $('.user'+e.sender_id).html(span+1);
        $('#messagedropdown').append('<a href="'+base_url+'/message/'+e.sender_id+'" class="dropdown-item" id="'+e.reciever_id+'"><div class="media"><div class="media-body" id="messages-notification"><p class="text-sm"><b>1 new message from '+e.username.first_name+'</b</p> </div></div></a>');
       }
        
    }
        
    });
    window.Echo.channel('adminnotification')
    .listen('.adminnotification',(e)=>{
        // console.log(e);
        let base_url = $('#base_url').val();
        let count1 = parseInt($('#notificationcount').html());
        if(e.reciever_id == "public"){ 
            let timestring = moment(e.time).format("YYYY-MM-DD HH:mm");
            $('#admin_notification').append('<tr><td><a href="'+base_url+'/adminnotification">You got a new message from '+e.username+'</a><br><span>'+timestring+'</span></td><tr>');
            $('#adminnotificationbox').append('<div class="direct-chat-msg" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">'+e.username+'</span><span class="direct-chat-name float-right">'+timestring+'</span></div><div class="direct-chat-text" style="margin-left:0px;">'+e.message+'</div></div>');
            $('#notificationcount').html(count1 + 1);
            // console.log(count1);
        }
    });
   
    window.Echo.channel('notifications'+authidd)
    .listen('.notification',(e)=>{
        // console.log(e);
        let authid = $('#hostauthid').val();
           let base_url = $('#base_url').val();
           let count1 = parseInt($('#notificationcount').html());
    
            if(authid == e.host_id){
                $('#notificationcount').html(count1 + 1);
                // console.log(e.appoinments);
            let timecreatedat = moment(e.appoinments.created_at).format("MM/DD/YYYY HH:mm");
            
                $('#appointmentnotification').append('<tr><td><a href="'+base_url+'/appointments">You got a new appointment from '+e.appoinments.guest_name+' for '+e.appoinments.duration_in_minutes+' minutes </a><br><span>'+timecreatedat+'</span></td><tr>');
            } 
    });
  