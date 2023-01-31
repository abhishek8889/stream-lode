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
              <li class="breadcrumb-item"><a href="{{ url('/'.auth()->user()->unique_id) }}">Home</a></li>
              <li class="breadcrumb-item active">Membership / {{$membership_tier_details['name']}}</li>
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
                    <div class="col-md-6">
                        <div class="form-group row">
                            @if(isset($membership_tier_details['logo_url']) || !empty($membership_tier_details['logo_url']))
                            <img src="{{ $membership_tier_details['logo_url'] }}" alt="" width="100px" height="100px" >
                            @endif
                        </div>   
                        <div class="userform">
                            <div class="">
                                <h2 class=""><b> {{$membership_tier_details['name']}}</b></h2>
                                <p class="text-muted"><b>Type: </b> {{ $membership_tier_details['type'] }} </p>
                                @if( $membership_tier_details['type']  == 'recurring')
                                <p class="text-muted"><b>Interval: </b> {{ $membership_tier_details['interval'] }} </p>
                                @endif
                                <p class="text-muted"><b>Amount: </b> ${{ $membership_tier_details['amount'] }} </p>
                                <p class="text-muted"><b>Created at:</b> {{$membership_tier_details['created_at']}} </p>
                                <?php 
                                $is_expired =  $membership_tier_details['created_at']->addDays(30);
                                ?>
                                <p class="text-muted"><b>valid upto: </b> {{ $is_expired }}</p>

                                <p class="text-muted"><b>Features: </b> {{ $membership_tier_details['description'] }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    <a href="{{ url('/'.auth()->user()->unique_id) }}" class="btn btn-info">Go to dashboard</a>
                    <a href="{{ url('/'.auth()->user()->unique_id.'/upgrade-subscription') }}" class="btn btn-danger">Upgrade Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection