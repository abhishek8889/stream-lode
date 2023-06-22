<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingCharge extends Model
{
    use HasFactory;
    protected $table = "meeting_charges";
    protected $fillable = [
        'host_id','duration_in_minutes','amount','currency'
    ];
}
