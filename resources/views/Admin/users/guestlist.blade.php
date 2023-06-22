@extends('admin_layout.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('guest-list') }}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Total Guests : {{ count($guests) }}</b></h3>
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
                <table id="hosts-table" class="table table-hover text-nowrap">
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
                            if(isset($guest['first_name'])){
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
                            $dateInLocal = date("M/d/Y (h:i) A", $time);
                        ?>
                        <td> {{ $dateInLocal }} </td>
                        <td> 
                            <!-- <a href="{{ url('/admin/guest-details/'.$guest['_id']) }}" class="btn btn-info"><i class="fa fa-edit "></i></a> -->
                            <button href="{{ url('/admin/guest-delete/'.$guest['_id']) }}" class="delete_guest btn btn-danger"> <i class="fa fa-trash "></i></button> 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div id="pagination">{!! $guests->links() !!}</div>
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
    <script>
     $('.delete_guest').click(function(e){
        e.preventDefault();
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Are you sure to delete this guest?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = link;
                        // console.log(link);
                      } 
                    });  
      });
     </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <!-- <script>
        $(document).ready(function() {
            $('.searchBtn').on('click', function() {
                var search = $('.table_search').val();
                var guestlist = 'Users';

                // Send AJAX request to server-side endpoint
                $.ajax({
                url: '/admin/search',
                type: 'POST',
                data: {
                    search:search ,
                    guestlist:guestlist,
                     _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        console.log(response);
                        console.warn(response.data.created_at);
                        var guest = response.data;
                         // console.log(hosts);
                        $("#hosts-table tbody").html('');
                        var tbody = $("#hosts-table tbody");
                        for(var i = 0; i < guest.length; i++) {
                            var guest = guest[i];
                            let timecreatedat = moment(guest.created_at).format("MM/DD/YYYY HH:mm");
                            // var dateTimeObj = new Date(guest.created_at);
                            // var dateInLocal = dateTimeObj.toLocaleString();
                            var actions = "<a href='/admin/guest-details/" + guest._id.$oid + "' class='btn btn-info'><i class='fa fa-edit'></i></a>";
                            actions += " <a href='/admin/host-delete/" + guest._id.$oid + "' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                            tbody.append("<tr class='hosttable'>" +
                                "<td><img src='" + (guest.profile_image_url || "{{ asset('Assets/images/default-avatar.jpg') }}") + "' alt='" + (guest.profile_image_name || 'default-image') + "' class='rounded-circle' width='65px'></td>" +
                                "<td>" + guest.first_name  + " ""</td>" +
                                "<td>" + guest.email + "</td>" +
                                "<td>" + timecreatedat + "</td>" +
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
@endsection