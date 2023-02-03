<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointments extends Model
{
    use HasFactory;

    protected $table = 'appointments2';
    
    protected $fillable = [
        'host_id','title', 'start','status'
    ];

}
