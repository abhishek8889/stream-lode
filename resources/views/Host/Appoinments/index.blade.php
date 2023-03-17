@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('appoinments') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Appoinments</h3>

                <div class="card-tools">
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 390px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr no.</th>
                      <th>Guest Name</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Message</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php $count = 0; ?>
                  <tbody>
                    @if($host_schedule)
                    @forelse ($host_schedule as $hs)
                      <tr>
                        <?php $count = $count+1; ?>
                        <td>{{$count}}</td>
                        <td>{{$hs->guest_name}}</td>
                        <?php 
                        $startdate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->start)));
                        $enddate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->end)));
                        ?>
                        <td>{{$startdate}}</td>
                        <td>{{$enddate}}</td>
                        <td><a href="{{ url(Auth::user()->unique_id.'/hostmessage/'.$hs->_id) }}" class="btn btn-success">Messagebox</a></td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text text-bold text-danger">You have no appointments</td>
                      </tr>
                    @endforelse
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>

<script>

$(document).ready(function(){
      $('#message').on('submit',function(e){
        
      //    if(message == ''){
      //       alert('Please enter message')
      //       return false;
      //   }
        // e.preventDefault();
        // formdata = new FormData(this);
        // console.log(formdata);
      // //   console.log(formdata);
      //   $.ajax({
      //    method: 'post',
      //    url: '{{url('send-message')}}',
      //    data: formdata,
      //    dataType: 'json',
      //    contentType: false,
      //    processData: false,
      //    success: function(response)
      //    {
      //      // console.log(response);
      //      $('#messageinput').val('');
      //      // $(".direct-chat-messages").load(location.href + " .direct-chat-messages");
      //    }
      //   });
      });
    });
</script>
@endsection