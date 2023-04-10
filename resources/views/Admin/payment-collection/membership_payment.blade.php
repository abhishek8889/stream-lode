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
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" id ="inputsearch">
                        <div class="input-group-append">
                            <button type="submit" id="searchbtn" class="btn btn-default">
                            <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
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

                    <?php
                    // echo '<pre>';
                    // print_r($membership_payments_list);
                    // echo '</pre>';
                    // die(); 
                        $membership_count = 0;
                    ?>
                   
                   
                    @forelse($membership_payments_list as $data)
                        <?php $membership_count++; ?>
                        <tr>
                           <td><b>{{ $membership_count }}</b></td>
                           <td><b>{{ $data->user['first_name'] . ' ' .$data->user['last_name'] }}</b></td>
                           <td><b>#{{ $data->user['unique_id'] }}</b></td>
                            <?php 
                                $membership_name = App\Models\MembershipTier::where('_id',$data->user['membership_id'])->get()->value('name');
                            ?>
                            
                           <td class="text-uppercase text-info"><b>{{ $membership_name }}</b></td>
                            @if($data['payment_status'] == 'succesfull')
                           <td><span class="badge badge-success"> {{ $data['payment_status'] }}</span></td>
                           @else
                           <td><span class="badge badge-danger"> {{ $data['payment_status'] }}</span></td>  
                           @endif

                           <td><b>${{ $data['total'] ?? $data['membership_total_amount'] }}</b></td>
                          <td>{{ $data['created_at'] }}</td>
                           <td>
                                <a href="{{ url('/admin/membership-payment-details/'.$data->user['unique_id']) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                           </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <b>No data found</b>
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
@endsection
