@extends('admin_layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Total Hosts : {{ count($hosts) }}</b></h3>
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
                        <th>Unique ID</th>
                        <th>Profile</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Membership</th>
                        <th>Visibillity</th>
                        <th>Date of join</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- foreach  -->
                    @foreach($hosts as $host)
                    
                    <tr>
                        <td><b>#{{ $host['unique_id'] }}</b></td>
                        <td>
                            @if(isset($host['profile_image_url']) || !empty($host['profile_image_url']))
                            <img src="{{ $host['profile_image_url'] }}" alt="{{ $host['profile_image_name'] }}" class="rounded-circle" width="65px">
                            @else
                            <img src="{{ asset('Assets/images/default-avatar.jpg') }}" alt="default-image" class="rounded-circle" width="65px">
                            @endif
                        </td>

                        <td>{{ $host['first_name'].' '.$host['last_name'] }}</td>

                        <td>{{ $host['email'] }}</td>
                    
                        @if(isset($host['membership_id']) || !empty($host['membership_id']))
                        <?php 
                            $membership_name = App\Models\MembershipTier::where('_id',$host['membership_id'])->get()->value('name');
                        ?>
                        <td>{{ $membership_name }}</td>
                        @else
                        <td><span class="badge badge-pill badge-secondary">No membership</span></td>
                        @endif

                        @if($host['public_visibility'] == 1)
                            <td><span class="badge badge-pill badge-success">public</span></td>
                        @else
                            <td><span class="badge badge-pill badge-danger">private</span></td>
                        @endif
                        <?php 
                            $dateTimeObj = $host['created_at']->toDateTime();
                            $timeString = $dateTimeObj->format(DATE_RSS);
                            $time = strtotime($timeString.' UTC');
                            $dateInLocal = date("M/d/Y (H:i)", $time);
                        ?>
                        <td> {{ $dateInLocal }} </td>
                        <td> 
                            <a href="{{ url('/admin/host-details/'.$host['unique_id']) }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                            <a href="{{ url('/admin/host-delete/'.$host['unique_id']) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a> 
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