<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HostAvailablity extends Model
{
    use HasFactory;

    protected $table = 'host_availablity';
    
    protected $fillable = [
        'host_id','title', 'start','end','status',
    ];

}
