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
<?php
if($_GET){
    $count = ($_GET['page']-1)*10;
}else{
    $count = 0;
} 
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
                        <?php 
                          
                        ?>
                        <small class="float-right">Date: {{ date('M/d/Y h:i a', strtotime($sp->created_at)) ?? '' }}</small> 
                    </h4>
                    </div>
            </div>
            <div class="row invoice-info mt-3">
                    
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <h5><b>User Details</b></h5>
                            <div>
                                    User Name : {{ $sp->appoinments['guest_name'] ?? ''}} <br>
                            </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                                <b>Payment On : </b>{{ date('M/d/Y h:i a', strtotime($sp->created_at)) ?? '' }} <br>
                                <b>Duration: </b>{{ $sp->appoinments['duration_in_minutes'] ?? '' }} minutes <br> 
                                 <b>Payment id:</b>{{ $sp->payment_id ?? '' }}    
                    </div>
                    <div class="col-4">
                    <p class="lead font-weight-bold">Amount</p>
                    <div class="table-responsive">
                        <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td class="text-right">${{ $sp->subtotal ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td class="text-right">${{ $sp->discount_amount ?? 0 }}</td>
                        </tr> 
                        @if(isset($sp->host_stream_service_charge))
                        <tr>
                            <th  style="width:100%">Stream Service Charges:</th>
                            <td class="text-right">-${{ $sp->host_stream_service_charge ?? 0 }}</td>
                        </tr> 
                        @endif
                        <tr>
                            <th  style="width:100%">Stripe Service Charges:</th>
                            <td class="text-right">-${{ number_format($sp->stripe_charges,2) ?? 0 }}</td>
                        </tr>
                        <tr>
                            <?php  
                            $total =  $sp->total-$sp->stripe_charges;
                            ?>
                            <th>Total:</th>
                            <td class="text-right">${{ number_format($total,2) ?? 0 }}</td>
                            <?php array_push($data,$total); ?>
                        </tr>
                        </tbody></table>
                    </div>
                    </div>
            </div>
        </div>
      
</div>
@endforeach
    <div >
    {{ $stream_payments->links() }}
    </div>

@endsection