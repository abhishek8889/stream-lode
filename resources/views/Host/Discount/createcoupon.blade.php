@extends('host_layout.master')
@section('content')

<div class="container-fluid">
<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Coupons</h3>
              </div>
              <div class="col-6">
              <form action="{{ route('coupons-createproc',['id'=>Auth::user()->unique_id]) }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" name="id" value="{{ $coupon_data->_id ?? '' }}">
                    <label for="couponname">Coupon Name</label>
                    <input type="text" class="form-control" id="couponname" name="coupon_name" value="{{ $coupon_data['coupon_name'] ?? '' }}">
                  </div>
                  @error('coupon_name')
                            <div class="text text-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="couponslug">Coupon code</label>
                    <input type="text" class="form-control" id="couponcode" name="coupon_code" value="{{ $coupon_data['coupon_code'] ?? ''  }}">
                  </div>
                  @error('coupon_code')
                            <div class="text text-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="coupontype">Percentage Off</label>
                    <input type="text" class="form-control" id="coupontype" name="percentage_off" value="{{ $coupon_data['percentage_off'] ?? '' }}" >
                  </div>
                  @error('percentage_off')
                            <div class="text text-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                        <label for="couponduration">Duration</label>
                        <select class="form-control" name="duration" id="couponduration">
                          <option @if($coupon_data) @if($coupon_data->duration == 'once') selected @endif @endif >Once</option>
                          <option @if($coupon_data) @if($coupon_data->duration == 'Repeating') selected @endif @endif>Repeating</option>
                          <option @if($coupon_data) @if($coupon_data->duration == 'Forever') selected @endif @endif>Forever</option>
                        </select>
                    </div>
                  @error('duration')
                            <div class="text text-danger">{{ $message }}</div>
                  @enderror
                    <div class="form-group" id="durationmonth">
                    <label for="durationtimes">Duration times</label>
                    <input type="text" class="form-control" id="durationtimes" name="duration_times" value=" {{ $coupon_data['duration_times'] ?? ''}} ">
                  </div>
                  @error('duration_times')
                            <div class="text text-danger">{{ $message }}</div>
                  @enderror
                <div class="">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>
          </div>
</div>
</div>
<script>
  $(document).ready(function(){
    if($('#couponduration').val() == 'Repeating'){
        $('#durationmonth').show();
      }
      else{
        $('#durationmonth').hide();
        $('#durationtimes').val('');
      }  
    $('#couponduration').change(function(){
      if($('#couponduration').val() == 'Repeating'){
        $('#durationmonth').show();
      }
      else{
        $('#durationmonth').hide();
        $('#durationtimes').val('');
      }
    });
  });
  $("#couponname").change(function(){
    let random_string = randomString(4, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
   let name = $(this).val().toUpperCase();
   let half_name = name.substr(0, 4);
   let coupon_code = '#'+half_name+'-'+random_string;
   $("#couponcode").val(coupon_code);
  console.log(coupon_code);
  });
  function randomString(length, chars) {
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
            return result;
        }
</script>
@endsection