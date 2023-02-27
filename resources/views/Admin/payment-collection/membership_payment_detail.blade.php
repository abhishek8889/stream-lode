@extends('admin_layout.master')
@section('content')

            <div class="card-body table-responsive p-0">
                <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                    <h4>
                        <!-- // -->
                        <i class="fas fa-edit"></i> Membership Payment Detail Page 
                        @if($membership_payments_details['payment_status'] == 'succesfull' )
                        <div class="btn btn-success ml-2">{{ $membership_payments_details['payment_status'] }}</div>
                            @if($membership_payments_details['refund_status'] == 1)
                                <a class="btn btn-primary ml-2 disabled" href="#">Refunded</a>            
                            @else
                                <a class="btn btn-danger ml-2" href="{{ url('/admin/membership-payment-refund/'.$membership_payments_details['_id']) }}">Refund</a>            
                            @endif
                        @else
                        <div class="btn btn-danger ml-2">{{ $membership_payments_details['payment_status'] }}</div>
                        @endif
                        <small class="float-right">Date: {{ !empty($membership_payments_details['created_at'])?$membership_payments_details['created_at']:''; }}</small>
                    </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info mt-3">
                    <div class="col-sm-4 invoice-col">
                        <h5><b>User Details</b></h5>
                        <?php 
                            $host_name = $membership_payments_details->user['first_name'].' '.$membership_payments_details->user['last_name'];
                        ?>
                        <strong>{{ !empty($host_name)?$host_name:'';  }}</strong><br>
                        {{ !empty($membership_payments_details->user['email'])?$membership_payments_details->user['email']:''; }}<br>
                        {{ !empty($membership_payments_details->user['unique_id'])?'unique id : #'.$membership_payments_details->user['unique_id']:''; }}<br>

                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <h5><b>Membership Details</b></h5>
                    <div>
                        <strong>{{ !empty($membership_payments_details->membership_details['name'])?$membership_payments_details->membership_details['name']:''; }}</strong><br>
                        {{ !empty($membership_payments_details->membership_details['type'])?'Type : '.$membership_payments_details->membership_details['type']:''; }} <br>
                        {{ !empty($membership_payments_details->membership_details['interval'])?'Interval : '.$membership_payments_details->membership_details['interval']:''; }} <br>
                        <div class="py-2 text text-info">
                        {{ !empty($membership_payments_details->membership_details['description'])?$membership_payments_details->membership_details['description']:''; }}
                        </div>
                    </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $membership_payments_details['inovice_id'] }}</b><br>
                    <br>
                    <b>Order ID : </b> #{{ $membership_payments_details['order_id'] }} <br>
                    <b>Payment On : </b> {{ $membership_payments_details['created_at'] }} <br>
                    <div class="mt-1">
                    <b>Card : </b> <span class="text text-info font-weight-bold p-1"> {{ !empty($membership_payments_details->payments_method['brand'])?$membership_payments_details->payments_method['brand']:'';  }}</span> ends in <span>{{ !empty($membership_payments_details->payments_method['last_4'])?$membership_payments_details->payments_method['last_4']:''; }} </span>
                    </div>
                    </div>
                    <!-- /.col -->
                </div>
                </div>
                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="{{ asset('/AdminLTE-3.2.0/dist/img/credit/visa.png') }}" alt="Visa"> 
                        <img src="{{ asset('/AdminLTE-3.2.0/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                        <img src="{{ asset('/AdminLTE-3.2.0/dist/img/credit/american-express.png') }}" alt="American Express">
                        <img src="{{ asset('/AdminLTE-3.2.0/dist/img/credit/paypal2.png') }}" alt="Paypal">
                    </div>
                    <div class="col-6">
                    <p class="lead font-weight-bold">Amount</p>

                    <div class="table-responsive">
                        <table class="table">
                        <tbody><tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{ '$'.$membership_payments_details['membership_total_amount'] }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ isset($membership_payments_details['discount'])?'$'.$membership_payments_details['discount']:'$0'; }}</td>
                        </tr>
                        
                        <tr>
                            <th>Total:</th>
                            <td>{{ isset($membership_payments_details['payment_amount'])?'$'.$membership_payments_details['payment_amount']:'0'; }}</td>
                        </tr>
                        </tbody></table>
                    </div>
                    </div>
                    <!-- /.col -->
                </div>
                </div>
            </div>
       
@endsection