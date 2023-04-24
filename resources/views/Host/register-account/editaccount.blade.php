@extends('host_layout.master')
@section('content')
<style>
  .copy-text {
    width:85%;
    margin-inline:40px;
	position: relative;
	/* padding: 10px; */
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 10px;
	display: flex;
}
.copy-text input.text {
	padding: 10px;
	font-size: 18px;
  width:100%;
	color: #555;
	border: none;
	outline: none;
}
.copy-text button {
	padding: 10px;
	background: #5784f5;
	color: #fff;
	font-size: 18px;
	border: none;
	outline: none;
	border-radius: 10px;
	cursor: pointer;
}

.copy-text button:active {
	background: #809ce2;
}
.copy-text button:before {
	content: "Copied";
	position: absolute;
	top: -45px;
	right: 0px;
	background: #5c81dc;
	padding: 8px 10px;
	border-radius: 20px;
	font-size: 15px;
	display: none;
}
.copy-text button:after {
	content: "";
	position: absolute;
	top: -20px;
	right: 25px;
	width: 10px;
	height: 10px;
	background: #5c81dc;
	transform: rotate(45deg);
	display: none;
}
.copy-text.active button:before,
.copy-text.active button:after {
	display: block;
}
.link-text{
  text-align: center;
  padding: 16px;
  font-size: 20px;
  font-weight: 10px;
  font-style: initial;
}
#send-link{
  cursor:move;
}

