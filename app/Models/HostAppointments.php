<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class HostAppointments extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'host_available_id','user_id','host_id', 'guest_name','guest_email','start','end','duration_in_minutes','meeting_charges','currency','stripe_payment_intent','payment_status','status','total_duration','video_call_status','questionrie_status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'host_id');
    }
    public function messages(){
        return $this->hasMany(Messages::class,'sender_id','host_id');
    }
    public function usermessages(){
        return $this->hasMany(Messages::class,'sender_id','user_id');
    }
    public function payments(){
        return $this->hasOne(StreamPayment::class,'appoinment_id','_id');
    }
    public function guest(){
        return $this->hasOne(User::class,'_id','user_id');
    }
   public function answers(){
        return $this->hasOne(QuestionarieAnswer::class,'appointment_id','_id');
   }
//    New code for  get host information by host id
   public function hostDetails(){
    return $this->hasOne(User::class, '_id','host_id');
   }
}
