<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class MembershipTier extends Model
{
    use HasFactory;
    protected $table = "membership";
    protected $fillable = [
        'mebership_tier_id',
        'price_id',
        'name',
        'logo_name',
        'logo_url',
        'currency',
        'type',
        'interval',
        'amount',
        'status',
        'description',
        'create_at',
        'update_at',
    ];
}
