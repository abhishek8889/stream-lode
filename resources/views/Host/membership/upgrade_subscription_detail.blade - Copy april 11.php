@extends('host_layout.master')
@section('content')
<!-- Where we add card details after hit upgrade membership button  -->
<div class="center">
    <div class="card card-primary col-md-6">
        <div class="card-header">
            <h3 class="card-title">You have to pay ${{ $membership['amount'] }} for {{ $membership['name'] }} every {{ $membership['interval'] }}.</h3>
        </div>
        <div>
            <form  action="{{ url(auth()->user()->unique_id.'/upgrade-to-new-subscription') }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method" value="default"/>
            <input type="hidden" name="upgraded_membership_id" value="{{ $membership['_id'] }}">
            @if(!empty($users_payment_methods))
            @foreach($users_payment_methods as $user_payment_method)
            <div>
                <label class="checkcontainer">
                    <input type="radio" name="default_payment_method" value="{{ $user_payment_method['_id'] }}" />
                    <span class="radiobtn">{{ $user_payment_method['brand'].' ends in '.$user_payment_method['last_4']  }}</span>
                </label>
            </div>
            @endforeach
            @endif
            <input type="submit" value="Upgrade Subscription">
                
            </form>
                
        </div>
        <div>

        </div>
        <div class="" style="">
            <form id="payment-form" action="{{ url(auth()->user()->unique_id.'/upgrade-to-new-subscription') }}" method="POST">
            @csrf
            <input type="hidden" name="upgraded_membership_id" value="{{ $membership['_id'] }}">
                <div class="card-body">
                    <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="card-holder-name" name="name" placeholder="Enter your name">
                    </div>
                    <div>
                    <label for="name">Card details</label>
                    <div id="card-elements"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>

    const stripe = Stripe('{{ env('STRIPE_PUB_KEY') }}');
    console.log(stripe);
    const elements= stripe.elements();
    const cardElement= elements.create('card');
    cardElement.mount('#card-elements');

    const form = document.getElementById('payment-form');
    const cardBtn = document.getElementById('card-button');
    const cardHolderName = document.getElementById('card-holder-name');

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
</script>
@endsection