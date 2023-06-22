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
          <div class="col-sm-8">
            <h1 class="m-0">Registered Account Details</h1>
            @if($AccountDetails->active_status == 'false')
            <div class="text text-danger mb-2 mt-2">Your account is not activated please recreate your account and accept terms and conditions.</div>
            @endif
          </div><!-- /.col -->
          <div class="col-sm-4">
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
            <div class="card">
                <h5 class="card-header">Account holder details</h5>
                <div class="card-body">
                    @if(isset($AccountDetails->account_holder_name))
                    <h5 class="">{{ $AccountDetails->account_holder_name}}</h5>
                    @endif
                    @if(isset($AccountDetails->bank_acc_number))
                    <p class="card-text mt-1">Last 4 account number : ****{{ $AccountDetails->bank_acc_number }}</p>
                    @endif
                    @if(isset($AccountDetails->bank_acc_region))
                    <p class="card-text mt-1">Bank region : {{ $AccountDetails->bank_acc_region }}</p>
                    @endif
                    @if(isset($AccountDetails->region_currency))
                    <p class="card-text mt-1">Bank region currency : {{ $AccountDetails->region_currency }}</p>
                    @endif
                    <a href="{{ url('delete-host-stripe-account/'.$AccountDetails->_id) }}" id="delete_stripe_account"  class="btn btn-danger my-3">Delete Account</a>
                </div>
            </div>
        </div>
    </section>
    <script>
        // $(document).ready(function (){
        //     $('.delete_account').click( function (){
        //         var id = $(this).attr('data-id');
        //         $('#overlayer').fadeIn();
        //         $.ajax({
        //             url: '/delete-host-stripe-account',
        //             type: 'POST',
        //             data: {
        //             id: id,
        //             _token: $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             $('#overlayer').fadeOut();
        //                 console.log(response);
        //                 // alert(response);
        //                 Swal.fire({
        //                     title: 'Success',
        //                     text: response,
        //                     icon: 'success',
        //                     showCancelButton: false,
        //                     confirmButtonColor: '#3085d6',
        //                     cancelButtonColor: '#d33',
        //                     confirmButtonText: 'OK'
        //                 }).then((result) => {
        //                   if (result.isConfirmed) {
        //                    window.location.reload();
        //                   }
        //                 })
                     
        //              },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //                 $('#overlayer').fadeOut();
        //                 // alert(textStatus, errorThrown);
        //                 // console.log(textStatus, errorThrown);
        //                 swal({
        //                   title: "error !",
        //                   text: textStatus, errorThrown,
        //                   icon: "error",
        //                   button: "Failed",
        //               });
        //             }
        //         });
        //     });
        // });
    $('#delete_stripe_account').click(function(e){
        e.preventDefault();
       link = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure to delete stripe account?',
            showCancelButton: true,
            confirmButtonText: 'yes',
            confirmButtonColor: '#008000',
            cancelButtonText: 'no',
            cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = link;
                } 
            });  
        });
  
     </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection