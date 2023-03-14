@extends('admin_layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Total Guests : {{ count($guests) }}</b></h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>Profile</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Date of join</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- foreach  -->
                    @foreach($guests as $guest)
                    
                    <tr>
                        <td>
                            @if(isset($guest['profile_image_url']) || !empty($guest['profile_image_url']))
                            <img src="{{ $host['profile_image_url'] }}" alt="{{ $host['profile_image_name'] }}" class="rounded-circle" width="65px">
                            @else
                            <img src="{{ asset('Assets/images/default-avatar.jpg') }}" alt="default-image" class="rounded-circle" width="65px">
                            @endif
                        </td>
                        <?php 
                            $first_name = '';
                            $last_name = '';
                            if(isset($guest['first_name'] ?? '')){
                                $first_name = $guest['first_name'];
                            }
                            if(isset($guest['last_name'])){
                                $first_name = $guest['last_name'] ?? '';
                            }
                        ?>
                        <td>{{$first_name . '' . $last_name}}</td>
                        <td>{{ $guest['email'] ?? '' }}</td>

                        <?php 
                            $dateTimeObj = $guest['created_at']->toDateTime();
                            $timeString = $dateTimeObj->format(DATE_RSS);
                            $time = strtotime($timeString.' UTC');
                            $dateInLocal = date("M/d/Y (H:i)", $time);
                        ?>
                        <td> {{ $dateInLocal }} </td>
                        <td> 
                            <a href="{{ url('/admin/host-details/'.$guest['_id']) }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                            <a href="{{ url('/admin/host-delete/'.$guest['_id']) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a> 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <script>
    $(function() {
        $('#toggle-two').bootstrapToggle({
        on: 'Enabled',
        off: 'Disabled'
        });
    })
    </script>
@endsection