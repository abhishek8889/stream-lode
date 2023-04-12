@extends('admin_layout.master')
@section('content')
<?php $count = 0; ?>
@foreach($stream_data as $sd)
<?php $count++; ?>
        <div class="invoice p-3 mb-3">
                <!-- title row -->
            <div class="row">
                    <div class="col-12">
                    <h4>
                        <small>#{{ $count }}. </small>         
                        <small class="float-right">Date: {{ $sd->created_at }}</small>
                    </h4>
                    </div>
            </div>
            <div class="row invoice-info mt-3">
                    <div class="col-sm-4 invoice-col">
                        <h5><b>Host Details</b></h5>
                        <strong>{{ $sd['host']->first_name ?? '' }} {{ $sd['host']->last_name ?? '' }}</strong><br>
                        {{$sd['host']->email ?? ''}}<br>
                        unique id : #{{$sd['host']->unique_id ?? ''}}<br>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <h5><b>User Details</b></h5>
                            <div>
                                
                                    User Name : {{ $sd['appoinments']->guest_name }} <br>
                                    User Email : {{ $sd['appoinments']->guest_email }} <br>
                            </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                                <b>stripe_payment_intent: #{{ $sd->stripe_payment_intent ?? ''}}</b><br>
                                <br>
                                <b>Payment On : </b>{{ $sd->created_at }} <br>
                                <b>Duration: </b>{{ $sd['appoinments']->duration_in_minutes }} minutes    
                    </div>
            </div>
        </div>
            <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="http://127.0.0.1:8000/AdminLTE-3.2.0/dist/img/credit/visa.png" alt="Visa"> 
                        <img src="http://127.0.0.1:8000/AdminLTE-3.2.0/dist/img/credit/mastercard.png" alt="Mastercard">
                        <img src="http://127.0.0.1:8000/AdminLTE-3.2.0/dist/img/credit/american-express.png" alt="American Express">
                        <img src="http://127.0.0.1:8000/AdminLTE-3.2.0/dist/img/credit/paypal2.png" alt="Paypal">
                    </div>
                    <div class="col-4">
                    <p class="lead font-weight-bold">Amount</p>

                    <div class="table-responsive">
                        <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td class="text-right">${{ $sd->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td class="text-right">${{ $sd->discount_amount ?? 0 }}</td>
                        </tr> 
                        <tr>
                            <th>Total:</th>
                            <td class="text-right">${{ $sd->total }}</td>
                        </tr>
                        </tbody></table>
                    </div>
                    </div>
                </div>
    @endforeach
@endsection