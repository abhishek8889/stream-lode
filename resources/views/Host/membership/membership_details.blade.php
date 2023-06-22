@extends('host_layout.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> {{$membership_tier_details['name']}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('membership-details') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>User id : #{{ auth()->user()->unique_id }}</b></h3>
              </div>
                <div class="card-body">
                    @if(auth()->user()->active_status == 1)
                      @if($host_subscription_details['subscription_status'] == 'paused')
                      <?php $next_invoice_generate_on = date("M d Y h:i a", strtotime($host_subscription_details['next_invoice_generate_on']));   ?>
                       
                        <p class="alert alert-warning">Your subscription is paused and you cannot enjoy the video streaming features after {{ $next_invoice_generate_on }}. You can resume your subscription at anytime.</p>
                      @endif
                    @else
                      <p class="alert alert-warning">Your {{ $host_subscription_details['subscription_name'] }} (subscription) is canceled you have to purchase new subscription for video streaming. </p>
                    @endif
                    <div class="col-md-6">
                      <div class="userform">
                        <div class="">
                            <h2 class=""><b> {{$membership_tier_details['name']}}</b></h2>
                            <p class="text-muted"><b>Type: </b> {{ $membership_tier_details['type'] }} </p>
                            @if( $membership_tier_details['type']  == 'recurring')
                            <p class="text-muted"><b>Interval: </b> {{ $membership_tier_details['interval'] }} </p>
                            @endif
                            <p class="text-muted"><b>Amount: </b> ${{ number_format($membership_tier_details['amount'],2) }} </p>
                          <?php  $started_on =  date("M/d/Y h:i A", strtotime($host_subscription_details['start_on']));  ?>
                            <p class="text-muted"><b>Created at:</b> {{$started_on}} </p>
                            <?php  $valid_upto =  date("M/d/Y h:i A", strtotime($host_subscription_details['next_invoice_generate_on']));  ?>
                            <p class="text-muted"><b>Valid upto: </b> {{$valid_upto}}</p>  
                            @if(auth()->user()->active_status == 1)
                              <p class="text-muted"><b>Status: </b>  <span class="badge badge-success"><b> Active </b></span>  </p>  
                            @else
                              <p class="text-muted"><b>Status: </b>  <span class="badge badge-danger"><b> Inactive </b></span>  </p>  
                            @endif
                          @if($membership_tier_details['membership_features'])  <p class="text-muted"><b>Features: </b><?php  $x = 0; ?>
                            @foreach($membership_tier_details['membership_features'] as $mt)
                              @php
                              $x = $x+1;
                              $data = App\Models\MembershipFeature::find($mt);
                              @endphp  
                              @if($data)
                                <div class="feature-point"><span>{{ $x }} :</span> <span class="feature-details">{{ $data['description'] ?? '' }}.</span> </div> <br> 
                              @endif
                            @endforeach</p>
                          @endif
                          <p class="text-muted"><b>Description: </b> {{ $membership_tier_details['description'] }} </p>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      @if(auth()->user()->active_status == 1)
                        @if($host_subscription_details['subscription_status'] == 'paused')
                          <a href="{{ url('/'.auth()->user()->unique_id.'/resume-subscription') }}" class="btn btn-success">Resume Subscription</a>
                          <a href="{{ url('/'.auth()->user()->unique_id.'/cancel-subscription') }}" class="btn btn-danger">Cancel Subscription</a>
                          <a href="{{ url('/'.auth()->user()->unique_id.'/upgrademembership') }}" class="btn btn-info float-right">Upgrade Plan</a>
                        @else
                        <button href="{{ url('/'.auth()->user()->unique_id.'/pause-subscription') }}" class="btn btn-danger" id="pause-membership">Pause Subscription</button>
                        <button href="{{ url('/'.auth()->user()->unique_id.'/cancel-subscription') }}" class="btn btn-danger" id="cancel-membership" >Cancel Subscription</button>   <!-- jquery below for sweetalert -->
                        <button href="{{ url('/'.auth()->user()->unique_id.'/upgrademembership') }}" class="btn btn-info float-right" id="upgrade-plan">Upgrade Plan</button>
                        @endif
                      @else
                        <a href="{{ url('/'.auth()->user()->unique_id.'/membership') }}" class="btn btn-success">Purchase new subscription</a>
                      @endif
                    
                    
                  </div>
                </div>
            </div>
        </div>
    </section>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
      $('#pause-membership').click(function(){
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Are you sure you want to pause your membership?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = link;
                      } 
                    });
      });
      $('#cancel-membership').click(function(){
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Are you sure you want to cancel your membership?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = link;
                      } 
                    });  
      });
      $('#upgrade-plan').click(function(){
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Do you want to change your membership plan?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = link;
                      } 
                    });  
      });
    });

</script>
@endsection