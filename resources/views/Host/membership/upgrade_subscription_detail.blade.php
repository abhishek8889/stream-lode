@extends('host_layout.master')
@section('content')
<!-- Where we add card details after hit upgrade membership button  -->
<div class="center">
    <div class="card card-primary col-md-6">
        <div class="card-header">
            <h3 class="card-title">You have to pay ${{ number_format($membership['amount'],2) }} for {{ $membership['name'] }} every {{ $membership['interval'] }}.</h3>
        </div>
        <div>
            <form id="payment-form" class="paymentForm" action="{{ url(auth()->user()->unique_id.'/upgrade-to-new-subscription') }}" method="POST">
                @csrf
                <input type="hidden" id="payment_method" name="payment_method" value=""/>
                <input type="hidden" name="upgraded_membership_id" value="{{ $membership['_id'] }}">
                @if(!empty($users_payment_methods))
                @foreach($users_payment_methods as $user_payment_method)
                <div>
                    <label class="checkcontainer">
                        <input type="radio" class="paymentMethodSelector" name="default_payment_method" value="{{ $user_payment_method['_id'] }}" />
                        <span class="radiobtn">{{ $user_payment_method['brand'].' ends in '.$user_payment_method['last_4']  }}</span>
                    </label>
                </div>
                @endforeach
                @endif
                <label class="checkcontainer">
                    <input type="radio" name="default_payment_method" class="paymentMethodSelector" value="new_payment_method" />
                    <span class="radiobtn">Add new payment method</span>
                </label>
                <div class="form-wrapper" id="card-form-wrapper" style="display:none;">
                    <div class="card-body">
                        <div class="form-group">
                            <div>
                                <label for="name">Card details</label>
                                <div id="card-elements"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Upgrade membership</button>
                    <button type="submit" class="btn btn-primary" id="default-payment-btn">Upgrade membership</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function(){
        // console.log("");
        $("#card-button").hide();
        $("#default-payment-btn").hide();
        $(".paymentMethodSelector").on('click',function(){
           if($(this).val() == 'new_payment_method'){
                $("#payment_method").val('new_payment_method');
                $("#card-button").show();
                $("#default-payment-btn").hide();
                $("#card-form-wrapper").show();
                $(".paymentForm").attr('id','payment-form');
           }else{
                $("#payment_method").val('default');
                $("#card-button").hide();
                $("#default-payment-btn").show();
                $("#card-form-wrapper").hide();
                $(".paymentForm").attr('id','');
           }
        });
    });
</script>
<script>
    const stripe = Stripe('{{ env('STRIPE_PUB_KEY') }}');
    console.log(stripe);
    const elements= stripe.elements();
    const cardElement= elements.create('card');
    cardElement.mount('#card-elements');

    const form = document.getElementById('payment-form');
    const cardBtn = document.getElementById('card-button');
    const cardHolderName = "{{ auth()->user()->first_name.' '.auth()->user()->last_name}}";
    
    cardBtn.addEventListener('click',function(){
        form.addEventListener('submit', async (e) => {
            e.preventDefault()
            cardBtn.disabled = true
            const { setupIntent, error } = await stripe.confirmCardSetup(
                cardBtn.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }   
                    }
                }
            )
    
            if(error) {
                cardBtn.disable = false
                console.log(error);
            } else {
                let token = document.createElement('input')
                token.setAttribute('type', 'hidden')
                token.setAttribute('name', 'token')
                token.setAttribute('value', setupIntent.payment_method)
                form.appendChild(token)
                form.submit();
            }
        });
    });
</script>
@endsection