@extends('host_layout.master')
@section('content')

<section class="content-header">
<div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Stream Payments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('host-stream-payment') }}
            </ol>
          </div>
        </div>
</section>
<?php $count = 0; 
$data = array();
?>
@foreach($stream_payments as $sp)
<?php $count++; ?>
<div class="container-fluid">
    <div class="invoice p-3 mb-3">
            <div class="row">
                    <div class="col-12">
                    <h4>
                        <small>#{{$count}}. </small>         
                        <small class="float-right">Date: {{ $sp->created_at }}</small>
                    </h4>
                    </div>
            </div>
            <div class="row invoice-info mt-3">
                    
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <h5><b>User Details</b></h5>
                            <div>
                                    User Name : {{ $sp->appoinments['guest_name'] }} <br>
                                    User Email : {{ $sp->appoinments['guest_email'] }} <br>
                            </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                                <b>stripe_payment_intent: #{{ $sp->stripe_payment_intent }}</b><br>
                                <br>
                                <b>Payment On : </b>{{ $sp->created_at }} <br>
                                <b>Duration: </b>{{ $sp->appoinments['duration_in_minutes'] }} minutes    
                    </div>
                    <div class="col-4">
                    <p class="lead font-weight-bold">Amount</p>
                    <div class="table-responsive">
                        <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td class="text-right">${{ $sp->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td class="text-right">${{ $sp->discount_amount ?? 0 }}</td>
                        </tr> 
                        <tr>
                            <th>Total:</th>
                            <td class="text-right">${{ $sp->total }}</td>
                            <?php array_push($data,$sp->total); ?>
                        </tr>
                        </tbody></table>
                    </div>
                    </div>
            </div>
        </div>
      
</div>
@endforeach
<div class="container-fluid text-right">
    <div class="invoice p-3 mb-3">
        <div class="row">
        <div class="col-md-8">

        </div>
        <div class="col-md-4 d-flex justify-content-between">
            <tr>
                <td>
                    <h3>Total:</h3>
                </td>
                <td>
                    <h3>$<?php print_r(array_sum($data)); ?></h3>
                </td>
            </tr>
        </div>
    </div>
           
            </div>
        </div>

@endsection