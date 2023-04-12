<?php

namespace App\Models\Discounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class HostDiscount extends Model
{
    use HasFactory;
    protected $table = 'host_discounts_coupons';
    protected $fillable = [
        'coupon_name','coupon_code','host_id', 'percentage_off','duration','duration_times','coupon_used','expiredate','status'
    ];
   
}
