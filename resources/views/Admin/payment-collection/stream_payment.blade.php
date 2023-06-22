@extends('admin_layout.master')
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> -->
              {{ Breadcrumbs::render('stream-payment') }}
            </ol> 
          </div>
        </div>
      </div>
</div>
<div class="container-fluid">
<div class="card">
            <div class="card-header">
            <h3 class="card-title"><strong>Stream Payments List</strong></h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                            <!-- <input type="text" name="table_search" class="table_search form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default searchBtn">
                                <i class="fas fa-search"></i>
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="hosts-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Sr. no</th>
                            <th>Host name</th>
                            <th>Host unique id</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Created at</th>
                            <th>View</th>
                        </tr>
                    </thead>
                 
                    <tbody id="table-body">
                      <?php $count = 0; ?>
        @foreach($stream_data as $data)
        <?php $count++ ?>
                    <tr>
                           <td><b>{{ $count }}</b></td>
                           <td><b>{{ $data[0]->first_name ?? '' }}</b></td>
                           <td><b>{{ $data[0]->unique_id ?? '' }}</b></td>  
                           <td class="text-uppercase text-info"><b>{{ $data[0]['appoinments'][0]->duration_in_minutes ?? 0 }} minutes</b></td>
                           <td><span class="badge badge-success"> succesfull</span></td> 
                           <?php  $payments =  $data[0]['streampayment'][0]->total-$data[0]['streampayment'][0]->stripe_charges;  ?>
                           <td><b>${{ number_format($payments,2) ?? '' }}</b></td>
                           <?php 
                            $newDate = date("M/d/Y h:i A", strtotime($data[0]['streampayment'][0]['created_at'])); 
                            ?>
                           <td> {{$newDate ?? '' }}</td>
                           <td>
                                <a href="{{ url('admin/stream-payments') }}/{{ $data[0]->unique_id }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                           </td>
                    </tr>
        @endforeach                     
                    </tbody>
                </table>
            </div>
        </div>
</div>
<!-- <script>
        $(document).ready(function() {
            $('.searchBtn').on('click', function() {
                var search = $('.table_search').val();
                var streamPayment = 'Users';

                // Send AJAX request to server-side endpoint
                $.ajax({
                url: '/admin/search',
                type: 'POST',
                data: {
                    search:search ,
                    streamPayment:streamPayment,
                     _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        console.log(response);
                        var stream_payments = response.data;
                        console.warn(stream_payments);
                        console.log(stream_payments.length);
                        var tableBody = $('#table-body');
                        tableBody.html('');
                        for(var i = 0; i < stream_payments.length; i++) {
                            var data = stream_payments[i];
                            var row = '<tr>' +
                                '<td><b>' + (i+1) + '</b></td>' +
                                '<td><b>' + (data.first_name ?? '') + '</b></td>' +
                                '<td><b>' + (data.unique_id ?? '') + '</b></td>' +
                                '<td class="text-uppercase text-info"><b>' + (data['appoinments'].duration_in_minutes ?? 0) + ' minutes</b></td>' +
                                '<td><span class="badge badge-success"> succesfull</span></td>' +
                                '<td><b>$' + (data['streampayment'].total ?? '') + '</b></td>' +
                                '<td>' + (data['streampayment'].created_at ?? '') + '</td>' +
                                '<td><a href="' + baseUrl + '/admin/stream-payments/' + data.unique_id + '" class="btn btn-info"><i class="fa fa-eye"></i></a></td>' +
                                '</tr>';
                            tableBody.append(row);
                        };
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