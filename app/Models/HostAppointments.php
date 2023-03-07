<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class HostAppointments extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'host_available_id','user_id','host_id', 'guest_name','guest_email','start','end','status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'host_id');
    }
}
