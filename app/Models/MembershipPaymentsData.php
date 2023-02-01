<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class MembershipPaymentsData extends Model
{
    use HasFactory;
    
    protected $table = 'membership_payment';

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
