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
        'slug',
        'currency',
        'type',
        'interval',
        'interval_count',
        'amount',
        'status',
        'create_at',
        'update_at',
    ];

    // public function membershipFeature(){
    //     return $this->belongsTo(Membershipfeature::class,'');

    // }
}
