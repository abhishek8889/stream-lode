@extends('host_layout.master')
@section('content')

<div class="container" >
      <!-- reverse div -->
      <h3> Admin Notifications</h3>   
<div class="col-lg-12"  >
<table class="table table-striped projects">

               <tbody id="admin_notification" style="max-height: 500px; overflow: auto; display: flex; flex-direction: column-reverse;">
                @foreach($data as $d)
                <tr>
                     <td>
                         <a href="{{ url('/'.Auth::user()->unique_id.'/adminnotification') }}" notification-id="{{ $d['_id'] }}" message="{{ $d['message'] }}" class="admin_notification">
                            You got a new message from {{ $d['username'] }}  
                          </a>
                          <br>
                          <?php 
                        $time = Date("M/d/Y h:i A", strtotime("0 minutes", strtotime($d['created_at'])));
                        ?>
                          <span>{{ $time }}</span>
                     </td>
                 </tr>
                @endforeach 
               </tbody>
         </table>
 </div>
 <h3> Appoinments Notifications </h3>    
 <div class="col-lg-12"  style="max-height: 500px; overflow: auto; display: flex; flex-direction: column-reverse;"> 
         <table class="table table-striped projects">
             <tbody id="appointmentnotification">
                @forelse($hostappoinments as $hostappoinments)
                 <tr>
                     <td>
                         <a href="{{url('/'.Auth()->user()->unique_id.'/appointments') }}">
                            You got a new appointment from {{ $hostappoinments['guest_name'] }} for {{ $hostappoinments['duration_in_minutes']}} minutes 
                          </a>
                          <br>
                          <?php 
                        $time = Date("M/d/Y h:i A", strtotime("0 minutes", strtotime($hostappoinments['created_at'])));
                        ?>
                          <span>{{ $time }}</span>
                     </td>
                 </tr>
                 @empty
                @endforelse
                 
             </tbody>
         </table>
</div>
        
</div>
<!-- modal -->
 <div class="modal fade" id="exampleModalCenter123" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Admin Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 200px; overflow: auto;" id="modal-body">
   
   
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div> 

@endsection