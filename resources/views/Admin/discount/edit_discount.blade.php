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
              {{ Breadcrumbs::render('discount-Update') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
<section class="content">
<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title"><strong>Add Discount Coupon</strong></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form action="{{ route('create-discount') }}" method="POST"  class="form-horizontal">
        @csrf
        <div class="row">
            <div class="card-body col-md-6">
                <div class="form-group row">
                    <input type="hidden" name="id" value="{{ $coupondata['id'] ?? '' }}">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ $coupondata['coupon_name'] ?? '' }}">
                        @error('name')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="couponCode" class="col-sm-3 col-form-label">Coupon Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="couponCode" placeholder="" name="coupon_code" value="{{ $coupondata['coupon_code'] ?? '' }}" >
                        @error('coupon_code')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="discount_type" class="col-sm-3 col-form-label">Discount Type</label>
                    <div class="col-sm-9">
                        <select name="discount_type" id="discount_type" class="form-control">
                            <option value="percent_off" <?php if($coupondata['discount_type']=='percent_off'){ echo 'selected'; } ?> >Percentage Off</option>
                            <!-- <option value="amount_off" <?php if($coupondata['discount_type']=='amount_off'){ echo 'selected'; } ?> >Amount Off</option> -->
                        </select>
                        @error('percent_off')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        @error('amount_off')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="prcent_amt">
                    <label for="perentage_off" class="col-sm-3 col-form-label">Percentage Off</label>
                    <div class="col-sm-9">
                        <input type="text" id="perentage_off" class="form-control" name="percent_off" placeholder="Enter percentage" value="{{ $coupondata['percent_off'] ?? '' }}"/>  
                    </div>
                </div>
                <!-- <div class="form-group row" id="discount_amt">
                    <label for="amount_off" class="col-sm-3 col-form-label">Amount Off</label>
                    <div class="col-sm-9">
                        <input type="text" id="amount_off" class="form-control" name="amount_off" placeholder="Enter amount" value="{{ $coupondata['amount_off'] ?? '' }}"/>
                    </div>
                </div>
                <div class="form-group row" id="currency_box">
                    <label for="currency" class="col-sm-3 col-form-label">Currency</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="currency" name="currency">
                            <option value="usd"<?php if($coupondata['currency'] = 'usd'){ echo 'selected'; } ?> >USD($)</option>
                        </select>
                        @error('duration_in_months')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div> -->
                <!-- currency code -->
                <div class="form-group row">
                    <label for="duration" class="col-sm-3 col-form-label">Duration</label>
                    <div class="col-sm-9">
                        <select id="duration" class="form-control" id="duration" name="duration">
                            <option <?php if($coupondata['duration'] == 'once'){ echo 'selected'; } ?> value="once">Once</option>
                            <option <?php if($coupondata['duration'] == 'repeating'){ echo 'selected'; } ?> value="repeating">Repeating</option>
                            <option <?php if($coupondata['duration'] == 'forever'){ echo 'selected'; } ?> value="forever">Forever</option>
                        </select>
                        @error('duration_in_months')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="duration_in_month">
                    <label for="duration" class="col-sm-3 col-form-label">Duration in months</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="duration_month" name="duration_in_months" placeholder="Enter duration in month" value="{{ $coupondata['duration_in_months'] ?? '' }}"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Coupon</button>
        </div>
    </form>
</div>
</section>
<script>
   
    $(document).ready(function(){

        $("#duration_in_month").hide();
        $("#discount_amt").hide();
        $("#currency_box").hide();

        $("#name").on('change',function(){
           let random_string = randomString(4, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
           let name = $(this).val().toUpperCase();
           let half_name = name.substr(0, 4);
           let coupon_code = '#'+half_name+'-'+random_string;
           $("#couponCode").val(coupon_code);
        });

        $(document).ready(function(){ 
            if($("#discount_type").val() == 'amount_off'){
                $("#discount_amt").show();
                $("#currency_box").show();
                $("#prcent_amt").hide();
                $("#perentage_off").val(null);
           }else{
                $("#prcent_amt").show();
                $("#currency_box").hide();
                $("#amount_off").val(null);
                $("#discount_amt").hide();
           }  
        })
        $("#discount_type").on('change',function(){
           if($(this).val() == 'amount_off'){
                $("#discount_amt").show();
                $("#currency_box").show();
                $("#prcent_amt").hide();
                $("#perentage_off").val(null);
           }else{
                $("#prcent_amt").show();
                $("#currency_box").hide();
                $("#amount_off").val(null);
                $("#discount_amt").hide();
           }
        });

        $(document).ready(function(){
            if($('#duration').val() == 'repeating'){
                $("#duration_in_month").show();
            }else{
                $("#duration_month").val(0);
                $("#duration_in_month").hide(); 
            }
            $('#duration').on('change',function(){
                if($('#duration').val() == 'repeating'){
                $("#duration_in_month").show();
            }else{
                $("#duration_month").val(0);
                $("#duration_in_month").hide(); 
            }
            })
        });
        
    });
    function randomString(length, chars) {
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
            return result;
        }
       
</script>

@endsection