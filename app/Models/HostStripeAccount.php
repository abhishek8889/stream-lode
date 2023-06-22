<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class HostStripeAccount extends Model
{
    use HasFactory;
    protected $table = 'host_stripe_accounts';
}
