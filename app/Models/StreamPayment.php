<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class StreamPayment extends Model
{
    use HasFactory;
    protected $table = "streams_payment";
    protected $fillable = [
        'payment_id','stripe_payment_intent','stripe_payment_method','subtotal','coupon_code','discount_amount','total','appoinment_id','currency','host_id','guest_id','host_stripe_account_id','status',
    ];

    public function appoinments(){
        return $this->hasOne(HostAppointments::class,'_id','appoinment_id');
    }
    public function host(){
        return $this->hasOne(User::class,'_id','host_id');
    }
}
