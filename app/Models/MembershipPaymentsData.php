<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\MembershipTier;
use App\Models\PaymentMethods;
class MembershipPaymentsData extends Model
{
    use HasFactory;
    
    protected $table = 'membership_payment';

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function membership_details(){
        return $this->belongsTo(MembershipTier::class,'membership_id');
    }
    public function payments_method(){
        return $this->belongsTo(PaymentMethods::class,'payment_method_id');

    }

}
