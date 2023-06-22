@extends('admin_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hosts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> -->
              {{ Breadcrumbs::render('host-list') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b class="total-host">Total Hosts : {{ count($hosts) }}</b></h3>
                    <div class="card-tools">
                        <!-- Search panel start here -->
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <!-- <input type="text" name="table_search" class="table_search form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default searchBtn">
                                <i class="fas fa-search"></i>
                                </button>
                            </div> -->
                        </div>
                        <!-- End search panel here! -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="hosts-table">
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
                    
                    <tr class="hosttable host{{ $host['_id'] }}">
                        <td><b>#{{ $host['unique_id'] }}</b></td>
                        <td>
                            @if(isset($host['profile_image_name']) || !empty($host['profile_image_name']))
                            <img src="{{ asset('Assets/images/user-profile-images/'.$host['profile_image_name']) }}" alt="{{ $host['profile_image_name'] }}" class="rounded-circle" width="65px">
                            @else
                            <img src="{{ asset('Assets/images/default-avatar.jpg') }}" alt="default-image" class="rounded-circle" width="65px">
                            @endif
                        </td>

                        <td>{{ $host['first_name'].' '.$host['last_name'] }} </td>


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
                            $dateInLocal = date("M/d/Y (h:i A) ", $time);
                        ?>
                        <td> {{ $dateInLocal }} </td>
                        <td> 
                            <a href="{{ url('/admin/host-details/'.$host['unique_id']) }}" class="btn btn-info"><i class="fa fa-edit "></i><span class="badge badge-danger navbar-badge">{{ count($host['adminmessage']) }}</span></a>
                            <button href="{{ url('/admin/host-delete/'.$host['unique_id']) }}" class="delete_host btn btn-danger"> <i class="fa fa-trash "></i></button> 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div id="pagination">{!! $hosts->links() !!}</div>
                
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
    <!-- <script>
        $(document).ready(function() {
            $('.table_search').on('keyup', function() {
                var search = $('.table_search').val();
                var hostlist = 'Users';

                // Send AJAX request to server-side endpoint
                $.ajax({
                url: '/admin/search',
                type: 'POST',
                data: {
                    search:search ,
                    hostlist:hostlist,
                     _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        console.log(response);
                $('#pagination').html(response.links);
                var hosts = response.data;
                // console.log(hosts);
                $("#hosts-table tbody").html('');

                var tbody = $("#hosts-table tbody");
                $('.total-host').html('').html('Total Hosts : '+hosts.length);
                for(var i = 0; i < hosts.length; i++) {
                    var host = hosts[i];
                    var membership_name = host.membership_tier['name'] || "No membership";
                    var visibility = host.public_visibility == 1 ? "<span class='badge badge-pill badge-success'>public</span>" : "<span class='badge badge-pill badge-danger'>private</span>";
                    var dateTimeObj = new Date(host.created_at);
                    var dateInLocal = dateTimeObj.toLocaleString();
                    var actions = "<a href='/admin/host-details/" + host.unique_id + "' class='btn btn-info'><i class='fa fa-edit'></i><span class='badge badge-danger navbar-badge'>" + host.adminmessage.length + "</span></a>";
                    actions += " <a href='/admin/host-delete/" + host.unique_id + "' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                    tbody.append("<tr class='hosttable host" + host._id + "'>" +
                        "<td><b>#"+ host.unique_id + "</b></td>" +
                        "<td><img src='" + (host.profile_image_url || "{{ asset('Assets/images/default-avatar.jpg') }}") + "' alt='" + (host.profile_image_name || 'default-image') + "' class='rounded-circle' width='65px'></td>" +
                        "<td>" + host.first_name + " " + host.last_name + "</td>" +
                        "<td>" + host.email + "</td>" +
                        "<td>" + membership_name + "</td>" +
                        "<td>" + visibility + "</td>" +
                        "<td>" + dateInLocal + "</td>" +
                        "<td>" + actions + "</td>" +
                        "</tr>");
                }
            },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response from server
                    console.log(textStatus, errorThrown);
                }
                });
            });
        });

    </script> -->
    <script>
        $('.delete_host').click(function(e){
        e.preventDefault();
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Are you sure to delete this host?',
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
     </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection