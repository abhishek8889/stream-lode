<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class StreamPayment extends Model
{
    use HasFactory;
    protected $table = "streams_payment";
    protected $fillable = [
        'stripe_payment_intent','stripe_payment_method','subtotal','coupon_code','discount_amount','total','appoinment_id','currency'
    ];
}
