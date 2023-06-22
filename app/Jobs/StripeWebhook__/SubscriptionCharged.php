<?php

namespace App\Jobs\StripeWebhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\HostSubscriptionRenewStatus;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class SubscriptionCharged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
    //    return 'mail sent succesfully';
        $charge = $this->webhookCall->payload['data']['object'];
        // $email = 'developer.ashar@gmail.com';
        // $name = 'abhishek';
        // $status = 'succesfull';
        // Mail::to($email)->send(new HostSubscriptionRenewStatus($name,$status));
       
        Log::debug('Webhook Event Recieved',$this->webhookCall);
        // you can access the payload of the webhook call with `$this->webhookCall->payload`
    }
}