/* loader */
#overlayer{
display: none;
  width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99;
    background: #e9edf3e0;
    top: 0px;
    height: 100vh;
}
.loader{
  width: 60px;
    height: 60px;
    margin: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    transform: rotate(45deg) translate3d(0,0,0);
    animation: loader 1.2s infinite ease-in-out;
    top: 50%;
    left: calc(50% - 160px);
    transform: translate(-50%, -50%);
}
.loader span{
    background: #EE4040;
    width: 30px;
    height: 30px;
    display: block;
    position: absolute;
    animation: loaderBlock 1.2s infinite ease-in-out both;
}
.loader span:nth-child(1){
    top: 0;
    left: 0;
}
.loader span:nth-child(2){
    top: 0;
    right: 0;
    animation: loaderBlockInverse 1.2s infinite ease-in-out both;
}
.loader span:nth-child(3){
    bottom: 0;
    left: 0;
    animation: loaderBlockInverse 1.2s infinite ease-in-out both;
}
.loader span:nth-child(4){
    bottom: 0;
    right: 0;
}
@keyframes loader{
    0%, 10%, 100% {
        width: 60px;
        height: 60px;
    }
    65% {
        width: 120px;
        height: 120px;
    }
}
@keyframes loaderBlock{
    0%, 30% { transform: rotate(0); }
        55% { background: #F37272; }
    100% { transform: rotate(90deg); }
}
@keyframes loaderBlockInverse {
    0%, 20% { transform: rotate(0); }
        55% { background: #F37272; }
    100% { transform: rotate(-90deg); }
}

</style>
<div id="overlayer">
<div class="loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
</div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Your Register Account</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('edit-account') }}
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="card card-info">
                <form action="{{ url('register-host-stripe-account') }}" method="POST">
                    <div class="card-body">
                        <div class="col-md-10" >
                            <div class="userform">
                                @csrf
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                <h5>Personal Details :</h5>
                                <div class="peronal_details">
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" value="{{ $AccountDetails->first_name ?? '' }}">
                                            @error('first_name')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" value="{{ $AccountDetails->last_name ?? '' }}">
                                            @error('last_name')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="dob" class="col-sm-3 col-form-label">Date of birth (DOB)</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your date of birth" value="{{ $AccountDetails->dob ?? ''}}">
                                            @error('dob')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Personal contact   -->
                                    <div class="form-group row">
                                        <label for="personal_contact" class="col-sm-3 col-form-label">Personal contact</label>
                                        <div class="col-sm-9">
                                            <input type="number" min="0" class="form-control" id="personal_contact" name="personal_contact" placeholder="Enter your personal number" value="{{ $AccountDetails->personal_contact ?? ''}}">
                                            @error('personal_contact')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city name" value="{{ $AccountDetails->city ?? ''}}">
                                            @error('city')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="line1" class="col-sm-3 col-form-label">Street/Line</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="line1" name="line1" placeholder="Enter your street name" value="{{ $AccountDetails->line1 ?? ''}}">
                                            @error('city')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="state" class="col-sm-3 col-form-label">State</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state name" value="{{ $AccountDetails->state ?? ''}}">
                                            @error('state')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="postal_code" class="col-sm-3 col-form-label">Postal code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter your postal code" value="{{ $AccountDetails->postal_code ?? ''}}">
                                            @error('postal_code')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Social Security number (SSN) -->
                                    <div class="form-group row">
                                        <label for="ssn" class="col-sm-3 col-form-label">Social Security number (SSN)</label>
                                        <div class="col-sm-9">
                                            <input type="number"  min="0"  class="form-control" id="ssn" name="ssn" placeholder="Enter your SSN Number" value="{{ $AccountDetails->ssn ?? ''}}">
                                            @error('ssn')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--  Business Information -->
                                <h5>Business Details :</h5>
                                <div class="business-details">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" value="{{ $AccountDetails->email ?? ''}}">
                                            @error('email')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="business_phone" class="col-sm-3 col-form-label">Business phone number</label>
                                        <div class="col-sm-9">
                                            <input type="number" min="0"  class="form-control" id="business_phone" name="business_phone" placeholder="Enter Your Business Contact Number" value="{{ $AccountDetails->business_phone ?? ''}}">
                                            @error('business_phone')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- |||||||||||||||||  MCC  ||||||||||||||| -->
                                    <div class="form-group row">
                                        <label for="mcc" class="col-sm-3 col-form-label">Merchant category codes (MCC)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mcc" name="mcc" placeholder="Enter your Merchant category codes (MCC)" value="{{ $AccountDetails->mcc ?? ''}}">
                                            @error('mcc')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select name="country" id="country" class="form-control">
                                                <option value="{{ $AccountDetails->country ?? ''}}">{{ $AccountDetails->country ?? ''}}</option>
                                            </select>
                                            @error('country')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Bank Details:  -->
                                <h5>Bank Details :</h5>
                                <div class="bank-details">
                                    <div class="form-group row">
                                        <label for="account_holder_name" class="col-sm-3 col-form-label">Account Holder Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" placeholder="Account Holder Name" value="{{ $AccountDetails->account_holder_name ?? ''}}">
                                            @error('account_holder_name')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank_acc_number" class="col-sm-3 col-form-label">Bank account number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="bank_acc_number" name="bank_acc_number" placeholder="Bank Account Number" value="{{ $AccountDetails->bank_acc_number ?? ''}}">
                                            @error('bank_acc_number')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="acc_routing_num" class="col-sm-3 col-form-label">Account routing number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="acc_routing_num" name="acc_routing_num" placeholder="Account routing number" value="{{ $AccountDetails->acc_routing_num ?? ''}}">
                                            @error('acc_routing_num')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank_acc_region" class="col-sm-3 col-form-label">Bank account region</label>
                                        <div class="col-sm-9">
                                            <select name="bank_acc_region" id="bank_acc_region" class="form-control">
                                                <option value="{{ $AccountDetails->bank_acc_region ?? ''}}">{{ $AccountDetails->bank_acc_region ?? ''}}</option>
                                            </select>
                                            @error('bank_acc_region')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="region_currency" class="col-sm-3 col-form-label">Region currency</label>
                                        <div class="col-sm-9">
                                            <select name="region_currency" id="region_currency" class="form-control">
                                                <option value="{{ $AccountDetails->region_currency ?? ''}}">{{ $AccountDetails->region_currency ?? ''}}</option>
                                            </select>
                                            @error('region_currency')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Update</button>
                        <button type="button" class="btn btn-danger delete_account" data-id="{{ $AccountDetails->_id ?? '' }}"> Delete Your Account</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function (){
            
            $('.delete_account').click( function (){
                var id = $(this).attr('data-id');
                $('#overlayer').fadeIn();
                $.ajax({
                    url: '/delete-host-stripe-account',
                    type: 'POST',
                    data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#overlayer').fadeOut();
                        console.log(response);
                        swal({
                          title: "success !",
                          text: response,
                          icon: "success",
                          button: "Done",
                      });
                     },
                error: function(jqXHR, textStatus, errorThrown) {
                        $('#overlayer').fadeOut();
                        // console.log(textStatus, errorThrown);
                        swal({
                          title: "error !",
                          text: textStatus, errorThrown,
                          icon: "error",
                          button: "Failed",
                      });
                    }
                });
            });
        });
    </script>
@endsection