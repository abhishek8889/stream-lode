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
              {{ Breadcrumbs::render('membership-payment-list') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title"><strong>Membership Payment List</strong></h3>
                <div class="card-tools">
                    <!-- Search   -->
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
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="hosts-table">
                    <thead>
                        <tr>
                            <th>Sr. no</th>
                            <th>Host name</th>
                            <th>Host unique id</th>
                            <th>Membership name</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Created at</th>
                            <th>View</th>
                        </tr>
                    </thead>
                 
                    <tbody>

                    <?php $membership_count= 0; ?>
                    @forelse($membership_payments_list as $data)
                        <?php $membership_count++; ?>
                        @if(isset($data[0]))
                        <tr>
                           <td><b>{{ $membership_count }}</b></td>
                           <td><b>{{ $data[0]->first_name . ' ' .$data[0]->last_name }}</b></td>
                           <td><b>#{{ $data[0]->unique_id }}</b></td>
                            <?php 
                                $membership_name = App\Models\MembershipTier::where('_id',$data[0]->membership_id)->get()->value('name');
                            ?>
                            
                           <td class="text-uppercase text-info"><b>{{ $membership_name }}</b></td>
                            @if($data[0]['payments'][0]['payment_status'] == 'succesfull')
                           <td><span class="badge badge-success"> successful</span></td>
                           @else
                           <td><span class="badge badge-danger"> {{ $data[0]['payments'][0]['payment_status'] }}</span></td>  
                           @endif
                           <!-- New code for count total ammount of membership -->
                            @php  $datanew = array(); @endphp
                            @for ($i=0; $i< count($data[0]['payments']); $i++)
                                @php 
                                    $datanew[] = $data[0]['payments'][$i]['total'];
                                @endphp
                            @endfor
                            <td><b> ${{array_sum($datanew) ?? ''}} </b></td>
                           <!-- <td><b>${{ $data[0]['payments'][0]['total'] ?? $data[0]['payments'][0]['membership_total_amount'] }}</b></td> -->
                            <?php 
                            $newDate = date("M/d/Y h:i A", strtotime($data[0]['payments'][0]['created_at'])); 
                            ?>
                          <td>{{ $newDate }}</td>
                           <td>
                                <a href="{{ url('/admin/membership-payment-details/'.$data[0]->unique_id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                           </td>
                        </tr>  
                           @endif
                           
                        @empty
                        <tr>
                            <td>
                               <h6>No Payments Data Found</h6> 
                            </td>
                        </tr>
                   
                    @endforelse
                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    $(document).ready(function(){
        $('#searchbtn').click(function(){
            val = $('#inputsearch').val();
            $.ajax({
                method: 'post',
                url: '{{ route('paymentsearch') }}',
                data: { val:val , _token: '{{csrf_token()}}' },
                dataType: 'json',
                success: function(response){
                    $.each(response, function(key,value){
                    console.log(value.payments);
                    // if(value.payments['payment_status'] = 'succesfull'){
                    //     console.log('done payment');
                    // }else{
                    //     console.log('not done payments');
                    // }
                    });
                }
            });
        })
    });
</script> -->
<script>
        $(document).ready(function() {
            $('.table_search').on('keyup', function() {
                var search = $('.table_search').val();
                var paymentList = 'Users';
               
                // Send AJAX request to server-side endpoint
                $.ajax({
                url: '/admin/search',
                type: 'POST',
                data: {
                    search:search ,
                    paymentList:paymentList,
                     _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        // console.log(response);
                       
                // $('#pagination').html(response.links);
                var membership_payments_list = response;
                var tbody = $("#hosts-table tbody");
                tbody.html(''); // clear existing table rows
                console.log(membership_payments_list.length);
                for(var i = 0; i < membership_payments_list.length; i++) {
                    var data = membership_payments_list[i];
                    var membership_name = data.membership_tier ? data.membership_tier.name : "No membership";
                    var payment_status = data.payments.length > 0 ? data.payments[0].payment_status : "No payments";
                    var payment_status_html = "<span class='" + (payment_status === "succesfull" ? "badge badge-success" : "badge badge-danger") + "'>" + payment_status + "</span>";
                    var total_amount = data.payments.reduce((total, payment) => total + parseFloat(payment.total), 0);
                    var timecreatedat = moment(data.created_at).format("MM/DD/YYYY HH:mm");
                    var view_link = "<a href='/admin/membership-payment-details/" + data.unique_id + "' class='btn btn-info'><i class='fa fa-eye'></i></a>";
                    
                    tbody.append("<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td>" + data.first_name + " " + data.last_name + "</td>" +
                        "<td><b>#"+ data.unique_id + "</b></td>" +
                        "<td>" + membership_name + "</td>" +
                        "<td>" + payment_status_html + "</td>" +
                        "<td>$" + total_amount.toFixed(2) + "</td>" +
                        "<td>" + timecreatedat + "</td>" +
                        "<td> <b>" + view_link + "</b></td>" +
                        "</tr>");
                }

            },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response from server
                    // console.log(textStatus, errorThrown);
                }
                });
            });
        });

    </script>
@endsection
