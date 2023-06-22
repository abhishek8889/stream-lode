<?php

namespace App\Models\Discounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class AdminDiscount extends Model
{
    use HasFactory;
    protected $table = 'admin_discount_coupon';
    // protected $guarded = '*';
}
