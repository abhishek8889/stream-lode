 @extends('host_layout.master')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Host Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('host-dashboard') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>${{number_format(array_sum($TotalAmount),2)  }}</h3>

                <p>Total Payments</p>
              </div>
              <div class="icon">
                <i class="fa fa-usd"></i>
              </div>
              <a href="{{ url(Auth()->user()->unique_id.'/stream-payments') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3> <?php 
                if(count($Total_duration) != 0){
                 $totalSeconds = 0; // Initialize total seconds to 0
       
                 foreach ($Total_duration as $time) {
                     list($hours, $minutes, $seconds) = explode(":", $time); // Extract hours, minutes, and seconds from the time value
                     $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds; // Convert time value to total seconds and add to totalSeconds
                 }
         
                 // Convert total seconds to hours, minutes, and seconds
                 $totalHours = floor($totalSeconds / 3600);
                 $totalMinutes = floor(($totalSeconds % 3600) / 60);
                 $totalSeconds = $totalSeconds % 60;
         
                 // Print the total time
                 echo $totalHours . ":" . $totalMinutes . ":" . $totalSeconds;
                }else{
                  echo 0 . ":" . 0 . ":" . 0;
                }
                ?>
                 <sup style="font-size: 20px"></sup></h3>
                <p>Streaming Hours</p>
              </div>
              <div class="icon">
                <i class="fa fa-video-camera" aria-hidden="true"></i>
              </div>
              <a href="" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $TotalAppoitments ?? '0' }}</h3>
                <p>Total Appointments</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar"></i>
              </div>
              <a href="{{ url(Auth()->user()->unique_id.'/appointments') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $TodayAppoitments ?? '0' }}</h3>

                <p>Today's Appointments</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-check-o "></i>
              </div>
              <a href="{{ url(Auth()->user()->unique_id.'/appointments') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection