<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipFeature extends Model
{
    use HasFactory;
    protected $table = 'membershipfeatures';
    protected $fillable = [
        'feature_name','description'
    ];
}
